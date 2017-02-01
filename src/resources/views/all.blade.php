@extends('admin::layout')
@section('title', $instance->getTitle())
@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="box-tools">
                    <form id="search" action="" class="form form-inline">
                        @foreach($instance->getFilterableFields() as $field)
                        <div class="form-group">
                            <select class="form-control" name="{{ $field->name }}">
                                <option value="">全部{{ $field->description }}</option>
                                @foreach($instance->getFilterOptions($field) as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endforeach
                        <div class="input-group input-group-sm" style="width: 150px;">
                            @if(count($instance->getSearchableFields()))
                                <input type="text" name="q" class="form-control pull-right" placeholder="搜索">
                            @endif
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                @foreach($instance->getSingleActions() as $action)
                                <button type="button" class="btn btn-{{ $action->color }} action single {{ $action->name }}">{{ $action->description }}</button>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                    <tr>
                        @foreach($instance->getListableFields() as $field)
                        <th>{{ $field->description }}</th>
                        @endforeach
                        @if($instance->hasEachAction())
                        <th>操作</th>
                        @endif
                    </tr>
                    @foreach($data as $item)
                    <tr>
                        @foreach($instance->getListableFields() as $field)
                        @if($field->canSwitch())
                        <td><input type="checkbox" name="switch" @if($item->getFieldValue($field) == "是") checked @endif data-size="mini" data-name="{{ $field->name }}" data-id="{{ $item->id }}"></td>
                    @else
                        <td>{{ $item->getFieldValue($field) }}</td>
                        @endif
                        @endforeach
                        @if($instance->hasEachAction())
                        <td>
                            @foreach($instance->getEachActions() as $action)
                                <button type="button" class="btn btn-{{ $action->color }} action each {{ $action->name }}" data-id="{{ $item->id }}">{{ $action->description }}</button>
                            @endforeach
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </table>
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            {!! $data->appends(request()->input())->render() !!}
            </div>
        </div>
        <!-- /.box -->
    </div>
</div>
<div class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">关闭</button>
                <button type="button" id="save-btn" class="btn btn-primary">保存</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
$(function(){
    $("[name='switch']").bootstrapSwitch('onSwitchChange', function(){
        $.post('{{ action($controller."@index", ['action' => 'switch']) }}/' + $(this).data('id'), {name: $(this).data('name')}, function(ret){
            location.reload();
        });
    });
    @foreach($instance->getSingleActions() as $action)
    @if($action->type == 'modal')
    $('.action.single.{{ $action->name }}').on('click', function(){
        $.get('{{ action($controller."@index", ['action' => $action->name]) }}', function(ret){
            $('.modal-body').html(ret);
            $('.modal-title').html('{{ $action->description }}');
            $('.modal').modal();
        });
    });
    @elseif($action->type == 'url')
    $('.action.single.{{ $action->name }}').on('click', function(){
        location.href = '{{ action($controller."@index", ['action' => $action->name] )}}';
    });
    @endif
    @endforeach
    @foreach($instance->getEachActions() as $action)
    @if($action->type == 'modal')
    $('.action.each.{{ $action->name }}').on('click', function(){
        $.get('{{ action($controller."@index", ['action' => $action->name]) }}/' + $(this).data('id'), function(ret){
            $('.modal-body').html(ret);
            $('.modal-title').html('{{ $action->description }}');
            $('.modal').modal();
        });
    });
    @elseif($action->type == 'url')
    $('.action.each.{{ $action->name }}').on('click', function(){
        location.href = '{{ action($controller."@index", ['action' => $action->name]) }}/' + $(this).data('id');
    });
    @endif
    @endforeach
    $('#save-btn').on('click', function(){
        $('#admin-form').submit();
    });
});
</script>
@endsection

