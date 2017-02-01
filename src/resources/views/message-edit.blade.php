@extends('admin::layout')
@section('title', '消息推送')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<script type="text/javascript" charset="utf-8" src="{{ asset('js/utf8-php/ueditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('js/utf8-php/ueditor.all.min.js') }}"> </script>
<script type="text/javascript" charset="utf-8" src="{{ asset('js/utf8-php/lang/zh-cn/zh-cn.js') }}"></script>

<div class="box box-info">
    <form class="form-horizontal" action="{{ action("\Friparia\Admin\Controllers\MessageController@index", ["action" => 'update', 'id' => $message->id]) }}" method="POST">
        <div class="box-body">
            <div class="form-group">
                <label class="col-sm-2 control-label">标题</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="title" value="{{ $message->title or ''}}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">内容</label>
                <div class="col-sm-10">
                    <script id="editor" type="text/plain" style="width:100%;height:500px;" name="content">{!! $message->content !!}</script>
                </div>
            </div>
            <button type="submit" id="save-btn" class="btn btn-primary pull-right">保存</button>
        </div>
    </form>
</div>
<script >
$(document).ready(function(){
    var ue = UE.getEditor('editor');
});
</script>
@endsection

