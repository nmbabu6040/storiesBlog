<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(10);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags,name',
            'status' => 'nullable|boolean',
        ]);

        Tag::create([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->boolean('status'),
        ]);

        activityLog(
            'Tag',
            'Create',
            $tag->name
        );

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,' . $tag->id,
            'status' => 'nullable|boolean',
        ]);

        $tag->update([
            'name'   => $request->name,
            'slug'   => Str::slug($request->name),
            'status' => $request->boolean('status'),
        ]);

        activityLog(
            'Tag',
            'Update',
            $tag->name
        );

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        activityLog(
            'Tag',
            'Delete',
            $tag->name
        );

        $tag->delete();

        return back()->with('success', 'Tag moved to trash.');
    }

    public function trash()
    {
        $trashTags = Tag::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view('admin.tags.trash', compact('trashTags'));
    }

    public function restore($id)
    {
        Tag::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back()->with('success', 'Tag restored successfully.');
    }

    public function forceDelete($id)
    {
        Tag::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return back()->with('success', 'Tag permanently deleted.');
    }
}
