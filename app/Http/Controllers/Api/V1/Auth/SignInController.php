<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\SignInRequest;
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
            message: 'Signed in successfully.',
            payload: [
                'token' => $plainTextToken,
                'type' => 'Bearer',
                'user' => [
                    'id' => $user->getAttribute('id'),
                    'name' => $user->getAttribute('name'),
                    'email' => $user->getAttribute('email'),
                ],
            ],
        );
    }
}
