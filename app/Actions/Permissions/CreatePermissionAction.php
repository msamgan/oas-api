<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\Enums\Roles;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Throwable;

final readonly class CreatePermissionAction
{
    /**
     * Execute the action.
     *
     * @throws Throwable
     */
    public function handle(string $permissionName): void
    {
        DB::transaction(function () use ($permissionName): void {
            $permission = Permission::findOrCreate($permissionName);
            (Roles::director())->givePermissionTo($permission);
        });
    }
}
