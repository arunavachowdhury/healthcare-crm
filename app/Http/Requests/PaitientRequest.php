<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Models\User;
use Closure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class PaitientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'user_id' => [
                'required',
                function (string $attribute, int $value, Closure $fail) {
                    $user = User::where('id', $value)->first();
                    if (blank($user) || ! $user->hasRole(UserRole::PAITIENT)) {
                        $fail("The {$attribute} is not valid for Paitient.");
                    } elseif (filled($user) && filled($user->paitient)) {
                        $fail("The {$attribute} is already assigned with a Paitient.");
                    }
                },
            ],
            'first_name' => 'required',
            'last_name' => 'required',
            'date_of_birth' => ['required', Rule::date()->format('Y-m-d')],
            'gender' => 'required|in:M,F,O',
            'phone_number' => 'required|unique:paitients,phone_number',
            'email' => 'nullable|unique:paitients,email',
            'address' => 'nullable',
            'emergency_contact_name' => 'nullable',
            'emergency_contact_phone' => 'nullable',
            'insurence_details' => 'array',
        ];
    }
}
