<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Admin\User;

class UserController extends Controller
{
	/* 展示登录*/
    public function register()
  	{
  		return view('admin/register');
  	}
  	
  	/* 执行登录2*/
  	public function register_do()
  	{
  		$email = request()->email;
  		$pwd = request()->pwd;
  		$user_first = User::where('email', $email)->first();
  		if( $user_first ){
  			$error_num = $user_first->error_num+1;
  			if( $error_num > 3 ){
  				$error_time = 60-ceil((time()-$user_first->error_time)/60);
  				if($error_time > 0){
  					return redirect('admin/register')->with('find', '账号冻结请'.$error_time.'分后再试');
  				}else{
					User::where('email', $email)->update(['error_num'=>0,'error_time'=>0]);
					$error_num = 1;  
  				}
  			}
  			
  			$res = User::where([['id', '=', $user_first->id],['pwd', '=', $pwd]])->first();
  			if($res){
				session(['user'=>$res]);
				request()->session()->save();
  				return redirect('admin/weixin/index')->with('find', '登录成功');
  			}else{
  				User::where('email', $email)->update(['error_num'=>$error_num,'error_time'=>time()]);
  				return redirect('admin/register')->with('find', '密码错误还剩'.(3-$error_num).'次机会');
  			}
  		}else{
  			return redirect('admin/register')->with('find', '账号不存在');
  		}
  	}
  	
  	/* 执行登录1*/
  	/*public function register_do()
  	{
  		$login_data = request()->except('_token');
  		$user_first = User::where($login_data)->first();
  		if($user_first){
  			session(['user'=>$user_first]);
  			request()->session()->save();
  			return redirect('admin/weixin/index')->with('find','登录成功');
  		}else{
  			return redirect('admin/register')->with('find','登录失败');
  		}
  	}*/
}
