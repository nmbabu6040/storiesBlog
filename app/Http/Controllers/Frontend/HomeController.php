<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Gallery;
use Illuminate\Support\Str;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Advertisement;
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

        $travelPosts = $this->getCategoryPosts('travel', 4);

        $destinationPosts = $this->getCategoryPosts('destination');

        $lifestylePosts = $this->getCategoryPosts('lifestyle');

        $photographyPosts = $this->getCategoryPosts('photography');

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

        $headerAd = Advertisement::active('header')->first();

        $sidebarAd = Advertisement::active('sidebar')->first();

        $footerAd = Advertisement::active('footer')->first();

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
                'heroTypes',
                'headerAd',
                'sidebarAd',
                'footerAd',
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

        $recentPosts = $this->getRecentPosts();

        $popularPosts = $this->getPopularPosts();



        $setting = Setting::first();

        $destinationPosts = $this->getCategoryPosts('destination');

        $lifestylePosts = $this->getCategoryPosts('lifestyle');

        $photographyPosts = $this->getCategoryPosts('photography');

        $categories = Category::where('status', 1)
            ->latest()
            ->take(6)
            ->get();
        $headerAd = Advertisement::active('header')->first();

        $sidebarAd = Advertisement::active('sidebar')->first();

        $beforePostAd = Advertisement::active('before_post')->first();

        $afterPostAd = Advertisement::active('after_post')->first();

        $footerAd = Advertisement::active('footer')->first();
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
                'headerAd',
                'sidebarAd',
                'beforePostAd',
                'afterPostAd',
                'footerAd'
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

    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)
            ->firstOrFail();

        $posts = $tag->posts()
            ->where('status', 1)
            ->latest()
            ->paginate(9);

        return view(
            'frontend.tag',
            compact(
                'tag',
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

    private function getPopularPosts($limit = 5)
    {
        return Post::where('status', 1)
            ->where('review_status', 'approved')
            ->orderByDesc('views')
            ->take($limit)
            ->get();
    }

    private function getRecentPosts($limit = 5)
    {
        return Post::where('status', 1)
            ->where('review_status', 'approved')
            ->latest()
            ->take($limit)
            ->get();
    }
}
