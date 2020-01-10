<?php

namespace App\Admin\Yard;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'client';	// 表名
	protected $primaryKey = 'id';	// 字段
	public $timestamps = false;	// 开启时间戳
	protected $guarded = ['_token'];	// 黑名单
}
