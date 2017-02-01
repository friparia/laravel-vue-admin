<!-- Main Header -->
<header class="main-header">

    <a href="#" class="logo"><b>Admin</b></a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    <!-- <img src="{{ asset("/bower_components/admin&#45;lte/dist/img/user2&#45;160x160.jpg") }}" class="user&#45;image" alt="User Image"/> -->
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- Menu Footer-->
                    <li class="user-footer">
                    <div class="pull-right">
                        <a href="/admin/auth/logout" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                    </li>
                </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<style>
.navbar-nav>.user-menu>.dropdown-menu{
    width:auto;
}
</style>
