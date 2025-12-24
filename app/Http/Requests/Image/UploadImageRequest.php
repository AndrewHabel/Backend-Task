<?php

namespace App\Http\Requests\Image;

use Illuminate\Foundation\Http\FormRequest;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins can upload product images
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
            'product_id' => 'required|exists:products,id',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Product ID is required',
            'product_id.exists' => 'This product does not exist',
            'images.required' => 'At least one image is required',
            'images.array' => 'Images must be sent as an array',
            'images.max' => 'You can upload maximum 5 images at once',
            'images.*.image' => 'Each file must be an image',
            'images.*.mimes' => 'Images must be jpeg, jpg, png, or gif',
            'images.*.max' => 'Each image must not exceed 2MB',
        ];
    }
}
