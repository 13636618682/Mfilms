<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

class LocaleMiddleWare
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
        $lan = $request->has('lan')?$request->input('lan'):null;
        if ($lan){
            Session::put('lan',$lan);
        }
        if (Session::has('lan')){
            App::setLocale(Session::get('lan'));
        }
        return $next($request);
    }
}
