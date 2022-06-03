<?php
namespace app\routing\middlewares;

use Closure;


class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (! isset($_SESSION['id_user'])) {
            $_SESSION['desireURI'] = $request->url();
            return \Helper::$redirect->route('login');
        }

        return $next($request);
    }
}