<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([

            'post_id' => 'required|exists:posts,id',

            'name' => 'required|max:255',

            'email' => 'required|email',

            'comment' => 'required'

        ]);

        Comment::create([

            'post_id' => $request->post_id,

            'name' => $request->name,

            'email' => $request->email,

            'comment' => $request->comment,

            'status' => 0

        ]);

        return back()->with(
            'success',
            'Comment submitted and awaiting approval.'
        );
    }
}
