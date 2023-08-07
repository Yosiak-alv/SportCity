<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateEditSuscriptionClient extends FormRequest
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
            'client_id' => ['required','gt:0'],
            'plan_id' => ['required','gt:0'],
            'user_id' =>  ['gt:0','numeric'],
            'transaction' => ['required', 'string', 'in:Cash,Card',Rule::excludeIf($this->route('suscription') != null)],
            'card_number' =>  ['string','nullable'],
            'cvv' => ['numeric','gt:0','nullable'],
            'exp_date' => ['string','nullable']
        ];
    }
}
