<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment; 
use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Get the comment from the route parameter
        $comment = Comment::find($this->route('comment'));
        
        // User can only update their own comments
        return $comment && $comment->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string|min:3',
        ];
    }

    public function messages(): array
    {
        return [
            'content.required' => 'Comment content is required',
            'content.min' => 'Comment must be at least 3 characters',
        ];
    }
}
