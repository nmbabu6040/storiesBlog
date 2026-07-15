<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Admin\ContactMessageController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\NotificationController;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::get('/force-logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
});

// Route::get('/mail-test', function () {

//     Mail::raw('Laravel Mail Test', function ($message) {

//         $message->to('your_other_email@gmail.com')
//             ->subject('Mail Test');
//     });

//     return 'Mail Sent';
// });

// Generate Sitemap
Route::get('/generate-sitemap', function () {

    $sitemap = Sitemap::create();

    $posts = Post::where('status', 1)
        ->where('review_status', 'approved')
        ->get();

    foreach ($posts as $post) {

        $url = Url::create(route('frontend.post.show', $post->slug));

        if ($post->thumbnail) {

            $url->addImage(asset('storage/' . $post->thumbnail));
        }

        $sitemap->add($url);
    }

    $sitemap->writeToFile(public_path('sitemap.xml'));

    return 'Sitemap Generated Successfully';
});

//temporary routes

/*
|--------------------------------------------------------------------------
| Frontend
|--------------------------------------------------------------------------
*/
Route::middleware('maintenance')->name('frontend.')->group(function () {


    //home routes
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/post/{slug}', [HomeController::class, 'show'])->name('post.show');
    Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category.show');
    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/tag/{slug}', [HomeController::class, 'tag'])
        ->name('tag.show');



    //contact routes
    Route::post('/contact-submit', [ContactController::class, 'store'])->name('contact.submit');

    //subscribe routes
    Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

    //comment routes
    Route::post('/comment-submit', [CommentController::class, 'store'])
        ->middleware('auth')->name('comment.store');
    Route::get('/comments/{post}', function (\App\Models\Post $post) {
        return view(
            'frontend.partials.comments',
            compact('post')
        );
    })->name('comments.load');

    //page routes

    // Route::get('/test403', function () {
    //     abort(403);
    // });

    // Route::get('/test500', function () {
    //     abort(500);
    // });
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
        Route::post(
            '/posts/{post}/approve',
            [PostController::class, 'approve']
        )->name('posts.approve');
        Route::get('posts-trash', [PostController::class, 'trash'])
            ->name('posts.trash');

        Route::post('posts/{id}/restore', [PostController::class, 'restore'])
            ->name('posts.restore');

        Route::delete('posts/{id}/force-delete', [PostController::class, 'forceDelete'])
            ->name('posts.forceDelete');

        // Categories
        Route::resource('categories', CategoryController::class)
            ->middleware('permission:manage-categories');
        Route::get('categories-trash', [CategoryController::class, 'trash'])->name('categories.trash');

        Route::post('categories/{id}/restore', [CategoryController::class, 'restore'])
            ->name('categories.restore');

        Route::delete('categories/{id}/force-delete', [CategoryController::class, 'forceDelete'])
            ->name('categories.forceDelete');


        // Pages
        Route::resource('pages', AdminPageController::class)
            ->middleware('permission:manage-pages');
        Route::get('pages-trash', [AdminPageController::class, 'trash'])
            ->name('pages.trash');

        Route::post('pages/{id}/restore', [AdminPageController::class, 'restore'])
            ->name('pages.restore');

        Route::delete('pages/{id}/force-delete', [AdminPageController::class, 'forceDelete'])
            ->name('pages.forceDelete');

        // Menus
        Route::resource('menus', MenuController::class)
            ->middleware('permission:manage-pages');
        Route::get('menus-trash', [MenuController::class, 'trash'])->name('menus.trash');
        Route::post('menus/{id}/restore', [MenuController::class, 'restore'])->name('menus.restore');
        Route::delete('menus/{id}/force-delete', [MenuController::class, 'forceDelete'])->name('menus.forceDelete');

        // Gallery
        Route::resource('galleries', GalleryController::class)
            ->except(['show'])
            ->middleware('permission:manage-gallery');
        Route::get('galleries-trash', [GalleryController::class, 'trash'])->name('galleries.trash');
        Route::post('galleries/{id}/restore', [GalleryController::class, 'restore'])->name('galleries.restore');
        Route::delete('galleries/{id}/force-delete', [GalleryController::class, 'forceDelete'])->name('galleries.forceDelete');

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
        Route::get(
            '/messages',
            [ContactMessageController::class, 'index']
        )->name('messages.index');

        Route::delete(
            '/messages/{message}',
            [ContactMessageController::class, 'destroy']
        )->name('messages.destroy');

        Route::get(
            '/messages-trash',
            [ContactMessageController::class, 'trash']
        )->name('messages.trash');

        Route::post(
            '/messages/{id}/restore',
            [ContactMessageController::class, 'restore']
        )->name('messages.restore');

        Route::delete(
            '/messages/{id}/force-delete',
            [ContactMessageController::class, 'forceDelete']
        )->name('messages.forceDelete');


        // Subscribers
        Route::get('/subscribers', [AdminSubscriberController::class, 'index'])
            ->name('subscribers.index');

        Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])
            ->name('subscribers.destroy');

        Route::get(
            'subscribers-trash',
            [AdminSubscriberController::class, 'trash']
        )->name('subscribers.trash');

        Route::post(
            'subscribers/{id}/restore',
            [AdminSubscriberController::class, 'restore']
        )->name('subscribers.restore');

        Route::delete(
            'subscribers/{id}/force-delete',
            [AdminSubscriberController::class, 'forceDelete']
        )->name('subscribers.forceDelete');

        Route::post('/subscribers/bulk-delete', [AdminSubscriberController::class, 'bulkDelete'])
            ->name('subscribers.bulkDelete');

        Route::get('/subscribers/export', [AdminSubscriberController::class, 'export'])
            ->name('subscribers.export');

        //newsletter
        Route::get('/newsletter', [AdminSubscriberController::class, 'create'])
            ->name('newsletter.create');

        Route::post('/newsletter', [AdminSubscriberController::class, 'send'])
            ->name('newsletter.send');

        // Users (Super Admin Only)
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)
            ->middleware('permission:manage-users');
        Route::get('users-trash', [UserController::class, 'trash'])
            ->name('users.trash');

        Route::post('users/{id}/restore', [UserController::class, 'restore'])
            ->name('users.restore');

        Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])
            ->name('users.forceDelete');

        // Settings (Super Admin Only)
        Route::get('/settings', [SettingController::class, 'edit'])
            ->name('settings.edit')
            ->middleware('permission:manage-settings');

        Route::post('/settings', [SettingController::class, 'update'])
            ->name('settings.update')
            ->middleware('permission:manage-settings');

        // Media
        Route::resource('media', MediaController::class)
            ->parameter('media', 'media');

        Route::get(
            'media-trash',
            [MediaController::class, 'trash']
        )->name('media.trash');

        Route::post(
            'media/{id}/restore',
            [MediaController::class, 'restore']
        )->name('media.restore');

        Route::delete(
            'media/{id}/force-delete',
            [MediaController::class, 'forceDelete']
        )->name('media.forceDelete');

        // Summernote
        Route::post('/summernote/upload', [App\Http\Controllers\Admin\SummernoteController::class, 'upload'])
            ->name('summernote.upload');

        // Advertisements
        Route::resource('advertisements', AdvertisementController::class)
            ->middleware('permission:manage-settings');

        Route::get('advertisements-trash', [AdvertisementController::class, 'trash'])->name('advertisements.trash');
        Route::post('advertisements/{id}/restore', [AdvertisementController::class, 'restore'])->name('advertisements.restore');
        Route::delete('advertisements/{id}/force-delete', [AdvertisementController::class, 'forceDelete'])->name('advertisements.forceDelete');

        //tags
        Route::resource('tags', TagController::class);;

        Route::get(
            'tags-trash',
            [TagController::class, 'trash']
        )->name('tags.trash');

        Route::post(
            'tags/{id}/restore',
            [TagController::class, 'restore']
        )->name('tags.restore');

        Route::delete(
            'tags/{id}/force-delete',
            [TagController::class, 'forceDelete']
        )->name('tags.forceDelete');

        //Notification routes
        Route::get(
            '/notifications',
            [NotificationController::class, 'index']
        )->name('notifications.index');

        Route::post(
            '/notifications/read-all',
            [NotificationController::class, 'readAll']
        )->name('notifications.readAll');

        Route::post(
            '/notifications/{notification}/read',
            [NotificationController::class, 'read']
        )->name('notifications.read');

        Route::delete(
            '/notifications/{notification}',
            [NotificationController::class, 'destroy']
        )->name('notifications.destroy');

        Route::delete(
            '/notifications',
            [NotificationController::class, 'clear']
        )->name('notifications.clear');

        //profile routes
        Route::get('/profile', [ProfileController::class, 'edit'])
            ->name('profile.edit');

        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])
            ->name('profile.password');

        //activity log
        Route::get(
            '/activity-logs',
            [ActivityLogController::class, 'index']
        )->name('activity.index');

        Route::delete(
            '/activity-logs/{activityLog}',
            [ActivityLogController::class, 'destroy']
        )->name('activity.destroy');

        Route::delete(
            '/activity-logs',
            [ActivityLogController::class, 'clear']
        )->name('activity.clear');


        //system routes
        Route::post('/system/cache-clear', [SystemController::class, 'clearCache'])
            ->name('system.cache');

        Route::post('/system/config-clear', [SystemController::class, 'clearConfig'])
            ->name('system.config');

        Route::post('/system/route-clear', [SystemController::class, 'clearRoute'])
            ->name('system.route');

        Route::post('/system/view-clear', [SystemController::class, 'clearView'])
            ->name('system.view');

        Route::post('/system/optimize', [SystemController::class, 'optimize'])
            ->name('system.optimize');

        Route::post('/system/optimize-clear', [SystemController::class, 'optimizeClear'])
            ->name('system.optimizeClear');
        Route::post('/system/maintenance-on', [SystemController::class, 'maintenanceOn'])
            ->name('system.maintenance.on');

        Route::post('/system/maintenance-off', [SystemController::class, 'maintenanceOff'])
            ->name('system.maintenance.off');


        Route::prefix('backup')->name('backup.')->group(function () {

            Route::get('/', [BackupController::class, 'index'])
                ->name('index');

            Route::post('/create', [BackupController::class, 'create'])
                ->name('create');

            Route::get('/download/{file}', [BackupController::class, 'download'])
                ->name('download');

            Route::delete('/delete/{file}', [BackupController::class, 'delete'])
                ->name('delete');
        });
    });



// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


require __DIR__ . '/auth.php';
