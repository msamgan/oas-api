<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class ContactMessage extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'name' => 'string',
            'email' => 'string',
            'subject' => 'string',
            'message' => 'string',
            'status' => 'string',
            'created_at' => 'immutable_datetime',
            'updated_at' => 'immutable_datetime',
        ];
    }
}
