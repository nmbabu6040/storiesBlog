<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with('post')
            ->latest()
            ->get();

        return view(
            'admin.comment.index',
            compact('comments')
        );
    }

    public function approve(Comment $comment)
    {
        $comment->update([
            'status' => 1
        ]);

        return back()->with(
            'success',
            'Comment Approved'
        );
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with(
            'success',
            'Comment Deleted'
        );
    }
}
