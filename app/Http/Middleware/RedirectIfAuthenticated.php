<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {        
            $redierectHome = RouteServiceProvider::HOME;
            $redierectHomeClient = RouteServiceProvider::HOMECLIENT;
            if (Auth::guard($guard)->check()) {
                // dd("siswa");
                if($guard == 'siswa'){
                    return redirect($redierectHomeClient);
                }
                return redirect($redierectHome);
            }
            if (Auth::guard("siswa")->check()) {
                return redirect($redierectHomeClient);
            }
            if ($guard == 'siswa') {
                if(Auth::check()){
                    return redirect($redierectHome);
                }
            }
        }
        return $next($request);
    }
}
