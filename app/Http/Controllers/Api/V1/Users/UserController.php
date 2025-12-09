<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Users;

use App\Actions\Roles\AssignRoleAction;
use App\Actions\Users\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Users\StoreUserRequest;
use App\Http\Resources\Api\V1\Users\UserResource;
use App\Models\User;
use App\Utils\Constants;
use Illuminate\Http\JsonResponse;
use Throwable;

final class UserController extends Controller
{
    /**
     * @throws Throwable
     */
    public function store(
        StoreUserRequest $request,
        CreateUserAction $createUserAction,
        AssignRoleAction $assignRoleAction,
    ): JsonResponse {
        $data = $request->validated();

        $user = $createUserAction->handle($data);

        $assignRoleAction->handle($user, $data['role']);

        return response()->success(
            message: Constants::MSG_USER_CREATED,
            payload: [
                'user' => new UserResource($user),
            ],
            status: 201,
        );
    }

    public function show(User $user): JsonResponse
    {
        return response()->success(
            message: Constants::MSG_USER_FETCHED,
            payload: [
                'user' => new UserResource($user),
            ],
        );
    }
}
