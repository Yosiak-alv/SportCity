<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateEditProductRequest extends FormRequest
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
            'name' => ['required','max:255'],
            'description' => ['required','min:10','string','max:5000'],
            'unit_price' => ['required', 'gt:0','numeric'],
            'gym_id' => ['required','gt:0','numeric',],
            'quantity' => ['required', 'gt:0'],
        ];
    }
}
