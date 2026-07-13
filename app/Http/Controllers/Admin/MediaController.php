<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $media = Media::latest()->paginate(20);

        return view('admin.media.index', compact('media'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:4096',
        ]);

        $file = $request->file('image');

        $path = $file->store('media', 'public');

        Media::create([

            'user_id' => auth()->id(),

            'file_name' => $file->getClientOriginalName(),

            'file_path' => $path,

            'file_type' => $file->getMimeType(),

            'file_size' => $file->getSize(),

        ]);

        activityLog(
            'Media',
            'Upload',
            $file->getClientOriginalName()
        );

        return redirect()
            ->route('admin.media.index')
            ->with('success', 'Image uploaded successfully.');
    }

    public function trash()
    {
        $trashMedia = Media::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'admin.media.trash',
            compact('trashMedia')
        );
    }

    public function destroy(Media $media)
    {
        activityLog(
            'Media',
            'Delete',
            $media->file_name
        );

        $media->delete();

        return back()->with(
            'success',
            'Media moved to trash.'
        );
    }
    public function restore($id)
    {
        Media::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back()->with(
            'success',
            'Media restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        $media = Media::onlyTrashed()
            ->findOrFail($id);

        if ($media->file_path) {

            Storage::disk('public')
                ->delete($media->file_path);
        }

        $media->forceDelete();

        return back()->with(
            'success',
            'Media permanently deleted.'
        );
    }
}
