<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AccessControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userInfo = $request -> session() -> get("userInfo");
        if( !$userInfo ){
            return redirect("/Admin/login");
        }
        return $next($request);
    }
}
