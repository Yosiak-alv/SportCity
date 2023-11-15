<?php

namespace App\Http\Requests\User;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'gym_id' => [Rule::requiredIf($this->user()->hasRole('administrator') || $this->user()->hasRole('manager')),],
            'client_id' => ['required','numeric','gt:0','exists:clients,id'],
            'product_id' => 'required|array',
            'product_id.*' =>'numeric|gt:0|decimal:0|max:255', 
            'quantity' => 'required|array',
            'quantity*' => 'numeric|gt:0|decimal:0',
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
