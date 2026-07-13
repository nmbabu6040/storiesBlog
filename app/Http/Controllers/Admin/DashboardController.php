<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Menu;
use App\Models\Setting;
use App\Models\Advertisement;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {


        // Posts
        $totalPosts = Post::count();
        $publishedPosts = Post::where('status', 1)->count();
        $pendingPosts = Post::where('review_status', 'pending')->count();
        $featuredPosts = Post::where('featured', 1)->count();
        $latestPosts = Post::with('category', 'user')->latest()->take(5)->get();
        $topPosts = Post::orderByDesc('views')->take(5)->get();

        // Content
        $totalCategories = Category::count();
        $topCategories = Category::withCount('posts')->orderByDesc('posts_count')->take(5)->get();
        $totalTags = Tag::count();
        $totalPages = Page::count();
        $totalMenus = Menu::count();

        // Users
        $totalUsers = User::count();
        $latestUsers = User::latest()->take(5)->get();

        // Comments
        $totalComments = Comment::count();

        // Subscribers
        $totalSubscribers = Subscriber::count();
        $latestSubscribers = Subscriber::latest()->take(5)->get();

        // Messages
        $totalMessages = ContactMessage::count();
        $latestMessages = ContactMessage::latest()->take(5)->get();

        // Media
        $totalMedia = Media::count();

        // Views
        $totalViews = Post::sum('views');

        // Today Statistics
        $todaySubscribers = Subscriber::whereDate('created_at', today())->count();
        $todayMessages = ContactMessage::whereDate('created_at', today())->count();
        $monthlyPosts = Post::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyUsers = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlySubscribers = Subscriber::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = [];
        $postData = [];
        $userData = [];
        $subscriberData = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $postData[] = $monthlyPosts[$i] ?? 0;
            $userData[] = $monthlyUsers[$i] ?? 0;
            $subscriberData[] = $monthlySubscribers[$i] ?? 0;
        }

        return view('admin.dashboard.index', compact(

            'totalPosts',
            'publishedPosts',
            'pendingPosts',
            'featuredPosts',
            'latestPosts',

            'totalCategories',
            'totalTags',
            'totalPages',
            'totalMenus',

            'totalUsers',
            'latestUsers',
            'totalComments',

            'totalSubscribers',
            'todaySubscribers',

            'totalMessages',
            'todayMessages',

            'totalMedia',
            'totalViews',

            'topPosts',
            'latestSubscribers',
            'latestMessages',
            'topCategories',

            // Statistics
            'months',
            'postData',
            'userData',
            'subscriberData',
        ));
    }
}
