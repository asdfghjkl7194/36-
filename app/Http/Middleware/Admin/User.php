<?php

namespace App\Http\Middleware\Admin;

use Closure;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	
    	if( !session('user') ){
    		return redirect('admin/register')->with('find','非法操作');
    	}
        return $next($request);
    }
}
