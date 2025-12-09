<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Actions\Misc\GenerateArtistSlugAction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

final readonly class CreateUserAction
{
    /**
     * Execute the action.
     *
     * @param  array{name:string,email:string,password:string,location:string}  $data
     *
     * @throws Throwable
     */
    public function handle(array $data): User
    {
        $slugGenerator = app(GenerateArtistSlugAction::class);

        return DB::transaction(fn (): User => User::query()->create([
            'slug' => $slugGenerator->handle($data['name'], $data['location']),
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'location' => $data['location'],
        ]));
    }
}
