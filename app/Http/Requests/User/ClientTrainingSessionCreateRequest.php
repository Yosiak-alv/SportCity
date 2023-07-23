<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ClientTrainingSessionCreateRequest extends FormRequest
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
            'training_session_id' => 'required|array',
            'training_session_id.*' =>'numeric|gt:0|decimal:0|max:255', //representa la iteracion de cada una 
        ];
    }

    public function validatedTrainingSessionsId()
    {
        return $this->only('training_session_id')['training_session_id'];
    }
}
