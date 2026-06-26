<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')
            ->latest()
            ->get();

        return view(
            'admin.post.index',
            compact('posts')
        );
    }

    public function create()
    {
        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.post.create',
            compact('categories')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content' => 'required',
        ]);

        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request
                ->file('thumbnail')
                ->store('posts', 'public');
        }

        $slug = Str::slug($request->title);

        $count = \App\Models\Post::where('slug', 'LIKE', "{$slug}%")->count();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        Post::create([

            'category_id' => $request->category_id,

            'title' => $request->title,

            // 'slug' => Str::slug($request->title),

            'slug' => $slug,

            'thumbnail' => $thumbnail,

            'content' => $request->content,

            'meta_title' => $request->meta_title,

            'meta_description' => $request->meta_description,

            'featured' => $request->featured ? 1 : 0,

            'status' => $request->status ? 1 : 0,

            'views' => 0

        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with(
                'success',
                'Post Created Successfully'
            );
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Post $post)
    {
        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        return view(
            'admin.post.edit',
            compact(
                'post',
                'categories'
            )
        );
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $thumbnail = $post->thumbnail;

        if ($request->hasFile('thumbnail')) {

            if ($post->thumbnail) {

                Storage::disk('public')
                    ->delete($post->thumbnail);
            }

            $thumbnail = $request
                ->file('thumbnail')
                ->store('posts', 'public');
        }

        $slug = Str::slug($request->title);

        $count = Post::where('slug', 'LIKE', "{$slug}%")
            ->where('id', '!=', $post->id)
            ->count();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $post->update([

            'category_id' => $request->category_id,

            'title' => $request->title,

            // 'slug' => Str::slug($request->title),

            'slug' => $slug,

            'thumbnail' => $thumbnail,

            'content' => $request->content,

            'meta_title' => $request->meta_title,

            'meta_description' => $request->meta_description,

            'featured' => $request->featured ? 1 : 0,

            'status' => $request->status ? 1 : 0

        ]);

        return redirect()
            ->route('admin.posts.index')
            ->with(
                'success',
                'Post Updated Successfully'
            );
    }

    public function destroy(Post $post)
    {
        if ($post->thumbnail) {

            Storage::disk('public')
                ->delete($post->thumbnail);
        }

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with(
                'success',
                'Post Deleted Successfully'
            );
    }
}
