<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Roles;

use App\Enums\Roles;
use App\Http\Controllers\Controller;
use App\Utils\Constants;
use Illuminate\Http\JsonResponse;

final class RolesController extends Controller
{
    public function index(): JsonResponse
    {
        $roles = array_map(static fn (Roles $role): string => $role->value, Roles::cases());

        return response()->success(
            message: Constants::MSG_OK,
            payload: [
                'roles' => $roles,
            ],
        );
    }
}
