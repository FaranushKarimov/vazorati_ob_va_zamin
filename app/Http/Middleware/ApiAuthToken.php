<?php

namespace App\Http\Middleware;

use Closure;

class ApiAuthToken
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
        
        // $user = $request->only(['username','password','token']);

        if(! $this->checkToken($request)){
            return "invalid request";
        }

        return $next($request);
    }

    /**
     * Get token from request and check
     * @param  \Illuminate\Http\Request $request 
     * @return Boolean          false if no token
     */
    protected function checkToken($request)
    {
        $token_header = $request->bearerToken();
        // $token = $request->header('Authorization');
        $token_form = $request->input('api_token');

        if($token_header != env('APP_API_TOKEN') && $token_form != env('APP_API_TOKEN')) return false;

        return true;
    }
}
