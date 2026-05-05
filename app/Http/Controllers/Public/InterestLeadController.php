<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\InterestLeadResource;
use App\Models\InterestLead;
use Illuminate\Http\Request;

class InterestLeadController extends Controller
{
    public function store(Request $request): InterestLeadResource
    {
        $data = $request->validate([
            'source_type' => ['nullable', 'string', 'max:50'],
            'source_id' => ['nullable', 'integer'],
            'source_slug' => ['nullable', 'string', 'max:255'],
            'source_title' => ['nullable', 'string', 'max:255'],
            'interest_type' => ['required', 'string', 'max:50'],
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'consent' => ['required', 'boolean'],
        ]);

        $data['status'] = 'new';
        $data['submitted_at'] = now();

        $lead = InterestLead::query()->create($data);

        return InterestLeadResource::make($lead);
    }
}

