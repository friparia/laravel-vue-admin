@extends('admin::layout')
@section('title', '数据报表')
@section('content')
    <script type="text/javascript" src="{{ asset('/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/daterangepicker.js') }}"></script>
    <div class="row">
        <section class="col-lg-12">
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">提现打款表</h3>
                </div>
                <div class="box-body">
                    <form id="export" action="/admin/data/export" class="form">
                        <div class="form-group">
                            <label>日期:</label>

                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="reservation" name="date">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
    <script>
$(function(){
    $('#reservation').daterangepicker();
});
    </script>
@endsection
