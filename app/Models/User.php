<?php

declare(strict_types=1);

namespace App\Models;

use App\Enum\RoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * Class User
 *
 * @property-read  int $id
 * @property string $name
 * @property string $surname
 * @property string $phone
 * @property string $email
 * @property bool $confirm
 * @property string $confirm_key
 * @property int $time_zone
 * @property int $role
 * @property string $img
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * @var array<string>
     */
    protected $guarded = ['id'];

    /**
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::Admin->value;
    }
}
