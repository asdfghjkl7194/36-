@extends('admin/weixin/layouts/index')
@section('title','展示页面')
@section('content')

<a href="{{url('admin/yard/index')}}">展示二维码</a>
<div class="container">
<center><h2>生成二维码</h2></center>
<form action="{{url('admin/yard/store')}}" class="form-horizontal" role="form">
  <div class="form-group">
    <label class="col-sm-2 control-label">名称</label>
    <div class="col-sm-10">
      <input type="text" name="c_name" class="form-control" placeholder="如:新闻">
    </div>
  </div>
  <div class="form-group">
    <label class="col-sm-2 control-label">标识</label>
    <div class="col-sm-10">
      <input type="number" name="c_status" min="100" max="999" value="100" class="form-control" placeholder="如:100">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">添加</button>
    </div>
  </div>
</form>
</div>

@endsection