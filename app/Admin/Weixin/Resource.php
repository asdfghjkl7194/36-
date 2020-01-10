<?php

namespace App\Admin\Weixin;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $table = 'resource';	// 表名
	protected $primaryKey = 'r_id';	// 字段
	public $timestamps = true;	// 开启时间戳
	protected $guarded = ['_token'];	// 黑名单
}
