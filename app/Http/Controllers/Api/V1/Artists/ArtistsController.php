<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Artists;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Users\UserResource;
use App\Models\User;
use App\Utils\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ArtistsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        // Determine per-page with sane bounds
        $perPage = max(
            Constants::MIN_PER_PAGE,
            min(Constants::MAX_PER_PAGE, (int) $request->integer('per_page', Constants::DEFAULT_PER_PAGE))
        );

        // Optional search filter (by name or email)
        $search = trim((string) $request->input('search', ''));

        $paginator = User::query()
            ->role(Roles::Artist->value)
            ->with('roles')
            ->when($search !== '', static function ($query) use ($search): void {
                $like = '%' . str_replace(['%', '_'], ['\\%', '\\_'], $search) . '%';
                $query->where(static function ($q) use ($like): void {
                    $q->where('name', 'like', $like)
                        ->orWhere('email', 'like', $like);
                });
            })
            ->orderBy('name')
            ->paginate($perPage);

        return response()->success(
            message: Constants::MSG_ARTISTS_FETCHED,
            payload: [
                'artists' => UserResource::collection($paginator->items()),
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ],
            ],
        );
    }
}
