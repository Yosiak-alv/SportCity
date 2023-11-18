<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEditGymRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:6' ,'max:255', Rule::unique('gyms','name')->ignore($this->gym?->id)],
            'address' => ['required','min:10','string','max:5000'],
            'email' => ['required','email', 'max:255', Rule::unique('gyms','email')->ignore($this->gym?->id)],
            'phone' => ['required','regex:/^(2|6|7|8)[0-9]{7}$/'],
            'department_id' => ['required', 'numeric' , 'gt:0', 'exists:departments,id'],
        ];
    }
}
