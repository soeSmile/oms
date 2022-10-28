<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateRequest
 * @property-read string $name
 * @property-read string $surname
 * @property-read string $phone
 * @property-read string $email
 * @property-read bool $confirm
 * @property-read int $role
 * @property-read string $password
 */
class UserUpdateRequest extends FormRequest
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
            'surname'  => 'nullable|string',
            'phone'    => 'nullable|string',
            'email'    => 'required|email',
            'confirm'  => 'nullable|boolean',
            'role'     => 'required|integer',
            'password' => 'nullable|string',
        ];
    }
}
