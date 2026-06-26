<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\ContactMessage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPosts = Post::count();

        $totalCategories = Category::count();

        $featuredPosts = Post::where('featured', 1)->count();

        $totalMessages = ContactMessage::count();

        return view(
            'admin.dashboard.index',
            compact(
                'totalPosts',
                'totalCategories',
                'featuredPosts',
                'totalMessages'
            )
        );
    }
}
