<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class apiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');

        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado: La API key no está presente'
            ], 401);
        }

        if ($apiKey === env('API_KEY')) {
            return $next($request);
        }

        $apiKeyExists = \App\Models\ApiKey::where('key', $apiKey)->exists();

        if (!$apiKeyExists) {
            return response()->json([
                'success' => false,
                'message' => 'No autorizado: API key inválida'
            ], 401);
        }

        return $next($request);
    }
}
