<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Doctor extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'phone_number',
        'specialization'
    ];

    public function appointments(): HasMany {
        return $this->hasMany(Appointment::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
