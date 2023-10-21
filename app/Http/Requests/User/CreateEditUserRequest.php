<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateEditUserRequest extends FormRequest
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
            'dui' => ['required','regex:/^\d{8}-\d{1}$/','max:10',Rule::unique('users','dui')->ignore($this->user?->id)],
            'name' => ['required','max:255'],
            'lastname' => ['required','max:255'],
            'gym_id' => ['required','numeric','gt:0','exists:gyms,id'],
            'phone' => ['required','regex:/^\+?\d{1,4}?[-.\s]?\(?\d{1,3}?\)?[-.\s]?\d{1,4}[-.\s]?\d{1,4}[-.\s]?\d{1,9}$/'],
            'email' => ['required','email', 'max:255', Rule::unique('clients','email')->ignore($this->user?->id)],
            'password' => [Password::default()->min(8), Rule::requiredIf($this->user?->id == null)],
        ];
    }
}
