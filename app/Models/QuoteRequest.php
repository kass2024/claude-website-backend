<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteRequest extends Model
{
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
        'country_code',
        'service_category',
        'service_name',
        'project_summary',
        'status',
        'currency',
        'line_items',
        'notes',
        'subtotal',
        'tax',
        'total',
        'approved_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'line_items' => 'array',
        'approved_at' => 'datetime',
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];
}

