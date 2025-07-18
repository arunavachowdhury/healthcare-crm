<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PaitientUpdateRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => ['required', Rule::date()->format('Y-m-d')],
            'gender' => 'required|in:M,F,O',
            'phone_number' => [
                'required',
                Rule::unique('paitients')->ignore($this->paitient)
            ],
            'email' => [
                'nullable',
                Rule::unique('paitients')->ignore($this->paitient)
            ],
            'address' => 'nullable',
            'emergency_contact_name' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'insurence_details' => 'array'
        ];
    }
}
