<?php

namespace App\Http\Middleware;

use Closure;
use App\Traits\MachineTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class Securitymachine
{
    use ResponseTrait , MachineTrait;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $checkmachineid = $this->machinevalidate($request->machineids);
        if($request->securitymachine != env("API_SEC_Machine",'NPd1nyozbX9qGyfAqKkCDlDY5Fn8CGr')){
            return $this->returnError('U100','Unauthenticated Machine OOPS 🤕 :( ...!'); 
        }
        if($request->machineids != $checkmachineid){
            return $this->returnError('U100','Unauthenticated Machine OOPS 🤕 :( ...!'); 
        }
       
        
        return $next($request);
    }
}
