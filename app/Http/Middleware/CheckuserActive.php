<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckuserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {   
        if(auth()->user()->status != 0)
    { 
        return $next($request); 
    } 
        notify()->error('Usuario desactivado, consulta con administrador ','App');
        return redirect(route('login'))->withErrors(['email' => 'Ususario no activado, contactar al administrador']);
    }
}
