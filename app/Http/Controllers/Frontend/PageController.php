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

        $posts = Post::where('status', 1)
            ->where('review_status', 'approved')
            ->latest()
            ->paginate(9);

        $setting = Setting::first();

        $destinationPosts = $this->getCategoryPosts('destination');

        $lifestylePosts = $this->getCategoryPosts('lifestyle');

        $photographyPosts = $this->getCategoryPosts('photography');

        $categories = Category::where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        $heroTypes = array_filter(
            array_map(
                'trim',
                explode(',', $setting->hero_type_text ?? '')
            )
        );

        return view('frontend.pages.show', compact('page', 'setting', 'destinationPosts', 'lifestylePosts', 'photographyPosts', 'categories', 'heroTypes', 'posts'));
    }

    private function getCategoryPosts($slug, $limit = 3)
    {
        return Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->whereHas('category', function ($query) use ($slug) {
                $query->where('slug', $slug);
            })
            ->latest()
            ->take($limit)
            ->get();
    }
}
