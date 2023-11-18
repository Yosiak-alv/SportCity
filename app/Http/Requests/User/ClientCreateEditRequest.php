<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class ClientCreateEditRequest extends FormRequest
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
            'dui' => ['required','regex:/^\d{8}-\d{1}$/','max:10',Rule::unique('clients','dui')->ignore($this->client?->id)],
            'name' => ['required','max:255'],
            'lastname' => ['required','max:255'],
            'genre' => ['required','max:5'],
            'gym_id' => [Rule::requiredIf($this->user()->hasRole('administrator') || $this->user()->hasRole('manager')),],
            'birth_date' => ['required','date'],
            'address' => ['required','min:10','string','max:5000'],
            'phone' => ['required','regex:/^(2|6|7|8)[0-9]{7}$/'],
            'height' => ['required','numeric', 'gt:0'],
            'weight' => ['required','numeric', 'gt:0'],
            'email' => ['required','email', 'max:255', Rule::unique('clients','email')->ignore($this->client?->id)],
        ];
    }

    public function validatedClientAdmOrMang(): array
    {
        return $this->only('dui','name','lastname','genre','gym_id','birth_date','address','phone','height','weight','email');
    }

    public function validatedClientUserReg(): array
    {
        return $this->only('dui','name','lastname','genre','birth_date','address','phone','height','weight','email');
    }
}
