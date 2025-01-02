<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'SKU' => [
                'required',
                'regex:/^\S*$/', // Ensure no spaces in SKU
                Rule::unique('products', 'SKU')->ignore($this->route('id')),
            ],
            'price' => 'required|numeric',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required'         => "Product name must be required!!",
            'SKU.required'          => ":attribute must be required!!",
            'SKU.regex'             => 'The :attribute must not contain spaces.',
            'price.required'        => "Price must be required!!",
        ];
    }

    public function attributes(): array
    {
        return [
            'SKU' => 'Stock keeping unit (SKU)',
        ];
    }
}
