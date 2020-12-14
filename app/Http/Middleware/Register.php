<?php

namespace App\Http\Middleware;

use Closure;

class Register
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
        if ($request->app_key === env('APP_KEY') && $request->app_name === env('APP_NAME') && $request->service_key === env('SERVICE_KEY') && $request->remote_addr === gethostbyname(gethostname())) {
            return $next($request);
        }
        
        if ($request->header('token') === md5(env('APP_KEY').'.'.env('APP_NAME').'.'.env('SERVICE_KEY'))) {
            return $next($request);            
        }
        return response(['message'=>'Unauthorized'], 401);

    }
}
