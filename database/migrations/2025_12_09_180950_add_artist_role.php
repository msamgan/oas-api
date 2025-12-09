<?php

declare(strict_types=1);

use App\Enums\Roles;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Exceptions\RoleDoesNotExist;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => Roles::Director->value]);
        Role::create(['name' => Roles::Artist->value]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $guard = (string) config('auth.defaults.guard', 'web');

        try {
            $role = Role::findByName(Roles::Artist->value, $guard);
            $role->delete();

            $role = Role::findByName(Roles::Director->value, $guard);
            $role->delete();
        } catch (RoleDoesNotExist) {
            // Role wasn't present; nothing to rollback
        }
    }
};
