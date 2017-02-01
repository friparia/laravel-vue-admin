@extends('admin::layout')
@section('title', '消息推送')
@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
<script type="text/javascript" charset="utf-8" src="{{ asset('js/utf8-php/ueditor.config.js') }}"></script>
<script type="text/javascript" charset="utf-8" src="{{ asset('js/utf8-php/ueditor.all.min.js') }}"> </script>
<script type="text/javascript" charset="utf-8" src="{{ asset('js/utf8-php/lang/zh-cn/zh-cn.js') }}"></script>

<div class="box box-info">
    <form class="form-horizontal" action="{{ action("\Friparia\Admin\Controllers\MessageController@index", ['action' => 'create']) }}" method="POST">
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
                    <script id="editor" type="text/plain" style="width:100%;height:500px;" name="content"></script>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">推送城市</label>
                <div class="col-sm-10">
                    <select class="form-control" name="city_id">
                        <option value="">全部城市</option>
                        @foreach(App\Models\City::where('parent_code', '!=', '0')->get() as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">推送性别</label>
                <div class="col-sm-10">
                    <select class="form-control" name="city_id">
                        <option value="">全部性别</option>
                        <option value="male">男</option>
                        <option value="female">女</option>
                    </select>
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

