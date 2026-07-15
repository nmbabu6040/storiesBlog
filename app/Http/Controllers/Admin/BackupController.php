<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        // $path = storage_path('app/private/blogStories');
        $path = storage_path(
            'app/private/' . config('backup.backup.name')
        );

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $files = collect(File::files($path))
            ->filter(fn($file) => str_ends_with($file->getFilename(), '.zip'))
            ->sortByDesc(fn($file) => $file->getMTime());

        return view('admin.backup.index', compact('files'));
    }

    public function create()
    {
        Artisan::call('backup:run');

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

        return back()->with(
            'success',
            'Backup Created Successfully.'
        );
    }

    public function download($file)
    {
        // $path = storage_path('app/private/' . $file);
        // $path = storage_path('app/private/blogStories/' . $file);
        $path = storage_path(
            'app/private/' . config('backup.backup.name') . '/' . $file
        );

        abort_unless(File::exists($path), 404);

        return response()->download($path);
    }

    public function delete($file)
    {
        // $path = storage_path('app/private/' . $file);
        // $path = storage_path('app/private/blogStories/' . $file);
        $path = storage_path(
            'app/private/' . config('backup.backup.name') . '/' . $file
        );

        if (File::exists($path)) {

            File::delete($path);

            activityLog(
                'System',
                'Backup Delete',
                auth()->user()->name . ' deleted backup.'
            );
        }

        return back()->with(
            'success',
            'Backup Deleted Successfully.'
        );
    }
}
