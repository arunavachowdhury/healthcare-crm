<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\User;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class DoctorController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse {
        $validated = $request->validate([
            'user_id' => [
                'required',
                function (string $attribute, int $value, Closure $fail) {
                    $user = User::where('id', $value)->first();
                    if (blank($user) || ! $user->hasRole(UserRole::DOCTOR)) {
                        $fail("The {$attribute} is not valid for Doctor.");
                    } elseif (filled($user) && filled($user->doctor)) {
                        $fail("The {$attribute} is already assigned with a Doctor.");
                    }
                },
            ],
            'email' => 'nullable|email',
            'phone_number' => 'nullable',
            'specialization' => 'nullable',
        ]);

        $doctor = Doctor::create($validated);

        return response()->json(['status' => 'success', 'data' => $doctor]);
    }
}
