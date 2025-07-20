<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

final class AppointmentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(
        #[CurrentUser] User $user
    ): bool {
        if ($user->hasRole(UserRole::DOCTOR)) {
            $doctor = $user->doctor;

            return $this->appointment->doctor_id === $doctor->id;
        }

        return true;

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'appoinment_date_time' => ['required', Rule::date()->format('Y-m-d H:i')->todayOrAfter()],
            'status' => ['nullable', Rule::in([AppointmentStatus::COMPLETED, AppointmentStatus::CANCELLED, AppointmentStatus::NOT_SHOWING])],
            'notes' => 'nullable',
        ];
    }

    public function after(): array {
        return [
            function (Validator $validator) {
                if (Appointment::where('id', '<>', $this->appointment->id)
                    ->where(['doctor_id' => $this->appointment->doctor_id, 'appoinment_date_time' => $this->appoinment_date_time])
                    ->whereIn('status', [AppointmentStatus::SCHEDULED])
                    ->exists()
                ) {
                    $validator->errors()->add(
                        'appoinment_date_time',
                        'Please select another slot for booking!'
                    );
                }
            },
        ];
    }
}
