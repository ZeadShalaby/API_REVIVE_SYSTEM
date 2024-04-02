<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Traits\Crypt\CryptTrait;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class Checksecurity
{
    use ResponseTrait , CryptTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $decryptKey = $this->SecurityDecrypt($this->SecurityEncrypt(Role::SECRET)); 
        if($request->checksecurity != env("API_VALIDATION",$decryptKey)){
            return $this->returnError('U100','Unauthenticated OOPS :( ..!'); 
        }
        return $next($request);
    }
}
