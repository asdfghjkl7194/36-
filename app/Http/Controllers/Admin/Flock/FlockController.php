<?php

namespace App\Http\Controllers\Admin\Flock;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;
use App\Admin\Yard\Client;

class FlockController extends Controller
{
    function index(){
        $clientData = Client::get();
        return view('admin/flock/index',['clientData'=>$clientData]);
    }

    function index_do(){
        $title = request()->title;
        $text = request()->text;
        $userName = request()->userName;

        $arr = [];
        if($userName[0] == 1){
            $clientData = Client::select('openid')->get()->toArray();
            $arr = array_column($clientData, 'openid');
        }else{
            foreach($userName as $v){
                $arr[] = $v;
            }
        }

        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.Wechat::getAccessToken();
        $data = [
            "touser" => $arr
            ,
            "msgtype" => "text",
            "text" => [ 
                 "content" => $text
            ]
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $res = Wechat::curlPost($url, $data);

        $res = json_decode($res, true);
        if($res['errcode'] == 0){
            return redirect('admin/flock/index')->with('find', '发送成功');
        }else{
            $errStr = '';
            if($res['errcode'] == 40130)
                $errStr .= ' 至少选择两个用户';
            elseif($res['errcode'] == 45065)
                $errStr .= ' 内容重复请切换内容后再试';

            return redirect('admin/flock/index')->with('find', '发送失败错误码是:'.$res['errcode'].$errStr);
        }

    }
}
