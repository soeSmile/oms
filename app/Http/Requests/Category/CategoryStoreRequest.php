<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryStoreRequest
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read bool $remember
 */
class CategoryStoreRequest extends FormRequest
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
            'name'     => 'required|string',
            'parentId' => 'nullable',
            'code'     => 'nullable',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Category',
        ];
    }
}
