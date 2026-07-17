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
        $this->authorize('viewAny', Tag::class);
        $tags = Tag::latest()->paginate(10);

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        $this->authorize('create', Tag::class);
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);
        $request->validate([
            'name' => 'required|max:255|unique:tags,name',
            'status' => 'nullable|boolean',
        ]);

        //slug
        $slug = Str::slug($request->name);

        $count = Tag::where('slug', 'LIKE', "{$slug}%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $tag = Tag::create([
            'name'   => $request->name,
            'slug'   => $slug,
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
        $this->authorize('update', $tag);
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);
        $request->validate([
            'name' => 'required|max:255|unique:tags,name,' . $tag->id,
            'status' => 'nullable|boolean',
        ]);

        //slug
        $slug = Str::slug($request->name);

        if ($tag->name != $request->name) {

            $originalSlug = $slug;
            $i = 1;

            while (
                Tag::where('slug', $slug)
                ->where('id', '!=', $tag->id)
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $i;
                $i++;
            }
        } else {

            $slug = $tag->slug;
        }

        $tag->update([
            'name'   => $request->name,
            'slug'   => $slug,
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
        $this->authorize('delete', $tag);

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
        $this->authorize('viewAny', Tag::class);
        $trashTags = Tag::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view('admin.tags.trash', compact('trashTags'));
    }

    public function restore($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $tag);

        $tag->restore();

        activityLog(
            'Tag',
            'Restore',
            $tag->name
        );

        return back()->with('success', 'Tag restored successfully.');
    }

    public function forceDelete($id)
    {
        $tag = Tag::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $tag);

        activityLog(
            'Tag',
            'Permanent Delete',
            $tag->name
        );

        $tag->forceDelete();

        return back()->with('success', 'Tag permanently deleted.');
    }
}
