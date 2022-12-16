<?php

namespace App\Http\Middleware;

use Closure;

use Auth;

class IsSuperAdmin
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
        $user = Auth::user();

        if ($user &&  $user->role && $user->role->title =='super-admin') {
                return $next($request);
         }

        return abort(404);
        // return response('Unauthorized.', 401);
    }
}
