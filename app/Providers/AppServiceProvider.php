<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Menu;
use Illuminate\Support\Facades\View;
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

            $menus = Menu::with('children')
                ->where('menu_location', 'header')
                ->whereNull('parent_id')
                ->where('status', 1)
                ->orderBy('sort_order')
                ->get();

            $footerMenus = Menu::with('children')
                ->where('status', 1)
                ->whereNull('parent_id')
                ->whereIn('menu_location', [
                    'footer_1',
                    'footer_2',
                    'footer_3',
                    'footer_4'
                ])
                ->orderBy('sort_order')
                ->get();

            $view->with([

                'globalCategories' => $categories,

                'globalRecentPosts' => $recentPosts,

                'globalPopularPosts' => $popularPosts,

                'menus' => $menus,

                'footerMenus' => $footerMenus,

            ]);
        });

        View::share(
            'siteSetting',
            Setting::first()
        );
    }
}
