<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConsultationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'preferred_date' => ['nullable', 'date'],
            'consultation_type' => ['nullable', 'string', 'in:Virtual Meeting,Phone Call,In-Person Meeting'],
            'service_category' => ['nullable', 'string', 'max:100'],
            'project_summary' => ['required', 'string', 'max:10000'],
        ];
    }
}

