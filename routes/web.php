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
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
// use Illuminate\Support\Facades\Auth;

// Route::get('/force-logout', function () {
//     Auth::logout();
//     request()->session()->invalidate();
//     request()->session()->regenerateToken();

//     return redirect('/login');
// });

Route::get('/generate-sitemap', function () {

    $sitemap = Sitemap::create();

    $posts = \App\Models\Post::where(
        'status',
        1
    )->get();

    foreach ($posts as $post) {

        $sitemap->add(
            Url::create(
                url('/post/' . $post->slug)
            )
        );
    }

    $sitemap->writeToFile(
        public_path('sitemap.xml')
    );

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
    Route::view('/about-us', 'frontend.pages.about')->name('about');
    Route::view('/contact-us', 'frontend.pages.contact')->name('contact');
    Route::view('/privacy-policy', 'frontend.pages.privacy')->name('privacy');
    Route::view('/disclaimer', 'frontend.pages.disclaimer')->name('disclaimer');
    Route::view('/terms-conditions', 'frontend.pages.terms')->name('terms');
    Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.submit');
    Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');
    Route::post(
        '/comment-submit',
        [CommentController::class, 'store']
    )->name('comment.store');
});




/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth'])->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);

    Route::resource('posts', PostController::class);

    Route::get('/messages', [ContactMessageController::class, 'index'])->name('messages.index');

    Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');

    Route::get(
        '/settings',
        [SettingController::class, 'edit']
    )->name('settings.edit');

    Route::post(
        '/settings',
        [SettingController::class, 'update']
    )->name('settings.update');

    Route::resource(
        'galleries',
        GalleryController::class
    )->except(['show']);

    Route::get(
        '/comments',
        [\App\Http\Controllers\Admin\CommentController::class, 'index']
    )->name('comments.index');

    Route::post(
        '/comments/{comment}/approve',
        [\App\Http\Controllers\Admin\CommentController::class, 'approve']
    )->name('comments.approve');

    Route::delete(
        '/comments/{comment}',
        [\App\Http\Controllers\Admin\CommentController::class, 'destroy']
    )->name('comments.destroy');
});


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__ . '/auth.php';
