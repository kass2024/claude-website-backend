<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\InterestLeadResource;
use App\Models\InterestLead;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InterestLeadAdminController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = InterestLead::query()->orderByDesc('submitted_at')->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('type')) {
            $query->where('interest_type', $request->string('type')->toString());
        }

        if ($request->filled('q')) {
            $q = '%'.$request->string('q')->toString().'%';
            $query->where(function ($w) use ($q) {
                $w->where('full_name', 'like', $q)
                    ->orWhere('email', 'like', $q)
                    ->orWhere('company_name', 'like', $q)
                    ->orWhere('source_title', 'like', $q);
            });
        }

        if ($request->filled('from')) {
            $query->where('submitted_at', '>=', $request->date('from'));
        }
        if ($request->filled('to')) {
            $query->where('submitted_at', '<=', $request->date('to'));
        }

        return InterestLeadResource::collection($query->get());
    }

    public function show(InterestLead $interestLead): InterestLeadResource
    {
        return InterestLeadResource::make($interestLead);
    }

    public function update(Request $request, InterestLead $interestLead): InterestLeadResource
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'in:new,contacted,qualified,closed'],
        ]);

        $interestLead->update($data);
        return InterestLeadResource::make($interestLead);
    }

    public function export(Request $request): StreamedResponse
    {
        $filename = 'interest-leads-'.now()->format('Ymd-His').'.csv';

        $response = new StreamedResponse(function () use ($request) {
            $out = fopen('php://output', 'w');
            fputcsv($out, [
                'id',
                'submitted_at',
                'status',
                'interest_type',
                'full_name',
                'email',
                'phone',
                'company_name',
                'source_type',
                'source_title',
                'message',
            ]);

            $rows = $this->index($request)->collection;
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r->id,
                    $r->submitted_at,
                    $r->status,
                    $r->interest_type,
                    $r->full_name,
                    $r->email,
                    $r->phone,
                    $r->company_name,
                    $r->source_type,
                    $r->source_title,
                    $r->message,
                ]);
            }

            fclose($out);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');

        return $response;
    }
}

