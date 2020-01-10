@extends('admin/weixin/layouts/index')
@section('title','添加页面')
@section('content')

<!-- 
	name起名为files
-->
<div style="margin-top:5%;" class="container">
<center><h2>添加资源</h2></center>
<form method="post" action="{{url('admin/weixin/store')}}" role="form" enctype="multipart/form-data">
	@csrf

	<table class="table table-bordered">
		<tr>
			<td>名称:</td>
			<td><input type="text" name="r_name" value="图片1" placeholder="请输入名称"></td>
		</tr>
		<tr>
			<td>类型:</td>
			<td>
				<label><input type="radio" name="r_type" value="1" checked>图片</label>
				<label><input type="radio" name="r_type" value="2">语音</label>
				<label><input type="radio" name="r_type" value="3">视频</label>
			</td>
		</tr>
		<tr>
			<td>文件输入:</td>
			<td><input type="file" name="r_file"></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<label> <input type="radio" name="r_state" value="1" checked>临时 </label>
				<label> <input type="radio" name="r_state" value="2" disabled>永久 </label>
			</td>
		</tr>
		<tr>
			<th colspan="2"><button type="submit" class="btn btn-default">提交</button></th>
		</tr>
	</table>
  	
</form>
</div>

@endsection