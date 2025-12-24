<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Comment\UpdateCommentRequest;
use App\Http\Requests\Comment\DeleteCommentRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Store a new comment on a product
     * 
     * @param StoreCommentRequest $request
     * @return JsonResponse
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        // Create the comment
        $comment = Comment::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(), 
            'content' => $request->content,
        ]);

        
        $comment->load('user');

        return response()->json([
            'message' => 'Comment created successfully',
            'comment' => $comment
        ], 201);
    }

    /**
     * Update an existing comment (only owner can update)
     * 
     * @param UpdateCommentRequest $request
     * @param int $comment
     * @return JsonResponse
     */
    public function update(UpdateCommentRequest $request, $comment): JsonResponse
    {
        // Find the comment
        $commentModel = Comment::find($comment);

        // This shouldn't happen because UpdateCommentRequest already checks
        if (!$commentModel) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        // Update the comment
        $commentModel->update([
            'content' => $request->content,
        ]);

        // Load user relationship
        $commentModel->load('user');

        return response()->json([
            'message' => 'Comment updated successfully',
            'comment' => $commentModel
        ], 200);
    }

    /**
     * Delete a comment (only owner can delete)
     * 
     * @param DeleteCommentRequest $request
     * @param int $comment
     * @return JsonResponse
     */
    public function destroy(DeleteCommentRequest $request, $comment): JsonResponse
    {
        // Find the comment
        $commentModel = Comment::find($comment);

        // This shouldn't happen because DeleteCommentRequest already checks
        if (!$commentModel) {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }

        // Delete the comment
        $commentModel->delete();

        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
    }
}