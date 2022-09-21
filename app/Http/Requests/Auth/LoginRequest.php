<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read bool $remember
 */
class LoginRequest extends FormRequest
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
            'email'    => 'required|email:rfc,dns',
            'password' => 'required'
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email'    => 'Электронная почта',
            'password' => 'Пароль',
        ];
    }
}
