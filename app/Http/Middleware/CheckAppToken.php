<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $configToken = config('app.app_token');

        $headerToken = $request->header('AppToken');

        if (!$headerToken || $headerToken !== $configToken) {
            return response()->json(['message' => 'Invalid Application Token'], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
