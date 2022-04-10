<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

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
        $token = $request->header('api_token');
        $users = User::where('api_token', $token)->where('type', 'admin')->first();

        if (!$users) {
            return response()->json("Вам отказано в доступе");
        }
        return $next($request);
    }
}
