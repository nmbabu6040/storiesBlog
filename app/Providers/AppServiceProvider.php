<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Page;
use App\Policies\PagePolicy;
use App\Models\Setting;
use App\Policies\SettingPolicy;
use App\Models\Menu;
use App\Policies\MenuPolicy;
use App\Models\Notification;
use App\Models\Tag;
use App\Policies\TagPolicy;
use App\Models\Gallery;
use App\Policies\GalleryPolicy;
use App\Models\Media;
use App\Policies\MediaPolicy;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use App\Models\User;
use App\Policies\UserPolicy;
use App\Models\ContactMessage;
use App\Policies\ContactMessagePolicy;
use App\Models\Subscriber;
use App\Policies\SubscriberPolicy;
use App\Policies\BackupPolicy;
use App\Models\ActivityLog;
use App\Policies\ActivityLogPolicy;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Advertisement;
use App\Policies\AdvertisementPolicy;
use App\Policies\CategoryPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(Page::class, PagePolicy::class);
        Gate::policy(Menu::class, MenuPolicy::class);
        Gate::policy(Gallery::class, GalleryPolicy::class);
        Gate::policy(Media::class, MediaPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Tag::class, TagPolicy::class);
        Gate::policy(Setting::class, SettingPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        Gate::policy(ContactMessage::class, ContactMessagePolicy::class);
        Gate::policy(Advertisement::class, AdvertisementPolicy::class);
        Gate::policy(Subscriber::class, SubscriberPolicy::class);
        Gate::policy(ActivityLog::class, ActivityLogPolicy::class);
        Gate::define('backup-view', [BackupPolicy::class, 'viewAny']);
        Gate::define('backup-create', [BackupPolicy::class, 'create']);
        Gate::define('backup-download', [BackupPolicy::class, 'download']);
        Gate::define('backup-delete', [BackupPolicy::class, 'delete']);



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

            $view->with(
                'sidebarTags',
                Tag::where('status', 1)
                    ->withCount('posts')
                    ->orderBy('name')
                    ->get()
            );
        });

        View::composer('admin.layouts.master', function ($view) {

            $view->with(
                'notifications',
                Notification::latest()->take(10)->get()
            );

            $view->with(
                'notificationCount',
                Notification::where('is_read', false)->count()
            );
        });

        View::share(
            'siteSetting',
            Setting::first()
        );

        View::share([
            'headerAd' => Advertisement::active('header')->first(),
            'sidebarAd' => Advertisement::active('sidebar')->first(),
            'beforePostAd' => Advertisement::active('before_post')->first(),
            'afterPostAd' => Advertisement::active('after_post')->first(),
            'footerAd' => Advertisement::active('footer')->first(),
        ]);
    }
}
