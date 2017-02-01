<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" style="height: auto;">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            @if(Auth::user()->is_manager)
            @foreach (Friparia\Admin\Models\Menu::where('pid', 0)->get() as $menu)
            <li class="treeview">
            <a href="{{ $menu->url }}">
                <span>{{ $menu->name }}</span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu" style="display: none;">
                    @foreach(Friparia\Admin\Models\Menu::where('pid', $menu->id)->get() as $submenu)
                    {{-- @if(Auth::user()->canVisit($submenu->url)) --}}
                    <li><a href="{{ $submenu->url }}"><i class="fa fa-circle-o"></i>{{ $submenu->name }}</a></li>
                    {{-- @endif --}}
                    @endforeach
            </ul>
            </li>
            @endforeach
            @elseif(Auth::user()->is_trader)
            <li><a href="/admin/jobs"><i class="fa fa-circle-o"></i>推广任务管理</a></li>
            <li><a href="/admin/user/all"><i class="fa fa-circle-o"></i>员工管理</a></li>
            <li><a href="/admin/trader/show/{{ Auth::user()->trader() }}"><i class="fa fa-circle-o"></i>账户信息</a></li>
            @elseif(Auth::user()->trader_id != 0)
            <li><a href="/admin/jobs"><i class="fa fa-circle-o"></i>推广任务管理</a></li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

