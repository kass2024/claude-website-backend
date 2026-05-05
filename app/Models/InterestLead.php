<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InterestLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_type',
        'source_id',
        'source_slug',
        'source_title',
        'interest_type',
        'full_name',
        'email',
        'phone',
        'company_name',
        'message',
        'consent',
        'status',
        'submitted_at',
    ];

    protected $casts = [
        'consent' => 'boolean',
        'submitted_at' => 'datetime',
    ];
}

