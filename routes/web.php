<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\SubscriberController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;
use App\Http\Controllers\Admin\SummernoteController;
use App\Http\Controllers\Admin\AdvertisementController;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


// Route::get('/force-logout', function () {
//     Auth::logout();

//     request()->session()->invalidate();
//     request()->session()->regenerateToken();

//     return redirect('/');
// });

Route::get('/generate-sitemap', function () {

    $sitemap = Sitemap::create();

    $posts = \App\Models\Post::where('status', 1)->get();

    foreach ($posts as $post) {

        $sitemap->add(Url::create(url('/post/' . $post->slug)));
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap Generated';
});
/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/
Route::name('frontend.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/post/{slug}', [HomeController::class, 'show'])->name('post.show');
    Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.submit');
    Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');
    Route::post('/comment-submit', [CommentController::class, 'store'])
        ->middleware('auth')
        ->name('comment.store');
    Route::get('/comments/{post}', function (\App\Models\Post $post) {

        return view(
            'frontend.partials.comments',
            compact('post')
        );
    })->name('comments.load');

    Route::get('/{slug}', [FrontendPageController::class, 'show'])
        ->where('slug', '^(?!login|register|forgot-password|reset-password|verify-email|email|confirm-password|logout|profile|admin).*$')
        ->name('page');
});

/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware(['auth', 'role:Super Admin|Admin|Editor|Author'])
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Posts
        Route::resource('posts', PostController::class);

        // Categories
        Route::resource('categories', CategoryController::class)
            ->middleware('permission:manage-categories');

        // Pages
        Route::resource('pages', AdminPageController::class)
            ->middleware('permission:manage-pages');

        // Menus
        Route::resource('menus', MenuController::class)
            ->middleware('permission:manage-pages');

        // Gallery
        Route::resource('galleries', GalleryController::class)
            ->except(['show'])
            ->middleware('permission:manage-gallery');

        // Comments
        Route::get('/comments', [AdminCommentController::class, 'index'])
            ->name('comments.index')
            ->middleware('permission:manage-comments');

        Route::post('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])
            ->name('comments.approve')
            ->middleware('permission:manage-comments');

        Route::get('/comments/{comment}/reply', [AdminCommentController::class, 'reply'])
            ->name('comments.reply');

        Route::post('/comments/{comment}/reply', [AdminCommentController::class, 'replyStore'])
            ->name('comments.reply.store');



        Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])
            ->name('comments.destroy')
            ->middleware('permission:manage-comments');

        // Messages
        Route::get('/messages', [ContactMessageController::class, 'index'])
            ->name('messages.index');

        // Subscribers
        Route::get('/subscribers', [AdminSubscriberController::class, 'index'])
            ->name('subscribers.index');

        // Users (Super Admin Only)
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->middleware('permission:manage-users');

        // Settings (Super Admin Only)
        Route::get('/settings', [SettingController::class, 'edit'])
            ->name('settings.edit')
            ->middleware('permission:manage-settings');

        Route::post('/settings', [SettingController::class, 'update'])
            ->name('settings.update')
            ->middleware('permission:manage-settings');

        Route::post(
            '/posts/{post}/approve',
            [PostController::class, 'approve']
        )->name('posts.approve');

        Route::resource('media', \App\Http\Controllers\Admin\MediaController::class);
        Route::post('/summernote/upload', [App\Http\Controllers\Admin\SummernoteController::class, 'upload'])
            ->name('summernote.upload');

        Route::resource('advertisements', AdvertisementController::class)
            ->middleware('permission:manage-settings');
    });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
