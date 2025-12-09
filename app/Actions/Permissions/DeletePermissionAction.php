<?php

declare(strict_types=1);

namespace App\Actions\Permissions;

use App\Enums\Roles;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;
use Throwable;

final readonly class DeletePermissionAction
{
    /**
     * Execute the action.
     *
     * @throws Throwable
     */
    public function handle(string $permissionName): void
    {
        DB::transaction(function () use ($permissionName): void {

            try {
                $permission = Permission::findByName($permissionName);
            } catch (PermissionDoesNotExist) {
                return;
            }

            (Roles::director())->revokePermissionTo($permission);

            $permission->delete();
        });
    }
}
