<?php

namespace App\Http\Middleware;

use Closure;

class ContentLanguageMiddleware
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
        app('translator')->setLocale($request->header('Content-language', 'en'));
        return $next($request);
    }
}
