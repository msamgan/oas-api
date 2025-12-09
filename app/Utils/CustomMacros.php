<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

final class CustomMacros
{
    public static function loadResponseSuccess(): void
    {
        Response::macro(
            'success',
            function (string $message, mixed $payload = null, int $status = 200, array $headers = [], int $options = 0): JsonResponse {
                $body = [
                    'message' => $message,
                    'status' => $status,
                ];

                if ($payload !== null) {
                    $body['payload'] = $payload;
                }

                return response()->json($body, $status, $headers, $options);
            });
    }

    public static function loadResponseFailure(): void
    {
        Response::macro(
            'failure',
            function (string $message, mixed $error = null, int $status = 400, mixed $payload = null, array $headers = [], int $options = 0): JsonResponse {
                $body = [
                    'message' => $message,
                    'status' => $status,
                ];

                if ($error !== null) {
                    $body['error'] = $error;
                }

                if ($payload !== null) {
                    $body['payload'] = $payload;
                }

                return response()->json($body, $status, $headers, $options);
            });
    }
}
