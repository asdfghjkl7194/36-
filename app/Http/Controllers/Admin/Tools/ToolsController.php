<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;

class ToolsController extends Controller
{
    /**
     * 用户签到
     */
    public function signIn(){
        dd('签到成功');
    }



    /**
     * 展示工具栏
     */
    public function index(){
        return view('admin/tools/index');
    }


    /**
     * 执行添加
     */
    public function index_do(){
        //$data = request()->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.Wechat::getAccessToken();
        $data = [
            'button' => [
                [
                    "type"=>"view", 
                    "name"=>"签到啦", 
                    "url"=>"https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('APPID')."&redirect_uri=".urlencode('http://1907.liuhe.run/signIn')."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
                ],
            ]
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $res = Wechat::curlPost($url, $data);
        dd($res);
    }
}
