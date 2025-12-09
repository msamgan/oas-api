<?php

declare(strict_types=1);

namespace App\Enums;

use Spatie\Permission\Models\Role;

enum Roles: string
{
    case Director = 'Director';
    case Artist = 'Artist';

    public static function director(): \Spatie\Permission\Contracts\Role|Role
    {
        return Role::findOrCreate(self::Director->value);
    }

    public static function artist(): \Spatie\Permission\Contracts\Role|Role
    {
        return Role::findOrCreate(self::Artist->value);
    }
}
