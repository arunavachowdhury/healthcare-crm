<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\PaitientObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([PaitientObserver::class])]
final class Paitient extends Model
{
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'email',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        'insurence_details',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array {
        return [
            'insurence_details' => 'array',
        ];
    }

    public function appointments(): HasMany {
        return $this->hasMany(Appointment::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function audits(): HasMany {
        return $this->hasMany(PaitientAudit::class);
    }
}
