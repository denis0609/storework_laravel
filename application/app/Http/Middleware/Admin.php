<?php
/*
* Workday - A time clock application for employees
* Support: official.codefactor@gmail.com
* Version: 1.6
* Author: Brian Luna
* Copyright 2020 Codefactor
*/
namespace App\Http\Middleware;
use Auth;
use Closure;

class Admin
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
        $t = \Auth::user()->acc_type;
        
        if ($t == 2) 
        {
            // nothing
        } else {
            Auth::logout();
            return redirect()->route('denied');
        }

        return $next($request);
    }
}
