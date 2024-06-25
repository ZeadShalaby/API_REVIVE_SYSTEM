<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class Authusers
{
    use ResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(isset(auth()->user()->role)){
            $role = auth()->user()->role;
        if($role)
        if($role == Role::ADMIN) {
            return $this->returnError('403','UnAuthorization  oops 🚫 :( !...');
        }
        return $next($request); 
       }
        return $this->returnError('403','Some thimg Wrong  oops 🤕 :( !...');
   
    }
}
