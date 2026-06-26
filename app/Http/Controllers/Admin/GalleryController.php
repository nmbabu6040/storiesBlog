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
        $galleries = Gallery::latest()->get();

        return view(
            'admin.gallery.index',
            compact('galleries')
        );
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        Gallery::create([

            'image' => $request
                ->file('image')
                ->store('gallery', 'public'),

            'status' => 1
        ]);

        return redirect()
            ->route('admin.galleries.index')
            ->with('success', 'Image Uploaded');
    }

    public function edit(Gallery $gallery)
    {
        return view(
            'admin.gallery.edit',
            compact('gallery')
        );
    }

    public function update(Request $request, Gallery $gallery)
    {
        $gallery->update([
            'status' => $request->status ? 1 : 0
        ]);

        return back()->with(
            'success',
            'Gallery Updated'
        );
    }

    public function destroy(Gallery $gallery)
    {
        Storage::disk('public')
            ->delete($gallery->image);

        $gallery->delete();

        return back()->with(
            'success',
            'Gallery Deleted'
        );
    }
}
