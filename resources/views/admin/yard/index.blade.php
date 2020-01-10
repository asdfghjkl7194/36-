@extends('admin/weixin/layouts/index')
@section('title','展示页面')
@section('content')
<a href="{{url('admin/yard/create')}}">添加二维码</a>
<center><h2>用户关注展示</h2></center>
<table class="table table-striped table-border">
  <caption><b><font color="red">{{session('find')}}</font></b><br></caption>
  <thead>
    <tr>
      <th>ID</th>
      <th>名称</th>
      <th>标识</th>
      <th>二维码</th>
      <th>关注总人数<b><font color="red">{{$cNum-$nNum}}</font></b></th>
      <th>取关总人数<b><font color="red">{{$nNum}}</font></b></th>
      <th>添加时间</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
    @foreach($channelData as $v)
    <tr>
      <td>{{$v->c_id}}</td>
      <td>{{$v->c_name}}</td>
      <td>{{$v->c_status}}</td>
      <td><img src="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={{$v->ticket}}" width="100px"></td>
      <td><b><font color="red">{{$v->c_num-$v->n_num}}</font></b></td>
      <td><b><font color="red">{{$v->n_num}}</font></b></td>
      <td>{{$v->created_at}}</td>
      <td>
        <button type="button" class="btn btn-info">修改</button>
        <button type="button" class="btn btn-danger">删除</button>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
<script src="/admin/JShare/exporting.js"></script>
<script src="/admin/JShare/highcharts.js"></script>
<script src="/admin/JShare/highcharts-zh_CN.js"></script>
<script src="/admin/JShare/oldie.js"></script>
<!-- 图表容器 DOM -->
<div id="container" style="width: 600px;height:400px;"></div>
<script>
    // 图表配置
    var options = {
        chart: {
            type: 'bar'                          //指定图表的类型，默认是折线图（line）
        },
        title: {
            text: '我的第一个图表'                 // 标题
        },
        xAxis: {
            categories: [{!! $c_name_arr !!}]   // x 轴分类
        },
        yAxis: {
            title: {
                text: '总人数'                // y 轴标题
            }
        },
        series: [{                              // 数据列
            name: '关注人数',                        // 数据列名
            data: [{!! $cNums !!}]                     // 数据
        }, {
            name: '取关人数',
            data: [{!! $nNums !!}]
        }]
    };
    // 图表初始化函数
    var chart = Highcharts.chart('container', options);
</script>

@endsection