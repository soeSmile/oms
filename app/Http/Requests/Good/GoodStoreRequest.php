<?php

declare(strict_types=1);

namespace App\Http\Requests\Good;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class GoodStoreRequest
 *
 */
class GoodStoreRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name'        => 'required|string',
            'brandId'     => 'nullable|int',
            'widthBox'    => 'nullable|numeric',
            'heightBox'   => 'nullable|numeric',
            'lengthBox'   => 'nullable|numeric',
            'weightGross' => 'nullable|numeric',
            'volume'      => 'nullable|numeric',
            'deposit'     => 'nullable|boolean',
            'category'    => 'nullable|array',
            'number'      => 'nullable|array',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'        => 'Good name',
            'widthBox'    => 'Width in box',
            'heightBox'   => 'Height in box',
            'lengthBox'   => 'Length in box',
            'weightGross' => 'Gross weight',
            'volume'      => 'Volume',
            'deposit'     => 'Pledge goods',
        ];
    }
}
