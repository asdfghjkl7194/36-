<?php

namespace App\Http\Controllers\Admin\Weixin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;
use App\Admin\Weixin\Resource as RS;

class WeixinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rsData = RS::paginate(3);
        foreach($rsData as $k=>$v){
            if($v->r_type != 1){
                $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.Wechat::getAccessTokens().'&media_id='.$v->media_id;
                $data = file_get_contents($url);
                $data = json_decode($data, true);
                if($v->r_type == 2){
                    $rsData[$k]['r_file'] = $url;   // $data['voice_url']; // 获取不到 可以下载,气死我了
                }elseif($v->r_type == 3){
                    $rsData[$k]['r_file'] = $data['video_url'];    // 这里本地报错所以加上了@       呵呵令牌错误了   本地环境和线上不一样,线下获取,线上不可用,线上获取线下不可用所以就成了死循环
                }
            }
        }
        return view('admin/weixin/index', ['reData'=>$rsData, 'access_token'=>Wechat::getAccessToken()]);
    }
    public function index_v1(){
        return view('admin/weixin/index_v1');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/weixin/create');
    }

    /**
     * Store a newly created resource in storage.
     * 添加文件
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $fileData = $request->except('_token');

        if ($request->hasFile('r_file')) {

            if($fileData['r_type'] == 1)        $names = 'image';   // image 图片=1
            elseif($fileData['r_type'] == 2)    $names = 'voice';   // voice 语音=2
            elseif($fileData['r_type'] == 3)    $names = 'video';   // video 视频=3

            $file = $request->r_file;
            $ext = $file->getClientOriginalExtension();
            $filename = md5(uniqid()).".".$ext;
            $path = $request->r_file->storeAs('admin/resource/'.$names, $filename);
            if($path){
                $fileObj = new \CURLFile(public_path().'/'.$path);
                $postData = ['media'=>$fileObj];
                $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.Wechat::getAccessToken().'&type='.$names;
                $res = Wechat::curlPost($url, $postData);
                $media_id = json_decode($res, true)['media_id'];
            }
        }

        $fileData['r_file'] = $path;
        $fileData['media_id'] = $media_id;
        $res = RS::create($fileData);
        if($res){
            return redirect('admin/weixin/index')->with('find', '添加成功');
        }else{
            return redirect('admin/weixin/index')->with('find', '添加失败');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
