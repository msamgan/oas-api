<?php

declare(strict_types=1);

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): RedirectResponse|Redirector => redirect(config('app.frontend_url')));
