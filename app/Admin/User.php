<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';	// 表名
    protected $primaryKey = 'id';	// 字段
	public $timestamps = false;	// 关闭时间戳
	protected $guarded = ['_token'];	// 黑名单
}
