<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;


use Closure;

class testMiddleware 
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->get('token') != 'token'){
            throw new \Exception('Invalid Token');
        }

        return $next($request); //default εντολή
    }

    public function terminate($request, $response){
        var_dump('terminate middleware'); die;
    }
}
