<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Validation\Rule;
use App\Enums\AppointmentStatus;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'paitient_id' => 'required|exists:paitients,id',
            'appoinment_date_time' => ['required', Rule::date()->format('Y-m-d H:i')->todayOrAfter()],
            'notes' => 'nullable'
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if (Appointment::where(['doctor_id'=> $this->doctor_id, 'appoinment_date_time'=> $this->appoinment_date_time])
                                ->whereIn('status', [AppointmentStatus::SCHEDULED])->exists()) {
                    $validator->errors()->add(
                        'appoinment_date_time',
                        'Please select another slot for booking!'
                    );
                }
            }
        ];
    }
}
