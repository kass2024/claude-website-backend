<?php

namespace App\Models;

use Database\Factories\SettingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<SettingFactory> */
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'key';
    }

    /**
     * @var array<int, string>
     */
    protected $fillable = ['key', 'value', 'group'];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'array',
    ];
}

