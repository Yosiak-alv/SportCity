<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditSuscription extends FormRequest
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
            'client_id' => 'required|exists:clients,id',
            'plan_id' => 'required|exists:plans,id',
            'user_id' => 'numeric|gt:0|exists:users,id'
        ];
    }

    public function validatedSuscription(): array
    {
        return $this->only('client_id','plan_id','ends_at','user_id');
    }
}
