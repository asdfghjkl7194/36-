@extends('admin/weixin/layouts/index')
@section('title','添加页面')
@section('content')

<center>
<h1>公众号 工具栏 添加</h1>
</center>
不可使用,改代码
<form action="{{url('admin/tools/index_do')}}" method="post">
	<div style="margin-top:5%;" class="container">
		<table class="table">
		  <caption>边框表格布局</caption>
		  <thead>
		    <tr>
		    	<td><input type="text" name="e1" value="" placeholder="工具栏1_5"/></td>
		    	<td><input type="text" name="e2" value="" placeholder="工具栏2_5"/></td>
		    	<td><input type="text" name="e3" value="" placeholder="工具栏3_5"/></td>
		    </tr>
		    <tr>
		    	<td><input type="text" name="d1" value="" placeholder="工具栏1_4"/></td>
		    	<td><input type="text" name="d2" value="" placeholder="工具栏2_4"/></td>
		    	<td><input type="text" name="d3" value="" placeholder="工具栏3_4"/></td>
		    </tr>
		    <tr>
		    	<td><input type="text" name="c1" value="" placeholder="工具栏1_3"/></td>
		    	<td><input type="text" name="c2" value="" placeholder="工具栏2_3"/></td>
		    	<td><input type="text" name="c3" value="" placeholder="工具栏3_3"/></td>
		    </tr>
		    <tr>
		    	<td><input type="text" name="b1" value="" placeholder="工具栏1_2"/></td>
		    	<td><input type="text" name="b2" value="" placeholder="工具栏2_2"/></td>
		    	<td><input type="text" name="b3" value="" placeholder="工具栏3_2"/></td>
		    </tr>
		    <tr>
		    	<td><input type="text" name="a1" value="" placeholder="工具栏1_1"/></td>
		    	<td><input type="text" name="a2" value="" placeholder="工具栏2_1"/></td>
		    	<td><input type="text" name="a3" value="" placeholder="工具栏3_1"/></td>
		    </tr>
		  </thead>
		  <tbody>
		    <tr class="success">
		      <th><input type="text" name="one1" value="" placeholder="工具栏1"/></th>
		      <th><input type="text" name="one2" value="" placeholder="工具栏1"/></th>
		      <th><input type="text" name="one3" value="" placeholder="工具栏1"/></th>
		    </tr>
            <tr>
            	<th colspan="3"><input type="submit" value="添加" /></th>
            </tr>
		  </tbody>
		</table>
	</div>
</form>


@endsection