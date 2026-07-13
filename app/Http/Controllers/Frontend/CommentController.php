<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'post_id'   => 'required|exists:posts,id',

            'parent_id' => 'nullable|exists:comments,id',

            'comment'   => 'required|string|max:2000',

        ]);

        $user = $request->user();

        $exists = Comment::where('post_id', $request->post_id)
            ->where('email', $user->email)
            ->where('comment', $request->comment)
            ->where('created_at', '>=', now()->subMinute())
            ->exists();

        if ($exists) {
            return back()->with(
                'error',
                'You have already submitted this comment.'
            );
        }

        $comment = Comment::create([

            'post_id'   => $request->post_id,

            'parent_id' => $request->parent_id,

            'name'      => $user->name,

            'email'     => $user->email,

            'comment'   => $request->comment,

            'status'    => 0,

        ]);

        $post = Post::findOrFail($request->post_id);

        activityLog(
            'Comment',
            'Create',
            auth()->user()->name . ' commented on ' . $post->title
        );


        createNotification(
            'New Comment',
            $request->comment,
            route('admin.comments.index'),
            'comment'
        );



        if ($request->ajax()) {

            return response()->json([
                'success' => true,
                'message' => 'Your comment has been submitted and is awaiting approval.'
            ]);
        }

        return back()->with(
            'success',
            'Your comment has been submitted and is awaiting approval.'
        );
    }
}
