<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$role)
    {
        $list_roles = [
            '1'=>'super',
            '2'=>'admin',
            '3'=>'client'
        ];
        // if(in_array($list_roles))

        if(in_array($list_roles['1'],$role)==false){
            abort(403);
        }
        if(in_array($list_roles['1'],$role)==false && auth()->user()->role_id == 1 ) {
            abort(403);
        }
        
        if(in_array($list_roles['2'],$role)==false){
            abort(403);
        }
        if(in_array($list_roles['2'],$role)==false && auth()->user()->role_id == 2) {
            abort(403);
        }

        if(in_array($list_roles['3'],$role)==false){
            abort(403);
        }
        if(in_array($list_roles['3'],$role)==false && auth()->user()->role_id == 3 ) {
            abort(403);
        }
        return $next($request);
    }
}
