<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Page::class);

        $pages = Page::latest()->paginate(10);

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $this->authorize('create', Page::class);

        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Page::class);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        $data = $request->only([
            'title',
            'content',
            'meta_title',
            'meta_description',
        ]);

        // Slug
        $slug = Str::slug($request->title);

        $count = Page::where('slug', 'LIKE', "{$slug}%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $data['slug'] = $slug;
        $data['status'] = $request->boolean('status');

        // Banner Image
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request
                ->file('banner_image')
                ->store('pages', 'public');
        }

        $page = Page::create($data);

        activityLog(
            'Page',
            'Create',
            $page->title
        );

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page Created Successfully');
    }

    public function edit(Page $page)
    {
        $this->authorize('update', $page);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $this->authorize('update', $page);

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        $data = $request->only([
            'title',
            'content',
            'meta_title',
            'meta_description',
        ]);

        // Slug
        $slug = Str::slug($request->title);

        if ($page->title !== $request->title) {

            $originalSlug = $slug;
            $i = 1;

            while (
                Page::where('slug', $slug)
                ->where('id', '!=', $page->id)
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $i;
                $i++;
            }
        } else {
            $slug = $page->slug;
        }

        $data['slug'] = $slug;
        $data['status'] = $request->boolean('status');

        // Banner Image
        $bannerImage = $page->banner_image;

        if ($request->hasFile('banner_image')) {

            if (
                $page->banner_image &&
                Storage::disk('public')->exists($page->banner_image)
            ) {
                Storage::disk('public')->delete($page->banner_image);
            }

            $bannerImage = $request
                ->file('banner_image')
                ->store('pages', 'public');
        } elseif ($request->filled('remove_banner')) {

            if (
                $page->banner_image &&
                Storage::disk('public')->exists($page->banner_image)
            ) {
                Storage::disk('public')->delete($page->banner_image);
            }

            $bannerImage = null;
        }

        $data['banner_image'] = $bannerImage;

        $page->update($data);

        activityLog(
            'Page',
            'Update',
            $page->title
        );

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page Updated Successfully');
    }

    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);

        activityLog(
            'Page',
            'Delete',
            $page->title
        );

        $page->delete();

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page moved to trash.');
    }

    public function trash()
    {
        $this->authorize('viewAny', Page::class);

        $pages = Page::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view('admin.pages.trash', compact('pages'));
    }

    public function restore($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $page);

        $page->restore();

        activityLog(
            'Page',
            'Restore',
            $page->title
        );

        return redirect()
            ->route('admin.pages.trash')
            ->with('success', 'Page restored successfully.');
    }

    public function forceDelete($id)
    {
        $page = Page::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $page);

        if (
            $page->banner_image &&
            Storage::disk('public')->exists($page->banner_image)
        ) {
            Storage::disk('public')->delete($page->banner_image);
        }

        activityLog(
            'Page',
            'Permanent Delete',
            $page->title
        );

        $page->forceDelete();

        return redirect()
            ->route('admin.pages.trash')
            ->with('success', 'Page permanently deleted.');
    }
}
