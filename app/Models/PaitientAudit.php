<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaitientAudit extends Model
{
    protected $fillable = [
        'user_id',
        'paitient_id',
        'action',
        'old_values',
        'new_values',
        'ip_address'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    public function paitient(): BelongsTo 
    {
        return $this->belongsTo(Paitient::class);
    }
}
