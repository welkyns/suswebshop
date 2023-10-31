<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @param  string|null  $guard
    * @return mixed
    */
    
    public function handle(Request $request, Closure $next, $guard = null): Response
    {
        //$guards = empty($guards) ? [null] : $guards;

        /*foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);*/
        
        switch($guard){
            case 'admin':
                if (Auth::guard($guard)->check()) {
                    return redirect('/admin');
                }
                break;
            default:
                if (Auth::guard($guard)->check()) {
                    return redirect('/');
                }
                break;
        }
        return $next($request);
    }
}
