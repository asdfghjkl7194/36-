<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;

class ToolsController extends Controller
{
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
                    'name' => '个人信息', 
                    "sub_button" => [
                        [
                            "name"=>"发送位置", 
                            "type"=>"location_select", 
                            "key"=>"rselfmenu_2_0"
                        ],
                        // [
                        //     "type"=>"media_id", 
                        //     "name"=>"图片", 
                        //     "media_id"=>"MEDIA_ID1"
                        // ], 
                        // [
                        //     "type"=>"view_limited", 
                        //     "name"=>"图文消息", 
                        //     "media_id"=>"MEDIA_ID2"
                        // ]
                    ]
                ],
                [
                    'name' => '菜单',
                    "sub_button" => [
                        [	
                            "type" => "view",
                            "name" => "搜索",
                            "url" => "http://www.soso.com/"
                        ],
                        [
                            "type" => "click",
                            "name" => "赞一下我们",
                            "key" => "rselfmenu_0_0"
                        ]
                    ]
                ],
                [
                    "name" => "扫码", 
                    "sub_button" => [
                        [
                            "type" => "scancode_waitmsg", 
                            "name" => "扫码带提示", 
                            "key" => "rselfmenu_0_0", 
                        ], 
                        [
                            "type" => "scancode_push", 
                            "name" => "扫码推事件", 
                            "key" => "rselfmenu_0_1", 
                        ]
                    ]
                ], 

            ]
        ];
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $res = Wechat::curlPost($url, $data);
        dd($res);
    }
}
