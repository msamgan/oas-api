<?php

declare(strict_types=1);

use App\Actions\Users\CreateUserAction;
use App\Enums\Roles;
use App\Models\User;
use App\Utils\Constants;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::transaction(function (): void {
            $email = Constants::SEED_DIRECTOR_EMAIL;

            $existing = User::query()->where('email', $email)->first();

            if ($existing !== null) {
                // Ensure the Director role is assigned if user already exists.
                $existing->assignRole(Roles::Director->value);

                return;
            }

            $creator = App::make(CreateUserAction::class);

            $user = $creator->handle([
                'name' => 'Director',
                'email' => $email,
                'password' => Constants::SEED_DIRECTOR_PASSWORD,
                'location' => Constants::SEED_DIRECTOR_LOCATION,
            ]);

            $user->assignRole(Roles::director());
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::transaction(function (): void {
            $email = Constants::SEED_DIRECTOR_EMAIL;

            /** @var User|null $user */
            $user = User::query()->where('email', $email)->first();
            if ($user === null) {
                return;
            }

            // Remove roles then delete the user to keep pivot tables tidy.
            $user->syncRoles([]);
            $user->delete();
        });
    }
};
