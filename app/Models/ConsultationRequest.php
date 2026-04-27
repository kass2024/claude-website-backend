<?php

namespace App\Models;

use Database\Factories\ConsultationRequestFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    /** @use HasFactory<ConsultationRequestFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'company',
        'email',
        'phone',
        'country',
        'service_category',
        'consultation_type',
        'preferred_date',
        'project_summary',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'preferred_date' => 'date',
    ];
}

