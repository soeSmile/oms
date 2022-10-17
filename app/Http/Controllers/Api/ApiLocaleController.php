<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enum\LocaleEnum;
use Illuminate\Http\JsonResponse;

use function array_column;

class ApiLocaleController
{
    /**
     * @return JsonResponse
     */
    public function getLocales(): JsonResponse
    {
        $array = [];
        $data = array_column(LocaleEnum::cases(), 'value');

        foreach ($data as $key => $item) {
            $array[$key]['name'] = LocaleEnum::from($item)->title();
            $array[$key]['value'] = $item;
        }

        return response()->json(['data' => $array]);
    }
}
