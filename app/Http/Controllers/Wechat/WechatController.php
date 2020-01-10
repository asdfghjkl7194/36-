<?php

namespace App\Http\Controllers\Wechat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat as WC;
use App\Admin\Yard\Channel;
use App\Admin\Yard\Client;

class WechatController extends Controller
{
    const arr = ['文安生','空',' 王振国','高泽栋','讲师','许香巧','李倩','陈香妃','刘赫','樊志豪','李敬辉','陈恩鹏','刘士坤','敦梦阳','郭自文','史佳奇','施帅波','关天龙','过','道','张孟洋','张攀峰','空','孙佳豪','牛群','刘波','翟成历','范培轩','薛彬英','陈广通','范相宾','王至伟','樊帅龙','张晨','李洪阳','吕心'];

    public function wechat(){
        // 回复微信服务器   签名的随机字符串
        // echo $_GET['echostr'];

        $wechatData = file_get_contents('php://input');
        file_put_contents('log.txt', $wechatData."\n", FILE_APPEND);
        $xmlObj = simplexml_load_string($wechatData);
        $openid = $xmlObj->FromUserName;

       
        /**
         * 保存用户发过来的图片
         */
        if($xmlObj->MsgType == 'image'){
            $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.WC::getAccessToken().'&media_id='.$xmlObj->MediaId;
            $data = file_get_contents($url);
            $href = 'index/weiXinUserImage/'.md5(uniqid()).'.jpg';
            $res = file_put_contents($href, $data);
            WC::echoText($xmlObj, '感谢您上传的图片');
        }


        /**
         * 用户关注取关事件
         */
        if($xmlObj->MsgType == 'event' && $xmlObj->Event == 'subscribe'){

            // 获取用户数据
            $userData = WC::getUserInfo($openid);

            // 再次关注=修改    首次关注=添加    
            $clientUser = Client::where('openid', $openid)->first();
            $userNum = '';  // 提示用户这是第几次关注
            if($clientUser){
                $qr_scene_str = Client::where('openid', $openid)->value('qr_scene_str');
                Channel::where('c_status', $qr_scene_str)->decrement('n_num');
                Channel::where('c_status', $qr_scene_str)->decrement('c_num');
                Client::where('openid', $openid)->update([
                    'subscribe_time'=> $userData['subscribe_time'],
                    'qr_scene_str'  => $userData['qr_scene_str'],
                    'is_del' => 1
                ]);
                Client::where('openid', $openid)->increment('num');
                $num = Client::where('openid', $openid)->value('num');
                $userNum = ',这是您第'.$num.'次关注';
            }else{
                Client::insert([
                    'openid'    => $userData['openid'],
                    'nickname'  => $userData['nickname'],
                    'sex'       => $userData['sex'],
                    'subscribe_time'    => $userData['subscribe_time'],
                    'remark'    => $userData['remark'],
                    'groupid'   => $userData['groupid'],
                    'subscribe_scene'   => $userData['subscribe_scene'],
                    'qr_scene'  => $userData['qr_scene'],
                    'qr_scene_str'      => $userData['qr_scene_str'],
                    'is_del'  => 1
                ]);
            }
            Channel::where('c_status', $userData['qr_scene_str'])->increment('c_num');

            // 提示关注消息
            if(empty($xmlObj->EventKey)){   // 普通增加用户
                WC::echoText($xmlObj, '尊敬的'.WC::getUserName($openid).WC::getUserSex($openid).'关注'.$userNum);
            }else{   // 指定地点增加用户
                $channelName = Channel::where('c_status', $userData['qr_scene_str'])->value('c_name');
                WC::echoText($xmlObj, '尊敬的❤'.WC::getUserName($openid).'❤'.WC::getUserSex($openid).'欢迎您在---'.$channelName.'---关注'.$userNum);
            }

        }elseif($xmlObj->MsgType == 'event' && $xmlObj->Event == 'unsubscribe'){
            // 获取用户数据
            $openid = $xmlObj->FromUserName;
            Client::where('openid', $openid)->update(['is_del'=>0]);
            $qr_scene_str = Client::where('openid', $openid)->value('qr_scene_str');
            Channel::where('c_status', $qr_scene_str)->increment('n_num');
        }


        /**
         * 用户消息回复
         */
        if($xmlObj->MsgType == 'text'){
            $content = trim($xmlObj->Content);
            $reg = '/天气|状况|地区|怎样|天气情况/';
            if($content == 1){
                $str = '';foreach(self::arr as $v)$str .= $v.',';
                WC::echoText($xmlObj, $str);
            }elseif($content == 2){
                WC::echoText($xmlObj, self::arr[array_rand(self::arr)]);
            }elseif(preg_match($reg, $content) > 0){
                WC::echoText($xmlObj, WC::getWeather(preg_replace($reg, '', $content)));
            }
        }


    }
}
