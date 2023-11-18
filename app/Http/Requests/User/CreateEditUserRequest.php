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
            'phone' => ['required','regex:/^(2|6|7|8)[0-9]{7}$/'],
            'email' => ['required','email', 'max:255', Rule::unique('users','email')->ignore($this->user?->id)],
            'password' => [Password::default()->min(8), Rule::requiredIf($this->user?->id == null)],

            'roles_id' => ['required','array'],
            'roles_id.*' => ['numeric','gt:0','exists:roles,id'],
        ];
    }
    public function validatedUser(): array
    {
        return $this->only('dui','name','lastname','gym_id','phone','email','password');
    }
    public function validatedRolesIds(): array 
    {
        return $this->only('roles_id')['roles_id'];
    }
}
