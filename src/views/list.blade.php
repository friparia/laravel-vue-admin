@extends('admin::layout')
@section('content')
<div class="ui grid">
    <div class="one wide column">
    </div>
    <div class="fifteen wide column right aligned">
        <form id="search" action="">
        @foreach ($instance->getFilterableColumns() as $column)
        <input type="hidden" name="{{ $column->name }}" value="{{ $query[$column->name] or '' }}">
        @endforeach
        @foreach ($instance->getSearchableColumns() as $column)
        <div class="ui right labeled input">
            <input type="text" placeholder="查询{{ $column->description }}" name="{{ $column->name }}">
            <div class="ui basic label">
                {{ $column->description }}
            </div>
        </div>
        @endforeach
        @if (count($instance->getSearchableColumns())) 
        <div class="ui button action blue search">
            <i class="search icon"></i>
            搜索
        </div>
        @endif
        @foreach($instance->getSingleActions() as $action => $info)
        <div class="ui button action {{ $action }} {{ $info['color'] or '' }}">
            <i class="{{ $info['icon'] or 'edit' }} icon"></i>
            {{ $info['description'] or $action }}
        </div>
        @endforeach
        </form>
    </div>
</div>
<table class="ui table celled">
    <thead>
        <tr>
            @foreach($instance->getListableColumns() as $column)
            <th>
                @if($instance->canFilterColumn($column->name))
                <select class="ui dropdown filter" name="{{ $column->name }}">
                    <option value="0">全部{{ $column->description }}</option>
                    @foreach($instance->getValueGroups($column->name) as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>
                @else
                {{ $column->description or $column->name }}
                @endif
            </th>
            @endforeach
            <th>
                操作
            </th>
        </tr>
    </thead>
    @foreach($data as $item)
    <tr>
        @foreach($instance->getListableColumns() as $column)
        <td>
            @if($instance->isSwitchable($column->name))
            <div class="ui toggle checkbox">
                <input data-id="{{ $item->id }}" class="switch" type="checkbox" name="{{ $column->name }}" @if($item->getValue($column->name)) checked @endif>
                <label></label>
            </div>
            @else
            {{ $item->getValue($column->name) }}
            @endif
        </td>
        @endforeach
        <td>
            @foreach($instance->getEachActions() as $action => $info)
            <button class="ui basic button action {{ $action }} {{ $info['color'] or ''}}" data-id="{{ $item->id }}">
                <i class="{{ $info['icon'] or 'edit' }} icon"></i>
                {{ $info['description'] or $action }}
            </button>
            @endforeach
        </td>
    </tr>
    @endforeach
</table>
<script>
$(function(){
    @foreach($instance->getSingleActions() as $action => $info)
    $('.button.action.{{ $action }}').click(function(){
        @if ($info['type'] == 'confirm')
            Dialog.confirm('确认{{ $info['description'] or $action}}?', '{{ action($controller."@admin", ["action" => $action]) }}' );
        @elseif ($info['type'] == 'modal')
            Dialog.modal('{{ action($controller."@admin", ["action" => $action]) }}');
        @else
            location.href = '/admin/{{ $info['url'] }}';
        @endif
    });
    @endforeach
    @foreach($instance->getEachActions() as $action => $info)
    $('.button.action.{{ $action }}').click(function(){
        var id = $(this).data('id');
        @if ($info['type'] == 'confirm')
            Dialog.confirm('确认{{ $info['description'] or $action}}?', '{{ action($controller."@admin", ["action" => $action]) }}/' + id);
        @elseif ($info['type'] == 'modal')
            Dialog.modal('{{ action($controller."@admin", ["action" => $action]) }}/' + id);
        @else
            location.href = '/admin/{{ $info['url'] }}' + id;
            @endif
    });
    @endforeach
    $('.filter').change(function(){
        $('#search input[name=' + $(this).attr('name') + ']').val($(this).val());
        $('#search').submit();
    });
    $('.switch').change(function(){
        var id = $(this).data('id');
        var obj = {};
        obj[$(this).attr('name')] = $(this).prop('checked');
        $.post('{{ action($controller."@admin", ["action" => 'update']) }}/' + id, obj, function(){
            location.reload();
        });

    });
    $('.search').click(function(){
        $('#search').submit();
    });
    $('.ui.toggle.checkbox').checkbox();
});
</script>
@endsection
