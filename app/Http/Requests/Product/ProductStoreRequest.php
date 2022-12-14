<?php

declare(strict_types=1);

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductStoreRequest
 *
 */
class ProductStoreRequest extends FormRequest
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
            'oe'          => 'nullable|array',
            'tnved'       => 'nullable|array',
            'hscode'      => 'nullable|array',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name'        => 'Product name',
            'widthBox'    => 'Width in box',
            'heightBox'   => 'Height in box',
            'lengthBox'   => 'Length in box',
            'weightGross' => 'Gross weight',
            'volume'      => 'Volume',
            'deposit'     => 'Pledge products',
        ];
    }
}
