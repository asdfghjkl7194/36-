<?php

namespace App\Http\Controllers\Admin\Weathe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    /**
     * 搜索天气
     */
    public function index()
    {
        return view('admin/weather/index');
    }
    public function index_do(){
        // 如果是ajax请求 调用天气接口
        if(request()->ajax()){
            // 读取换出
            $city = request('city');
            // 北京 weatherData_北京
            // 天津 weatherData_天津
            $cache_name = 'weatherData_'.$city;
            $data = Cache::get($cache_name);
            if(empty($data)){
                // 调用天气接口
                $url = 'http://api.k780.com:88/?app=weather.future&weaid='.$city.'&&appkey=47853&sign=da259b4ff62b205e76595199a19cc507&format=json';
                // 发请求
                $data = file_get_contents($url);
                // 缓存数据 只到当前24点 (获取24点时间 - 当前时间)
                // echo data("Y-m-d);die; 2019-7-112 time date strtotime
                $time24 = strtotime(date('Y-m-d'))+86400;   // 保存一天
                $second = $time24 - time();
                /**
                 * 我的理解
                 * 1. 获取当天凌晨的时间 加一天 变为第二天凌晨0分0秒
                 * 2. 再用第二天的时间 减去当前时间 就是剩余到第二天凌晨0分0秒的时间
                 */

                Cache::put($cache_name, $data, $second);
            }
            // 把调接口得到的json格式天气数据返回
            echo $data;die;
        }
    }
    

}
