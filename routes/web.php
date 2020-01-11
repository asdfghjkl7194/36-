<?php
Route::view('/', 'index');
Route::get('/a', 'Admin\Weixin\WeixinController@index');	// 快捷进入
Route::get('/getAccessTokens', 'Admin\Weixin\WeixinController@getAccessTokens');	// 获取凭证
Route::post('/gitPull', 'Git\GitController@index');	// 自动上传 post


/**
 * 微信后端
 */
Route::prefix('/wechat')->group(function(){
	Route::any('/', 'Wechat\WechatController@wechat');
});


/**
 * 网页后端
 */
Route::prefix('/admin')->group(function(){
	// 登录
	Route::get('/register', 'Admin\UserController@register');
	Route::post('/register_do', 'Admin\UserController@register_do');

	// 设置回复内容	admin/
	Route::prefix('/')->middleware('adminUser')->group(function(){


		// 微信公众号 admin/weixin/
		Route::prefix('/weixin')->group(function(){
			Route::get('/index', 'Admin\Weixin\WeixinController@index');	// 展示
			Route::get('/create', 'Admin\Weixin\WeixinController@create');	// 添加
			Route::any('/store', 'Admin\Weixin\WeixinController@store');	// 执行
		});

		// 二维码 admin/yard/
		Route::prefix('/yard')->group(function(){
			Route::get('/index', 'Admin\Yard\YardController@index');	// 展示
			Route::get('/create', 'Admin\Yard\YardController@create');	// 添加
			Route::get('/store', 'Admin\Yard\YardController@store');	// 执行
		});

		// 公众号_工具栏 admin/tools
		Route::prefix('tools')->group(function(){
			Route::get('/index', 'Admin\Tools\ToolsController@index');
			Route::post('/index_do', 'Admin\Tools\ToolsController@index_do');
		});

		// 天气类 admin/weather/
		Route::prefix('/weather')->group(function(){
			Route::get('/index', 'Admin\Weathe\WeatherController@index');
			Route::get('/index_do', 'Admin\Weathe\WeatherController@index_do');
		});

		// 群发 admin/flock/
		Route::prefix('/flock')->group(function(){
			Route::get('/index', 'Admin\Flock\FlockController@index');
			Route::post('/index_do', 'Admin\Flock\FlockController@index_do');
		});
	});
});