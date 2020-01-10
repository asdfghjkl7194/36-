<?php

namespace App\Admin\Yard;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $table = 'channel';	// 表名
	protected $primaryKey = 'c_id';	// 字段
	public $timestamps = true;	// 开启时间戳
	protected $guarded = ['_token'];	// 黑名单
}
