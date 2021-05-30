<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
class JWTMiddleware
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
        $message = "";
        try{
            JWTAuth::parseToken()->authenticate();
            return $next($request);
        }catch (TokenExpiredException $exception){
            $message = "Token expired";
        }catch (TokenInvalidException $tokenInvalidException){
            $message = "Token invalid";
        }catch (JWTException $JWTException){
            $message = "provide token";
        }
        return response()->json([
           'success'=>false,
            'message'=>$message
        ]);
    }
}
