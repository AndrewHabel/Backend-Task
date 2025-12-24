<?php

namespace App\Http\Requests\Comment;

use App\Models\Comment; 
use Illuminate\Foundation\Http\FormRequest;

class DeleteCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Get the comment from route parameter
        $comment = Comment::find($this->route('comment'));
        
        // User can only delete their own comments
        return $comment && (
            $comment->user_id === auth()->id()
        );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
