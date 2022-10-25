<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

final class ApiImageController
{
    public function upload(Request $request)
    {
        $file = $request->file();

        return true;
    }
}
