<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Event\Event;
use App\Services\Event\EventEnum;
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

            auth()->user()->update(['time_zone' => $request->timeZone]);

            Event::store(EventEnum::Login, ['email' => $request->email]);
            return response()->json(['data' => true]);
        }

        Event::store(EventEnum::LoginAttempt, ['email' => $request->email]);
        return response()->json(['errors' => trans('auth.failed')], 403);
    }

    /**
     * @return JsonResponse
     */
    public function logOut(): JsonResponse
    {
        Auth::guard('web')->logout();

        Event::store(EventEnum::LogOut);
        return response()->json(['data' => true]);
    }
}
