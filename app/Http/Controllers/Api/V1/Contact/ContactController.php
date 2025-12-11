<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Contact\StoreContactRequest;
use App\Jobs\NotifyDirectorsOfContactMessage;
use App\Models\ContactMessage;
use App\Utils\Constants;
use Illuminate\Http\JsonResponse;

final class ContactController extends Controller
{
    public function __invoke(StoreContactRequest $request): JsonResponse
    {
        $message = ContactMessage::query()->create($request->validated());

        // Queue notification email to all Directors after DB commit
        NotifyDirectorsOfContactMessage::dispatch($message->getKey())->afterCommit();

        return response()->success(
            message: Constants::MSG_CONTACT_RECEIVED,
            payload: [
                'id' => $message->getKey(),
            ],
            status: 201,
        );
    }
}
