<?php

declare(strict_types=1);

namespace App\Utils;

final class Constants
{
    // Generic messages
    public const MSG_OK = 'OK';

    public const MSG_SIGNED_IN = 'Signed in successfully.';

    // Users / Artists messages
    public const MSG_ARTISTS_FETCHED = 'Artists fetched successfully.';

    public const MSG_USER_CREATED = 'User created successfully.';

    public const MSG_USER_FETCHED = 'User fetched successfully.';

    // Pagination
    public const DEFAULT_PER_PAGE = 15;

    public const MIN_PER_PAGE = 1;

    public const MAX_PER_PAGE = 100;

    // Seed / Fixtures
    public const SEED_DIRECTOR_EMAIL = 'director@oas.test';

    public const SEED_DIRECTOR_PASSWORD = 'Pass@123';

    public const SEED_DIRECTOR_LOCATION = 'Headquarters';
}
