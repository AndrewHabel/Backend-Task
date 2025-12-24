<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins can create products
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_count' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Product title is required',
            'description.required' => 'Product description is required',
            'price.required' => 'Product price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price cannot be negative',
            'stock_count.required' => 'Stock count is required',
            'stock_count.integer' => 'Stock count must be a whole number',
            'stock_count.min' => 'Stock count cannot be negative',
        ];
    }
}
