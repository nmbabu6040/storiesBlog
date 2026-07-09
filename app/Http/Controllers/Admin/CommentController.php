<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::with([
            'post',
            'replies'
        ])
            ->whereNull('parent_id')
            ->latest()
            ->paginate(15);

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

    public function reply(Comment $comment)
    {
        return view('admin.comment.reply', compact('comment'));
    }

    public function replyStore(Request $request, Comment $comment)
    {
        $request->validate([
            'comment' => 'required'
        ]);

        Comment::create([

            'post_id'   => $comment->post_id,

            'parent_id' => $comment->id,

            'name'      => auth()->user()->name,

            'email'     => auth()->user()->email,

            'comment'   => $request->comment,

            'status'    => 1,

        ]);

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Reply posted successfully.');
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
