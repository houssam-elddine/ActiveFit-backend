<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!$request->user()) {
            return response()->json([
                'message' => 'Utilisateur non authentifié'
            ], 401);
        }

        if ($request->user()->role !== $role) {
            return response()->json([
                'message' => 'Accès refusé'
            ], 403);
        }

        return $next($request);
    }
}
