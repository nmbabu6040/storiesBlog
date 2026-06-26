<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\View;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $categories = Category::where('status', 1)
                ->orderBy('name')
                ->get();

            $recentPosts = Post::where('status', 1)
                ->latest()
                ->take(5)
                ->get();

            $popularPosts = Post::where('status', 1)
                ->orderByDesc('views')
                ->take(5)
                ->get();

            $view->with([
                'globalCategories' => $categories,
                'globalRecentPosts' => $recentPosts,
                'globalPopularPosts' => $popularPosts,
            ]);
        });

        View::share(
            'siteSetting',
            Setting::first()
        );

        View::share(
            'footerCategories',
            Category::where('status', 1)
                ->orderBy('name')
                ->get()
        );
    }
}
