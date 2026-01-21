<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Check if user is authenticated
        if (! $request->user()) {
            // For API → 401, for web → redirect or 403
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated'], 401);
            }

            return redirect()->route('login');
        }

        // 2. Check if user has ANY of the required roles
        $userRole = $request->user()->role;

        if (! in_array($userRole, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Unauthorized',
                    'required_roles' => $roles,
                    'your_role' => $userRole,
                ], 403);
            }

            abort(403, 'You do not have the required role to access this resource.');
        }

        return $next($request);
    }
}