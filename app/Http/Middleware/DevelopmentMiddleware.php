<?php namespace App\Http\Middleware;

use Closure;

class DevelopmentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        production() && abort(403, 'This page is not available in production environment');
        return $next($request);
    }
}