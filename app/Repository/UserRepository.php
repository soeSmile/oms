<?php

declare(strict_types=1);

namespace App\Repository;

/**
 * Class UserRepository
 */
final class UserRepository extends AbstractRepository
{
    /**
     * @var string
     */
    protected string $table = 'users';
}
