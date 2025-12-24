<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins can update products
        return auth()->check() && auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock_count' => 'sometimes|integer|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'title.string' => 'Product title must be text',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price cannot be negative',
            'stock_count.integer' => 'Stock count must be a whole number',
            'stock_count.min' => 'Stock count cannot be negative',
        ];
    }
}
