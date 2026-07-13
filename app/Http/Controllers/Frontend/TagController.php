<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)
            ->firstOrFail();

        $posts = $tag->posts()
            ->where('status', 1)
            ->latest()
            ->paginate(9);

        return view(
            'frontend.tag.show',
            compact('tag', 'posts')
        );
    }
}
