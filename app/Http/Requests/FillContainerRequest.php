<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FillContainerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'quantity' => ['required', 'numeric', 'gt:0', 'regex:/^\d+(\.\d{1,3})?$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'quantity.required' => 'Quantity is required.',
            'quantity.numeric' => 'Quantity must be a number.',
            'quantity.gt' => 'Quantity must be greater than 0.',
            'quantity.regex' => 'Quantity may have at most 3 decimal places.',
        ];
    }
}
