<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsultationRequest;
use App\Mail\ConsultationSubmittedAdmin;
use App\Mail\ConsultationSubmittedUser;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class ConsultationRequestController extends Controller
{
    public function store(StoreConsultationRequest $request): JsonResponse
    {
        $consultation = ConsultationRequest::query()->create($request->validated());

        $adminEmail = (string) env('NOTIFY_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS', ''));
        if ($adminEmail !== '') {
            try {
                Mail::to($adminEmail)->queue(new ConsultationSubmittedAdmin($consultation));
            } catch (\Throwable $e) {
                report($e);
            }
        }

        try {
            Mail::to($consultation->email)->queue(new ConsultationSubmittedUser($consultation));
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json([
            'ok' => true,
            'id' => $consultation->id,
        ], 201);
    }
}

