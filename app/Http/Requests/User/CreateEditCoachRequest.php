<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateEditCoachRequest extends FormRequest
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
            'dui' => ['required','regex:/^\d{8}-\d{1}$/','max:10',Rule::unique('coaches','dui')->ignore($this->coach?->id)],
            'name' => ['required','max:255'],
            'lastname' => ['required','max:255'],
            'phone' => ['required','regex:/^(2|6|7|8)[0-9]{7}$/'],
            'address' => ['required','min:10','string','max:5000'],
            'gym_id' => [Rule::requiredIf($this->user()->hasRole('administrator') || $this->user()->hasRole('manager')),],
            'email' => ['required','email', 'max:255', Rule::unique('coaches','email')->ignore($this->coach?->id)],
            //'password' => ['required','string','max:255',Rule::excludeIf($this->client != null)],
        ];
    }
    public function validatedCoachAdmOrMang(): array
    {
        return $this->only('dui','name','lastname','phone','address','gym_id','email');
    }
    public function validatedCoachUserReg(): array
    {
        return $this->only('dui','name','lastname','phone','address','email');
    }
}
