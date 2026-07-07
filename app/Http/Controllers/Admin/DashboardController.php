<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{


    public function index()
    {

        $postsChart = [];

        for ($i = 6; $i >= 0; $i--) {

            $postsChart[] = Post::whereDate(
                'created_at',
                now()->subDays($i)
            )->count();
        }
        return view('admin.dashboard.index', [

            'totalPosts'      => Post::count(),

            'publishedPosts'  => Post::where('review_status', 'approved')->count(),

            'pendingPosts'    => Post::where('review_status', 'pending')->count(),

            'featuredPosts'   => Post::where('featured', 1)->count(),

            'totalCategories' => Category::count(),

            'totalUsers'      => User::count(),

            'totalComments'   => Comment::count(),

            'totalSubscribers' => Subscriber::count(),

            'totalMessages'   => ContactMessage::count(),

            'latestPosts' => Post::with(['category', 'user'])
                ->latest()
                ->take(5)
                ->get(),

            'latestUsers' => User::latest()
                ->take(5)
                ->get(),

            'latestComments' => Comment::with('post')
                ->latest()
                ->take(5)
                ->get(),

            'latestMessages' => ContactMessage::latest()
                ->take(5)
                ->get(),

            'postsChart' => $postsChart,

        ]);
    }
}
