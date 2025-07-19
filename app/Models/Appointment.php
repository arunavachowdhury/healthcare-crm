<?php

namespace App\Models;

use App\Enums\AppointmentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'paitient_id',
        'doctor_id',
        'appoinment_date_time',
        'status',
        'notes'
    ];

    protected $casts = [
        'appoinment_date_time' => 'datetime:Y-m-d H:i',
        'status' => AppointmentStatus::class
    ];

    public function paitient(): BelongsTo {
        return $this->belongsTo(Paitient::class);
    }
    public function doctor(): BelongsTo {
        return $this->belongsTo(Doctor::class);
    }
}
