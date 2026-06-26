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
        $categories = Category::latest()->get();

        return view(
            'admin.category.index',
            compact('categories')
        );
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = null;

        if ($request->hasFile('image')) {

            $image = $request
                ->file('image')
                ->store('categories', 'public');
        }

        Category::create([

            'name' => $request->name,

            'image' => $image,

            'slug' => Str::slug($request->name),

            'status' => $request->status ? 1 : 0

        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category Created Successfully'
            );
    }

    public function edit(Category $category)
    {
        return view(
            'admin.category.edit',
            compact('category')
        );
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $category->id

        ]);

        $image = $category->image;

        if ($request->hasFile('image')) {

            if ($category->image) {

                Storage::disk('public')
                    ->delete($category->image);
            }

            $image = $request
                ->file('image')
                ->store('categories', 'public');
        }

        $category->update([

            'name' => $request->name,

            'image' => $image,

            'slug' => Str::slug($request->name),

            'status' => $request->status ? 1 : 0

        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category Updated Successfully'
            );
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'Category Deleted Successfully'
            );
    }
}
