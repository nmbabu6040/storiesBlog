<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class BackupController extends Controller
{
    private function backupPath(): string
    {
        return storage_path('app/private/blogStories/blogStories');
    }

    public function index()
    {
        $path = $this->backupPath();

        // ফোল্ডারটি না থাকলে তৈরি করবে
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true, true);
        }

        // ফোল্ডারের ভেতরের সব জিপ ফাইল নিয়ে আসবে
        $files = File::files($path);

        // ফাইলগুলোকে ডেট অনুযায়ী সাজিয়ে ব্লেড ভিউতে পাঠানো
        $backups = collect($files)->map(function ($file) {
            return [
                'file_name' => $file->getFilename(),
                'file_size' => round($file->getSize() / 1024 / 1024, 2) . ' MB',
                'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
            ];
        })->sortByDesc('created_at');

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {


        Gate::authorize('backup-create');

        $exitCode = Artisan::call('backup:run');



        activityLog(
            'System',
            'Backup',
            auth()->user()->name . ' created a backup.'
        );

        createNotification(
            'Backup Created',
            'A new backup has been created.',
            route('admin.backup.index'),
            'system'
        );

        return redirect()
            ->route('admin.backup.index')
            ->with('success', Artisan::output());
    }

    public function download($file)
    {
        Gate::authorize('backup-download');

        $file = basename($file);

        $path = $this->backupPath() . DIRECTORY_SEPARATOR . $file;

        abort_unless(File::exists($path), 404);

        activityLog(
            'System',
            'Backup Download',
            auth()->user()->name . ' downloaded backup: ' . $file
        );

        return response()->download($path);
    }

    public function delete($file)
    {
        Gate::authorize('backup-delete');

        $file = basename($file);

        $path = $this->backupPath() . DIRECTORY_SEPARATOR . $file;

        if (!File::exists($path)) {
            return back()->with('error', 'Backup file not found.');
        }

        File::delete($path);

        activityLog(
            'System',
            'Backup Delete',
            auth()->user()->name . ' deleted backup: ' . $file
        );

        return back()->with(
            'success',
            'Backup deleted successfully.'
        );
    }
}
