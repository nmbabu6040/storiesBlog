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
        $this->authorize('viewAny', Comment::class);
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
        $this->authorize('update', $comment);
        $comment->update([
            'status' => 1
        ]);

        activityLog(
            'Comment',
            'Approve',
            $comment->name
        );

        return back()->with(
            'success',
            'Comment Approved'
        );
    }

    public function reply(Comment $comment)
    {
        $this->authorize('update', $comment);
        return view('admin.comment.reply', compact('comment'));
    }

    public function replyStore(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);
        $request->validate([
            'comment' => 'required'
        ]);

        $comments = Comment::create([

            'post_id'   => $comment->post_id,

            'parent_id' => $comment->id,

            'name'      => auth()->user()->name,

            'email'     => auth()->user()->email,

            'comment'   => $request->comment,

            'status'    => 1,

        ]);

        $post = Post::find($comment->post_id);

        if ($request->parent_id) {

            activityLog(
                'Comment',
                'Reply',
                auth()->user()->name . ' replied to a comment on "' . $post->title . '"'
            );
        } else {

            activityLog(
                'Comment',
                'Create',
                auth()->user()->name . ' commented on "' . $post->title . '"'
            );
        }

        return redirect()
            ->route('admin.comments.index')
            ->with('success', 'Reply posted successfully.');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        activityLog(
            'Comment',
            'Delete',
            $comment->name
        );

        $comment->delete();

        return back()->with(
            'success',
            'Comment moved to trash.'
        );
    }

    public function trash()
    {
        $this->authorize('viewAny', Comment::class);

        $comments = Comment::onlyTrashed()
            ->with('post')
            ->latest('deleted_at')
            ->paginate(15);

        return view(
            'admin.comment.trash',
            compact('comments')
        );
    }

    public function restore($id)
    {
        $comment = Comment::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('update', $comment);

        $comment->restore();

        activityLog(
            'Comment',
            'Restore',
            $comment->name
        );

        return back()->with(
            'success',
            'Comment restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        $comment = Comment::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('delete', $comment);

        activityLog(
            'Comment',
            'Permanent Delete',
            $comment->name
        );

        $comment->forceDelete();

        return back()->with(
            'success',
            'Comment permanently deleted.'
        );
    }
}
