<?php

declare(strict_types=1);

namespace App\Actions\Roles;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class AssignRoleAction
{
    /**
     * Execute the action.
     *
     * @throws Throwable
     */
    public function handle(User $user, string $roleName): void
    {
        DB::transaction(function () use ($user, $roleName): void {
            $roleEnum = Roles::from($roleName);

            $role = match ($roleEnum) {
                Roles::Director => Roles::director(),
                Roles::Artist => Roles::artist(),
            };

            $user->assignRole($role);
        });
    }
}
