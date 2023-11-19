<?php

namespace App\Http\Requests\Coach;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ProfileCoachUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['min:8','regex:/^(2|6|7|8)[0-9]{7}$/'],
            'email' => ['email', 'max:255', Rule::unique('coaches','email')->ignore($this->user()->id)],
            'address' => ['min:10','string','max:5000'],
        ];
    }
}
