<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\Users;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read string $slug
 * @property-read string $name
 * @property-read string $email
 * @property-read ?string $location
 *
 * @method getAttribute(string $string)
 * @method getRoleNames()
 */
final class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->getAttribute('slug'),
            'name' => $this->getAttribute('name'),
            'email' => $this->getAttribute('email'),
            'location' => $this->getAttribute('location'),
            'roles' => $this->getRoleNames()->values(),
        ];
    }
}
