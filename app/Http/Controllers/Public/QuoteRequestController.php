<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuoteRequest;
use App\Mail\QuoteRequestedAdmin;
use App\Models\QuoteRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class QuoteRequestController extends Controller
{
    public function store(StoreQuoteRequest $request): JsonResponse
    {
        try {
            $quote = QuoteRequest::query()->create([
                ...$request->validated(),
                'status' => 'pending',
            ]);
        } catch (QueryException $e) {
            $msg = (string) $e->getMessage();
            if (str_contains($msg, 'SQLSTATE[HY000] [2002]')) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Database is unavailable. Please start MySQL and try again.',
                ], 503);
            }
            throw $e;
        }

        $adminEmail = (string) env('NOTIFY_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS', ''));
        if ($adminEmail !== '') {
            try {
                Mail::to($adminEmail)->queue(new QuoteRequestedAdmin($quote));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return response()->json([
            'ok' => true,
            'id' => $quote->id,
        ], 201);
    }
}

