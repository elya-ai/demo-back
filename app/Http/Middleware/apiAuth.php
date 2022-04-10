<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class apiAuth
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
        $api_token = $request->header('api_token');

        if (!$api_token) {
            return response()->json("Не введен api_token");
        }

        if (!User::where('api_token', $api_token)->first()) {
            return response()->json("Такого пользователя не существует.");
        }

        return $next($request);
    }
}
