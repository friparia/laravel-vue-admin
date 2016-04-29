@extends('admin::layout')
@section('content')
<table class="ui table celled">
    <thead>
        <tr>
            @foreach($instance->getListableColumns() as $column)
            <th>
                {{ $column->description }}
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
            {{ $item->getValue($column->name) }}
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
    @foreach($instance->getEachActions() as $action => $info)
    $('.button.action.{{ $action }}').click(function(){
        var id = $(this).data('id');
        @if ($info['type'] == 'confirm')
            Dialog.confirm('确认{{ $info['description'] or $action}}?', '{{ action($controller."@admin", ["action" => $action]) }}/' + id);
        @elseif ($info['type'] == 'modal')
            Dialog.modal('{{ action($controller."@admin", ["action" => $action]) }}/' + id);
        @else
            location.href = '/admin/{{ $info['url'] }}';
            @endif
    });
    @endforeach
});
</script>
@endsection
