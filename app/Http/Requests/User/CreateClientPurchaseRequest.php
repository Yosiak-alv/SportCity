<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class CreateClientPurchaseRequest extends FormRequest
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
            'product_id' => 'required|array',
            'product_id.*' =>'numeric|gt:0|decimal:0|max:255', //representa la iteracion de cada una 
            'quantity' => 'required|array',
            'quantity*' => 'numeric|gt:0|decimal:0',
            'transaction' => ['required', 'string', 'in:Cash,Card'],
        ];
    }
    public function validatedProductIds()
    {
        return collect($this->only('product_id')['product_id']);
    }

    public function quantities(): array
    {
        return $this->only('quantity')['quantity'];
    }
}
