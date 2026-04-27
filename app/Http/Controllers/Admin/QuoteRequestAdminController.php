<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateQuoteRequest;
use App\Mail\QuoteApprovedUser;
use App\Models\QuoteRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Mail;

class QuoteRequestAdminController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        try {
            $query = QuoteRequest::query()->orderByDesc('id');

            if ($request->filled('status')) {
                $query->where('status', $request->string('status')->toString());
            }

            if ($request->filled('email')) {
                $query->where('email', $request->string('email')->toString());
            }

            return JsonResource::collection($query->paginate(25));
        } catch (QueryException $e) {
            // If migrations haven't run yet, don't break the admin overview.
            $msg = (string) $e->getMessage();
            if (str_contains($msg, 'SQLSTATE[42S02]') || str_contains($msg, "quote_requests")) {
                return JsonResource::collection(collect([]));
            }
            throw $e;
        }
    }

    public function show(QuoteRequest $quoteRequest): JsonResource
    {
        return JsonResource::make($quoteRequest);
    }

    public function update(UpdateQuoteRequest $request, QuoteRequest $quoteRequest): JsonResource
    {
        $quoteRequest->fill($request->validated());
        $quoteRequest->save();

        return JsonResource::make($quoteRequest);
    }

    public function approve(Request $request, QuoteRequest $quoteRequest): JsonResource
    {
        // Basic guard: must have at least a total or line items.
        $hasItems = is_array($quoteRequest->line_items) && count($quoteRequest->line_items) > 0;
        if (!$hasItems && $quoteRequest->total === null) {
            abort(422, 'Add line items or total before approving.');
        }

        $quoteRequest->status = 'approved';
        $quoteRequest->approved_at = now();
        $quoteRequest->save();

        try {
            Mail::to($quoteRequest->email)->queue(new QuoteApprovedUser($quoteRequest));
        } catch (\Throwable $e) {
            report($e);
        }

        return JsonResource::make($quoteRequest);
    }
}

