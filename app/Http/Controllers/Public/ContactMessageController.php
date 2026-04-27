<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageSubmittedAdmin;
use App\Mail\ContactMessageSubmittedUser;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ContactMessageController extends Controller
{
    public function store(StoreContactMessageRequest $request): JsonResponse
    {
        $message = ContactMessage::query()->create($request->validated());

        $adminEmail = (string) env('NOTIFY_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS', ''));
        if ($adminEmail !== '') {
            try {
                Mail::to($adminEmail)->queue(new ContactMessageSubmittedAdmin($message));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        try {
            Mail::to($message->email)->queue(new ContactMessageSubmittedUser($message));
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json([
            'ok' => true,
            'id' => $message->id,
        ], 201);
    }
}

