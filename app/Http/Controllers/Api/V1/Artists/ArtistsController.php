<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Artists;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Users\UserResource;
use App\QueryBuilders\Users\ArtistsQuery;
use App\Utils\Constants;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class ArtistsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $paginator = ArtistsQuery::build(
            search: mb_trim((string) $request->input('search', '')),
            perPage: max(
                Constants::MIN_PER_PAGE,
                min(Constants::MAX_PER_PAGE, (int) $request->integer('per_page', Constants::DEFAULT_PER_PAGE))
            )
        );

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
