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
        $pages = Page::latest()->get();

        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:pages,slug',
            'content' => 'nullable',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        $data = $request->only([
            'title',
            'slug',
            'content',
            'meta_title',
            'meta_description'
        ]);

        $data['status'] = $request->boolean('status');

        if ($request->hasFile('banner_image')) {

            $data['banner_image'] = $request
                ->file('banner_image')
                ->store('pages', 'public');
        }

        Page::create($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page Created Successfully');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:pages,slug,' . $page->id,
            'content' => 'nullable',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable',
        ]);

        $data = $request->only([
            'title',
            'slug',
            'content',
            'meta_title',
            'banner_image',
            'meta_description'
        ]);

        $data['status'] = $request->boolean('status');

        $bannerImage = $page->banner_image;

        if ($request->hasFile('banner_image')) {

            if ($page->banner_image) {

                Storage::disk('public')->delete($page->banner_image);
            }

            $bannerImage = $request
                ->file('banner_image')
                ->store('pages', 'public');
        } elseif ($request->filled('remove_banner')) {

            if ($page->banner_image) {

                Storage::disk('public')->delete($page->banner_image);
            }

            $bannerImage = null;
        }

        $page->update($data);

        return redirect()
            ->route('admin.pages.index')
            ->with('success', 'Page Updated Successfully');
    }

    public function destroy(Page $page)
    {
        if ($page->banner_image && Storage::disk('public')->exists($page->banner_image)) {

            Storage::disk('public')->delete($page->banner_image);
        }

        $page->delete();

        return back()->with('success', 'Page Deleted Successfully');
    }
}
