<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Gallery::class);

        $galleries = Gallery::latest()->paginate(20);

        return view(
            'admin.gallery.index',
            compact('galleries')
        );
    }

    public function create()
    {
        $this->authorize('create', Gallery::class);

        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Gallery::class);
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $gallery = Gallery::create([
            'image' => $request
                ->file('image')
                ->store('gallery', 'public'),

            'status' => true,
        ]);

        activityLog(
            'Gallery',
            'Create',
            'Gallery Image #' . $gallery->id
        );

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Image Uploaded');
    }

    public function edit(Gallery $gallery)
    {
        $this->authorize('update', $gallery);

        return view(
            'admin.gallery.edit',
            compact('gallery')
        );
    }

    public function update(Request $request, Gallery $gallery)
    {
        $this->authorize('update', $gallery);

        $request->validate([
            'status' => 'nullable|boolean',
        ]);

        $gallery->update([
            'status' => $request->boolean('status'),
        ]);

        activityLog(
            'Gallery',
            'Update',
            'Gallery Image #' . $gallery->id
        );

        return back()->with(
            'success',
            'Gallery Updated'
        );
    }

    public function destroy(Gallery $gallery)
    {
        $this->authorize('delete', $gallery);

        activityLog(
            'Gallery',
            'Delete',
            'Gallery Image #' . $gallery->id
        );

        $gallery->delete();

        return back()->with(
            'success',
            'Gallery moved to trash.'
        );
    }

    public function trash()
    {
        $this->authorize('viewAny', Gallery::class);

        $galleries = Gallery::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(20);

        return view(
            'admin.gallery.trash',
            compact('galleries')
        );
    }

    public function restore($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $gallery);

        $gallery->restore();

        activityLog(
            'Gallery',
            'Restore',
            'Gallery Image #' . $gallery->id
        );

        return back()->with(
            'success',
            'Gallery restored.'
        );
    }

    public function forceDelete($id)
    {
        $gallery = Gallery::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $gallery);

        if (
            $gallery->image &&
            Storage::disk('public')->exists($gallery->image)
        ) {
            Storage::disk('public')->delete($gallery->image);
        }

        activityLog(
            'Gallery',
            'Permanent Delete',
            'Gallery Image #' . $gallery->id
        );

        $gallery->forceDelete();

        return back()->with(
            'success',
            'Gallery permanently deleted.'
        );
    }
}
