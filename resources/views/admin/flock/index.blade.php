@extends('admin/weixin/layouts/index')
@section('title','展示页面')
@section('content')

<b><font color="red">{{session('find')}}</font></b>
<div class="container">
<form role="form form-horizontal" action="{{url('admin/flock/index_do')}}" method="post">
	@csrf

  <div class="form-group">
    <label for="name">标题</label>
    <input class="form-control" name="title" type="text" disabled>
  </div>
  
  <div class="form-group">
    <label for="name">内容</label>
    <textarea class="form-control" name="text" rows="3" ></textarea>
  </div>
  
  <div class="form-group">
    <label for="name">发送给谁</label>
    <select multiple class="form-control" name="userName[]">
      <option value="1" selected>所有用户</option>
      @foreach($clientData as $v)
      <option value="{{$v->openid}}">{{$v->nickname}}</option>
      @endforeach
    </select>
  </div>
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">发送</button>
    </div>
  </div>
  
</form>
</div>


@endsection