<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

/**
 * Class ApiAuthController
 */
final class ApiAuthController
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        if (
            Auth::attempt([
                'email'    => $request->email,
                'password' => $request->password,
                'confirm'  => true,
                'deleted'  => false
            ], $request->remember)
        ) {
            $request->session()->regenerate();

            return response()->json(['data' => true]);
        }

        return response()->json(['errors' => trans('auth.failed')], 403);
    }

    /**
     * @return JsonResponse
     */
    public function logOut(): JsonResponse
    {
        Auth::guard('web')->logout();

        return response()->json(['data' => true]);
    }
}
