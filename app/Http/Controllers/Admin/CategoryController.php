<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->paginate(10);

        return view(
            'admin.category.index',
            compact('categories')
        );
    }

    public function create()
    {
        $this->authorize('create', Category::class);

        return view('admin.category.create');
    }

    public function store(Request $request)
    {

        $this->authorize('create', Category::class);
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        //images
        $image = null;

        if ($request->hasFile('image')) {

            $image = $request
                ->file('image')
                ->store('categories', 'public');
        }

        //slug
        $slug = Str::slug($request->name);

        $count = Category::where('slug', 'LIKE', "{$slug}%")->count();

        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $category = Category::create([

            'name' => $request->name,

            'image' => $image,

            'slug' => $slug,

            'status' => $request->status ? 1 : 0

        ]);

        activityLog(
            'Category',
            'Create',
            $category->name
        );

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category Created Successfully'
            );
    }

    public function edit(Category $category)
    {

        $this->authorize('update', $category);
        return view(
            'admin.category.edit',
            compact('category')
        );
    }

    public function update(Request $request, Category $category)
    {

        $this->authorize('update', $category);

        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        //images
        $image = $category->image;

        if ($request->hasFile('image')) {

            if (
                $category->image &&
                Storage::disk('public')->exists($category->image)
            ) {

                Storage::disk('public')
                    ->delete($category->image);
            }

            $image = $request
                ->file('image')
                ->store('categories', 'public');
        }

        //slug
        $slug = Str::slug($request->name);

        if ($category->name !== $request->name) {

            $originalSlug = $slug;
            $i = 1;

            while (
                Category::where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $i;
                $i++;
            }
        } else {

            $slug = $category->slug;
        }

        $category->update([

            'name' => $request->name,

            'image' => $image,

            'slug' => $slug,

            'status' => $request->status ? 1 : 0

        ]);

        activityLog(
            'Category',
            'Update',
            $category->name
        );

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category Updated Successfully'
            );
    }



    public function trash()
    {

        $this->authorize('viewAny', Category::class);

        $categories = Category::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view('admin.category.trash', compact('categories'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $category);

        $category->restore();

        activityLog(
            'Category',
            'Restore',
            $category->name
        );

        return redirect()
            ->route('admin.categories.trash')
            ->with('success', 'Category restored successfully.');
    }

    public function destroy(Category $category)
    {

        $this->authorize('delete', $category);

        activityLog(
            'Category',
            'Delete',
            $category->name
        );

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category moved to trash.'
            );
    }

    public function forceDelete($id)
    {

        $category = Category::onlyTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $category);

        if (
            $category->image &&
            Storage::disk('public')->exists($category->image)
        ) {
            Storage::disk('public')->delete($category->image);
        }

        $category->forceDelete();

        activityLog(
            'Category',
            'Permanent Delete',
            $category->name
        );

        return redirect()
            ->route('admin.categories.trash')
            ->with(
                'success',
                'Category permanently deleted.'
            );
    }
}
