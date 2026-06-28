<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Post;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $setting = Setting::first();

        $destinationPosts = Post::where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        $lifestylePosts = Post::where('status', 1)
            ->latest()
            ->skip(3)
            ->take(3)
            ->get();

        $photographyPosts = Post::where('status', 1)
            ->latest()
            ->skip(6)
            ->take(3)
            ->get();

        $categories = Category::where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        return view('frontend.pages.show', compact('page', 'setting', 'destinationPosts', 'lifestylePosts', 'photographyPosts', 'categories'));
    }
}
