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
            'name' => ['required','max:255',Rule::unique('products','name')->ignore($this->product)],
            'description' => ['required','min:10','string','max:5000'],
            'unit_price' => ['required', 'gt:0','numeric'],
            'gym_id' => [Rule::requiredIf($this->user()->hasRole('administrator') || $this->user()->hasRole('manager')),],
            'quantity' => ['required', 'gt:0'],
        ];
    }
    public function validatedAdmOrMang(): array
    {
        return $this->only('name','description','unit_price','gym_id','quantity');
    }
    public function validatedUserReg(): array
    {
        return $this->only('name','description','unit_price','quantity');
    }
}
