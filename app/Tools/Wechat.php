<?php

namespace App\Tools;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Cache;

class Wechat extends Model
{
    const appid = 'wxac662ac6ed41deb6';
    const secret = '390e283bab6176a426c754bc87b28d69';


    /**
     * 上传图片
     */
    public static function  uploading($rouHref){

    }



    /**
     * 调用天气
     */
    public static function getWeather($weather){    // weather 地区
        if(empty($weather))$weather = 1;

        $weatheStr = Cache::get('weatheStr_'.$weather);
        if(empty($weatheStr)){
            $url = 'http://api.k780.com:88/?app=weather.future&weaid='.$weather.'&&appkey=47853&sign=da259b4ff62b205e76595199a19cc507&format=json';
            $weatherData = file_get_contents($url);
            $weatherData = json_decode($weatherData, true);
            $weatheStr = '';
            foreach($weatherData['result'] as $v){
                $weatheStr .= $v['days'].' '.$v['week'].' '.$v['citynm'].' '.$v['temperature']."\n";
            }
            Cache::put('weatheStr_'.$weather, $weatheStr, 3600);    // 保存一小时
        }

        return $weatheStr;
    }


    /**
     * 获取用户信息
     */
    public static function getUserInfo($openid)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.self::getAccessToken().'&openid='.$openid.'&lang=zh_CN';
        $data = file_get_contents($url);
        return json_decode($data, true);
        
      /*
                            array:16 [
用户是否订阅该公众号1订阅0未订阅  "subscribe" => 1
对当前公众号唯一                 "openid" => "ouMSqw4gGGtbEwL1DUe7glaGkhUc"
用户的昵称                       "nickname" => "魅力"
用户的性别1男2女0未知             "sex" => 0
城市                             "language" => "zh_CN"
国家                             "city" => ""
省份                             "province" => ""
语言，简体中文为zh_CN             "country" => ""
用户头像                         "headimgurl" => "http://thirdwx.qlogo.cn/mmopen/1L64FTzmakdN35wNbcUOY2HUCuicSSTtoDR6lvZAubxPNicr1erYd7QQqZaMPCyT7bibwQPxx9z0n6RsbUECUtibEhIN5pqbyGaO/132"
用户关注时间                      "subscribe_time" => 1578396268
对粉丝的备注                      "remark" => ""
用户所在的分组ID                  "groupid" => 0
用户被打上的标签ID列表             "tagid_list" => []
关注的渠道来源->扫描二维码         "subscribe_scene" => "ADD_SCENE_QR_CODE"
二维码扫码场景                    "qr_scene" => 0
二维码扫码场景描述                 "qr_scene_str" => ""
                             ]
        */
    }
    public static function getUserName($openid){
        return self::getUserInfo($openid)['nickname'];
    }
    public static function getUserSex($openid){
        $data = self::getUserInfo($openid)['sex'];
        if($data == 1){
            $data = '先生';
        }elseif($data == 2){
            $data = '女士';
        }else{
            $data = '客户';
        }
        return $data;
    }


    /**
     * 获取二维码
     */
    public static function getTicket($status)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.self::getAccessToken();
        //$postData = '{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}';       // 下边的比这里多 汉字可以转换为编码
        $postData = [
            'expire_seconds' => 259200, // 30天
            'action_name' => 'QR_STR_SCENE',
            'action_info' => [
                'scene' => [
                    'scene_str' => $status,
                ]
            ]
        ];
        $postData = json_encode($postData);
        $ticket = self::curlPost($url, $postData);
        return json_decode($ticket, true)['ticket'];
    }

    /**
     * 获取access_token
     */
    public static function getAccessToken()
    {
        $accessToken = Cache::get('accessToken');
        if(empty($accessToken)){
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::appid.'&secret='.self::secret;
            $accessToken = file_get_contents($url);
            $accessToken = json_decode($accessToken, true);
            $accessToken = $accessToken['access_token'];
            Cache::put('accessToken', $accessToken, 3600); // 存储一小时
        }
        return $accessToken;
    }
    public static function getAccessTokens(){    // 强制获取
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.self::appid.'&secret='.self::secret;
        $accessToken = file_get_contents($url);
        $accessToken = json_decode($accessToken, true);
        $accessToken = $accessToken['access_token'];
        Cache::put('accessToken', $accessToken, 3600); // 存储一小时
        return $accessToken;
    }
    


    /*
1 回复文本消息echoText
2 回复图片消息echoImage
3 回复语音消息echoVoice
4 回复视频消息echoVideo
5 回复音乐消息echoMusic
6 回复图文消息echoNews*/
    public static function echoText($xmlObj, $data)
    {
        echo '
            <xml>
                <ToUserName><![CDATA['.$xmlObj->FromUserName.']]></ToUserName>
                <FromUserName><![CDATA['.$xmlObj->ToUserName.']]></FromUserName>
                <CreateTime>'.time().'</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA['.$data.']]></Content>
            </xml>
        ';
    }


    /**
     * curl发送数据
     */
    public static function curlPost($url, $data){
        //初使化init方法
        $ch = curl_init();
        //指定URL
        curl_setopt($ch, CURLOPT_URL, $url);
        //设定请求后返回结果
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //声明使用POST方式来进行发送
        curl_setopt($ch, CURLOPT_POST, 1);
        //发送什么数据呢
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //忽略证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        //忽略header头信息
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //设置超时时间
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        //发送请求
        $output = curl_exec($ch);
        //关闭curl
        curl_close($ch);
        //返回数据
        return $output;
    }
}
