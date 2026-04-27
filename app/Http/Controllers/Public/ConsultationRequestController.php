<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreConsultationRequest;
use App\Mail\ConsultationSubmittedAdmin;
use App\Mail\ConsultationSubmittedUser;
use App\Models\ConsultationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Mail;

class ConsultationRequestController extends Controller
{
    public function store(StoreConsultationRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $consultation = ConsultationRequest::query()->create($data);
        } catch (QueryException $e) {
            $msg = (string) $e->getMessage();

            // If migrations haven't been applied yet, retry without new columns.
            if (str_contains($msg, "Unknown column 'country_code'") || str_contains($msg, 'Unknown column `country_code`')) {
                unset($data['country_code']);
            }
            if (str_contains($msg, "Unknown column 'service_name'") || str_contains($msg, 'Unknown column `service_name`')) {
                unset($data['service_name']);
            }

            // If the DB is down (common on local XAMPP), return a clean 503.
            if (str_contains($msg, 'SQLSTATE[HY000] [2002]')) {
                return response()->json([
                    'ok' => false,
                    'message' => 'Database is unavailable. Please start MySQL and try again.',
                ], 503);
            }

            // Retry once if we removed unknown columns.
            try {
                $consultation = ConsultationRequest::query()->create($data);
            } catch (QueryException $e2) {
                $msg2 = (string) $e2->getMessage();
                if (str_contains($msg2, 'SQLSTATE[HY000] [2002]')) {
                    return response()->json([
                        'ok' => false,
                        'message' => 'Database is unavailable. Please start MySQL and try again.',
                    ], 503);
                }
                throw $e2;
            }
        }

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

