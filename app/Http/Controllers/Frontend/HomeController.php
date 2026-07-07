<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Support\Str;
use App\Models\Comment;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        $featuredPosts = Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->where('featured', 1)
            ->latest()
            ->take(3)
            ->get();

        $latestPosts = Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->latest()
            ->take(4)
            ->get();

        $categories = Category::where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        $popularPosts = Post::where('status', 1)
            ->where('review_status', 'approved')
            ->orderByDesc('views')
            ->take(4)
            ->get();

        $travelPosts = Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->when($setting?->travel_category_id, function ($query) use ($setting) {
                $query->where('category_id', $setting->travel_category_id);
            })
            ->latest()
            ->take(4)
            ->get();

        $destinationPosts = Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->when($setting?->destination_category_id, function ($query) use ($setting) {
                $query->where('category_id', $setting->destination_category_id);
            })
            ->latest()
            ->take(3)
            ->get();

        $lifestylePosts = Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->when($setting?->lifestyle_category_id, function ($query) use ($setting) {
                $query->where('category_id', $setting->lifestyle_category_id);
            })
            ->latest()
            ->take(3)
            ->get();

        $photographyPosts = Post::with('category')
            ->where('status', 1)
            ->where('review_status', 'approved')
            ->when($setting?->photography_category_id, function ($query) use ($setting) {
                $query->where('category_id', $setting->photography_category_id);
            })
            ->latest()
            ->take(3)
            ->get();

        $galleryImages = Gallery::where('status', 1)
            ->latest()
            ->take(6)
            ->get();

        $latestComments = Comment::with('post')
            ->where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        $heroTypes = array_filter(
            array_map(
                'trim',
                explode(',', $setting->hero_type_text ?? '')
            )
        );

        return view(
            'frontend.home.index',
            compact(
                'featuredPosts',
                'latestPosts',
                'categories',
                'popularPosts',
                'travelPosts',
                'destinationPosts',
                'lifestylePosts',
                'photographyPosts',
                'galleryImages',
                'latestComments',
                'setting',
                'heroTypes'
            )
        );
    }

    public function show($slug)
    {
        $post = Post::with([
            'category',
            'comments' => function ($query) {
                $query->where('status', 1)
                    ->latest();
            }
        ])->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $post->increment('views');

        $relatedPosts = Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('status', 1)
            ->latest()
            ->take(4)
            ->get();

        $recentPosts = Post::where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        $popularPosts = Post::where('status', 1)
            ->orderByDesc('views')
            ->take(5)
            ->get();



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

        $setting = Setting::first();



        return view(
            'frontend.post.show',
            compact(
                'post',
                'relatedPosts',
                'recentPosts',
                'popularPosts',
                'destinationPosts',
                'lifestylePosts',
                'photographyPosts',
                'categories',
                'setting',
            )
        );
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        $posts = Post::where('category_id', $category->id)
            ->where('status', 1)
            ->latest()
            ->paginate(9);

        return view(
            'frontend.category.show',
            compact(
                'category',
                'posts'
            )
        );
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $posts = Post::where('status', 1)
            ->where(function ($query) use ($keyword) {

                $query->where(
                    'title',
                    'like',
                    "%{$keyword}%"
                );
            })
            ->latest()
            ->paginate(9);

        return view(
            'frontend.search.index',
            compact(
                'posts',
                'keyword'
            )
        );
    }
}
