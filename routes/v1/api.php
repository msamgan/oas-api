<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Artists\ArtistsController;
use App\Http\Controllers\Api\V1\Auth\SignInController;
use App\Http\Controllers\Api\V1\Roles\RolesController;
use App\Http\Controllers\Api\V1\Users\UserController;
use App\Utils\Constants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/up', fn (Request $request) => response()->success(Constants::MSG_OK, ['status' => 'ok']));
    Route::get('/roles', [RolesController::class, 'index']);
    Route::get('/artists', [ArtistsController::class, 'index']);
    Route::post('/auth/sign-in', SignInController::class);

    Route::post('/users', [UserController::class, 'store']);
    Route::get('/users/{user:slug}', [UserController::class, 'show']);
});

//
