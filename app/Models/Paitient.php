<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paitient extends Model
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
        'insurence_details'
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'insurence_details' => 'array',
        ];
    }
}
