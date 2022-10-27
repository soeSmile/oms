<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsUser
{
    /**
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        $check = match ($role) {
            'admin' => isAdmin(),
            default => false,
        };

        if (!$check) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => 'unauthorized'], 403);
            }

            abort(404);
        }

        return $next($request);
    }
}
