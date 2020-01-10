<?php

namespace App\Http\Controllers\Admin\Yard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Tools\Wechat;
use App\Admin\Yard\Channel;

class YardController extends Controller
{
    /**
     * Display a listing of the resource.
     * 二维码展示
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $channelData = Channel::get();
        // 获取关注人数
        $cNum = 0;  // 关注总人数
        $nNum = 0;  // 取关总人数
        $c_name_arr = '';   // 图-名称
        $cNums = '';  // 图-每个关注总人数
        $nNums = '';  // 图-每个取关总人数
        foreach($channelData as $v){
            $cNum += $v->c_num;
            $nNum += $v->n_num;
            $c_name_arr .= '"'.$v->c_name.'",';
            $cNums .= $v->c_num.',';
            $nNums .= $v->n_num.',';
        }
        return view('admin/yard/index', [
            'channelData'=>$channelData,
            'cNum'=>$cNum, 'nNum'=>$nNum, 
            'userNum'=>'代码删除了', 
            'c_name_arr'=>rtrim($c_name_arr, ','),
            'cNums' => rtrim($cNums, ','),
            'nNums' => rtrim($nNums, ',')
            ]);
    }

    /**
     * Show the form for creating a new resource.
     * 添加
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin/yard/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();
        $ticket = Wechat::getTicket($data['c_status']);    // 获取二维码
        $res = Channel::create([
            'c_name'    => $data['c_name'],
            'c_status'  => $data['c_status'],
            'ticket'    => $ticket,
            // 'past_time' => date('Y-m-d H:i:s',time()+259200) // 30天
        ]);
        if($res){
            return redirect('admin/yard/index')->with('find', '添加成功');
        }else{
            return redirect('admin/yard/index')->with('find', '添加失败');
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
