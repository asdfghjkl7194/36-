@extends('admin/weixin/layouts/index')
@section('title','展示页面')
@section('content')

<table class="table table-striped">
  <caption><b><font color="red">{{session('find')}}</font></b></caption>
  <thead>
    <tr>
      <th>ID</th>
      <th>文件名</th>
      <th>文件类型</th>
      <th>是否永久</th>
      <th>图片</th>
      <th>添加时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    @foreach($reData as $v)
    <tr>
      <td>{{$v->r_id}}</td>
      <td>{{$v->r_name}}</td>
      <td>{{$v->r_type == 1 ? '图片' : $v->r_type == 2 ? '语音' : '视频'}}</td>
      <td>{!! $v->r_state == 1 ? '√' : '<font color="red">×</font>' !!}</td>
      <td>
        @if($v->r_type == 1)
        <img src="https://api.weixin.qq.com/cgi-bin/media/get?access_token={{$access_token}}&media_id={{$v->media_id}}" alt="" width="100" height="60">
        @elseif($v->r_type == 2)
        <a href="{{$v->r_file}}">点击下载音频</a>
        <!-- <audio src="\{{$v->r_file}}" controls="controls">本地使用</audio> -->
        @elseif($v->r_type == 3)
        <video src="{{$v->r_file}}" controls="controls"></video>
        <!-- <video src="\{{$v->r_file}}" controls="controls">本地使用</video> -->
        @endif
      </td>
      <td>{{$v->created_at}}</td>
      <td>
        <button type="button" class="btn btn-info">编辑</button>
        <button type="button" class="btn btn-warning">删除</button>
      </td>
    </tr>
    @endforeach
    <tr>
      <td colspan="7">
        {{$reData}}
      </td>
    </tr>
  </tbody>
</table>

@endsection