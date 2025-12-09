<?php

declare(strict_types=1);

namespace App\QueryBuilders\Users;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class ArtistsQuery
{
    public static function build(string $search = '', int $perPage = 15): LengthAwarePaginator
    {
        return User::query()
            ->role(Roles::Artist->value)
            ->with('roles')
            ->when($search !== '', static function ($query) use ($search): void {
                $like = '%'.str_replace(['%', '_'], ['\\%', '\\_'], $search).'%';
                $query->where(static function ($q) use ($like): void {
                    $q->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like);
                });
            })
            ->orderBy('name')
            ->paginate($perPage);
    }
}
