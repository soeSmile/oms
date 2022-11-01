<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Request;

if (!function_exists('isAdmin')) {
    /**
     * @return bool
     */
    function isAdmin(): bool
    {
        if (auth()->check()) {
            return auth()->user()->isAdmin();
        }

        return false;
    }
}

if (!function_exists('getIP')) {
    /**
     * @return string|null
     */
    function getIP(): ?string
    {
        return Request::ip();
    }
}
