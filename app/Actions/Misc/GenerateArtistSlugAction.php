<?php

declare(strict_types=1);

namespace App\Actions\Misc;

use Illuminate\Support\Str;

final readonly class GenerateArtistSlugAction
{
    /**
     * Execute the action.
     */
    public function handle(string $artistName, string $artistLocation): string
    {
        $name = Str::slug($artistName);
        $location = Str::slug($artistLocation);

        return Str::limit(sprintf('%s-%s-', $name, $location).Str::random(6), 50, '');
    }
}
