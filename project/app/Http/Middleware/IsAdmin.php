<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, \Closure $next)
    {

        if (!Auth::user()->is_admin) {
            return response()->json([
                'error' => 'Unauthorized.'
            ], 200);
        }

        $response = $next($request);
        return $response;
    }
}
