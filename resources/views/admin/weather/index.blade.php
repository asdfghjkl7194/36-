@extends('admin/weixin/layouts/index')
@section('title','天气查询页面')
@section('content')

<br><h4>一周气温展示</h4>
城市:<input type="text" name="city" value="北京">
<input type="button" value="搜索" id="search">(城市名称可以为拼音和汉字) <hr>


<!-- 天气图标容器 -->
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<!-- 天气图标插件 -->
<script src="/jquery.js"></script>
<script src="/admin/JShare/highcharts.js"></script>
<script src="/admin/JShare/highcharts-more.js"></script>
<script src="/admin/JShare/exporting.js"></script>
<script src="/admin/JShare/highcharts-zh_CN.js"></script>
<script src="/admin/JShare/themes/grid-light.js"></script>
<script>
$(document).on("click", "#search", function(){
    // 城市名
    var city  = $('[name="city"]').val();
    if(city == ""){
        alert('请填写城市');
        return;
    }
    
    // 正则效验 只能是汉字或者拼音
    var reg = /^[a-zA-Z]+$|^[\u4e00-\u9fa5]+$/;
    var res = reg.test(city);
    if(!res){
        alert('城市名只能为拼音和汉字');
        return;
    }
    $.ajax({
        url:"{{url('admin/weather/index_do')}}",
        data:{city:city},
        dataType:"json",
    }).done(function(res){
        weather(res.result);
    });
})


// 一进入当前页 默认展示北京气温
$.ajax({
    url:"{{url('admin/weather/index_do')}}",
    data:{city:"北京"},
    dataType:"json",
}).done(function(res){
    // 展示天气图标
    weather(res.result);
})


// 封装方法
function weather(weatherData){
    console.log(weatherData);
    var categories = []; // x轴日期
    var data = [];  // x轴日期对应的最高最低气温
    $.each(weatherData, function(i,v){
        console.log(i+'==='+v);
        categories.push(v.days);
        var arr = [parseInt(v.temp_low),parseInt(v.temp_high)];
        data.push(arr);
    });
    showWeather(categories, data);
}


// 展示
function showWeather(categories, data){
    var chart = Highcharts.chart('container', {
    chart: {
        type: 'columnrange', // columnrange 依赖 highcharts-more.js
        inverted: true
    },
    title: {
        text: '每月温度变化范围'
    },
    subtitle: {
        text: '2009 挪威某地'
    },
    xAxis: {
        categories: categories
    },
    yAxis: {
        title: {
            text: '温度 ( °C )'
        }
    },
    tooltip: {
        valueSuffix: '°C'
    },
    plotOptions: {
        columnrange: {
            dataLabels: {
                enabled: true,
                formatter: function () {
                    return this.y + '°C';
                }
            }
        }
    },
    legend: {
        enabled: false
    },
    series: [{
        name: '温度',
        data: data
    }]
});
}
</script>



@endsection