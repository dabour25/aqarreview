<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Locate
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
            if(Session::has('lang'))
            	$segment='en';
            else
            	$segment='ar';
            app()->setLocale($segment);

        return $next($request);
    }
}