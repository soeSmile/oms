<?php

declare(strict_types=1);

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
