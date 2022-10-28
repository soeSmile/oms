<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Enum\RoleEnum;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class BrandResource
 * @property-read int $id
 * @property-read string $name
 * @property-read string $surname
 * @property-read string $phone
 * @property-read string $email
 * @property-read bool $confirm
 * @property-read int $role
 */
class UserResource extends JsonResource
{
    /**
     * @param $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'surname'  => $this->surname,
            'phone'    => $this->phone,
            'email'    => $this->email,
            'confirm'  => $this->confirm,
            'role'     => $this->role,
            'roleName' => RoleEnum::from($this->role)->title(),
        ];
    }
}
