<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('stores a contact message', function (): void {
    $payload = [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'message' => 'Hello, I would like to know more about your services.',
        'subject' => 'Inquiry',
    ];

    $response = $this->postJson('/api/v1/contact', $payload);

    $response->assertCreated();
    $response->assertJsonStructure([
        'message',
        'payload' => ['id'],
    ]);

    $this->assertDatabaseHas('contact_messages', [
        'name' => 'Jane Doe',
        'email' => 'jane@example.com',
        'subject' => 'Inquiry',
        'message' => 'Hello, I would like to know more about your services.',
    ]);
});

it('validates required fields for contact message', function (): void {
    $response = $this->postJson('/api/v1/contact', [
        // missing name, email, message
    ]);

    $response->assertUnprocessable();
    $response->assertJsonValidationErrors(['name', 'email', 'message']);
});
