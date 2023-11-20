<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateEditPlanRequest extends FormRequest
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
            'name' => ['required','string','max:255',Rule::unique('plans','name')->ignore($this->plan)],
            'description' => 'required|string|min:8|max:255',
            'duration' => 'required|string|in:Month,Day',
            'price' => 'required|numeric|gt:0',
            'details' => 'required|array|min:1',
            'details.*.detail' => 'required|string|max:255',
        ];
    }
    public function validatedPlan(): array
    {
        return $this->only('name','description','duration','price');
    }
}
