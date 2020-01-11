<?php

namespace App\Http\Controllers\Git;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GitController extends Controller
{
    function index(){
        $cmd = "cd /data/wwwroot/default/36weixin && git pull";
        echo $cmd;
        // shell_exec($cmd);
    }
}
