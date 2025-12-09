<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
use App\Http\Resources\Api\V1\Users\UserResource;
use App\Utils\Constants;
use Illuminate\Database\Eloquent\Attributes\UseResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

final class SignInController extends Controller
{
    public function __invoke(SignInRequest $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (! Auth::attempt($credentials)) {
            return response()->failure(
                message: 'Invalid credentials.',
                error: [
                    'email' => ['These credentials do not match our records.'],
                ],
                status: 422,
            );
        }

        $user = Auth::user();

        $deviceName = $request->string('device_name')->toString();
        if ($deviceName === '') {
            $deviceName = (string) ($request->userAgent() ?? 'API Client');
        }

        $plainTextToken = $user->createToken($deviceName)->plainTextToken;

        return response()->success(
            message: Constants::MSG_SIGNED_IN,
            payload: [
                'token' => $plainTextToken,
                'type' => 'Bearer',
                'user' => new UserResource($user),
            ],
        );
    }
}
