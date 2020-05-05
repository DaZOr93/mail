<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Routing\Route;

class RedirectHome
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
        $url = $request->url();

        if( $url == 'http://mail') {
            return redirect()->route('spa' , 'home');
        }

        return $next($request);
    }
}
