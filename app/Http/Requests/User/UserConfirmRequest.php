<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserConfirmRequest
 * @property-read  int $id
 * @property-read bool $confirm
 */
class UserConfirmRequest extends FormRequest
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
            'id'      => 'required|int|exists:users',
            'confirm' => 'required|boolean',
        ];
    }
}
