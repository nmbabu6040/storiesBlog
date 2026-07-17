<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Advertisement;
use App\Models\Post;
use App\Models\User;
use App\Models\Media;
use App\Models\Tag;
use App\Models\ContactMessage;

class PostController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Editor'])) {

            $posts = Post::with(['category', 'user'])
                ->latest()
                ->paginate(10);
        } else {

            $posts = Post::with(['category', 'user'])
                ->where('user_id', auth()->id())
                ->latest()
                ->paginate(10);
        }

        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        $tags = Tag::where('status', 1)
            ->orderBy('name')
            ->get();

        $media = Media::latest()->get();

        return view(
            'admin.post.create',
            compact('categories', 'tags', 'media')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'content' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'media_id' => 'nullable|exists:media,id',
        ]);

        //post image
        $thumbnail = null;

        if ($request->hasFile('thumbnail')) {

            $thumbnail = $request->file('thumbnail')
                ->store('posts', 'public');
        } elseif ($request->filled('media_id')) {

            $media = Media::find($request->media_id);

            $thumbnail = $media?->file_path;
        }

        //slug
        $slug = Str::slug($request->title);

        $count = \App\Models\Post::where('slug', 'LIKE', "{$slug}%")->count();

        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $post = Post::create([

            'user_id' => auth()->id(),

            'review_status' => auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin',
                'Editor'
            ]) ? 'approved' : 'pending',

            'approved_by' => auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin',
                'Editor'
            ]) ? auth()->id() : null,

            'category_id' => $request->category_id,

            'title' => $request->title,

            'slug' => $slug,

            'thumbnail' => $thumbnail,

            'media_id' => $request->media_id,

            'content' => $request->content,

            'meta_title' => $request->meta_title,

            'meta_description' => $request->meta_description,

            'featured' => auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin'
            ])
                ? ($request->featured ? 1 : 0)
                : 0,

            'status' => auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin',
                'Editor'
            ]) ? ($request->status ? 1 : 0) : 0,

            'views' => 0

        ]);

        //tags
        $post->tags()->sync($request->tags ?? []);

        //activity log
        activityLog(
            'Post',
            'Create',
            $post->title
        );

        //notification
        if ($post->review_status == 'pending') {

            createNotification(
                'New Pending Post',
                $post->title,
                route('admin.posts.index'),
                'post'
            );
        }



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
        $this->authorize('update', $post);

        $categories = Category::where('status', 1)
            ->orderBy('name')
            ->get();

        $tags = Tag::where('status', 1)
            ->orderBy('name')
            ->get();

        $media = Media::latest()->get();

        return view(
            'admin.post.edit',
            compact(
                'post',
                'categories',
                'tags',
                'media'
            )
        );
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|max:255',
            'content' => 'required',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'media_id' => 'nullable|exists:media,id',
        ]);



        // thumnail part
        $thumbnail = $post->thumbnail;

        if ($request->hasFile('thumbnail')) {

            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {

                Storage::disk('public')->delete($post->thumbnail);
            }

            $thumbnail = $request->file('thumbnail')
                ->store('posts', 'public');
        } elseif ($request->filled('media_id')) {

            $media = Media::find($request->media_id);

            $thumbnail = $media?->file_path;
        }

        // slug
        $slug = Str::slug($request->title);

        if ($post->title !== $request->title) {

            $originalSlug = $slug;
            $i = 1;

            while (
                Post::where('slug', $slug)
                ->where('id', '!=', $post->id)
                ->exists()
            ) {
                $slug = $originalSlug . '-' . $i;
                $i++;
            }
        } else {

            $slug = $post->slug;
        }

        $post->update([

            'category_id' => $request->category_id,

            'title' => $request->title,

            'slug' => $slug,

            'media_id' => $request->media_id,

            'thumbnail' => $thumbnail,

            'content' => $request->content,

            'meta_title' => $request->meta_title,

            'meta_description' => $request->meta_description,

            'featured' => auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin'
            ])
                ? ($request->featured ? 1 : 0)
                : 0,

            'status' => auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin',
                'Editor'
            ]) ? ($request->status ? 1 : 0) : 0,

        ]);

        //tags
        $post->tags()->sync($request->tags ?? []);

        //activity log
        activityLog(
            'Post',
            'Update',
            $post->title
        );

        return redirect()
            ->route('admin.posts.index')
            ->with(
                'success',
                'Post Updated Successfully'
            );
    }



    public function trash()
    {
        if (auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Editor'])) {

            $posts = Post::onlyTrashed()
                ->with('category')
                ->latest('deleted_at')
                ->paginate(10);
        } else {

            $posts = Post::onlyTrashed()
                ->where('user_id', auth()->id())
                ->with('category')
                ->latest('deleted_at')
                ->paginate(10);
        }

        return view('admin.post.trash', compact('posts'));
    }

    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);

        $this->authorize('restore', $post);

        $post->restore();

        //activity log
        activityLog(
            'Post',
            'Restore',
            $post->title
        );
        return redirect()
            ->route('admin.posts.trash')
            ->with('success', 'Post restored successfully.');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        activityLog(
            'Post',
            'Delete',
            $post->title
        );

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Post moved to trash successfully.');
    }

    public function forceDelete($id)
    {
        $this->authorize('forceDelete', $post);

        $post = Post::onlyTrashed()->findOrFail($id);

        if ($post->thumbnail) {

            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->forceDelete();

        //activity log
        activityLog(
            'Post',
            'Permanent Delete',
            $post->title
        );

        return redirect()
            ->route('admin.posts.trash')
            ->with('success', 'Post permanently deleted.');
    }



    public function approve(Post $post)
    {
        abort_unless(
            auth()->user()->hasAnyRole([
                'Super Admin',
                'Admin',
                'Editor'
            ]),
            403
        );


        $post->update([

            'review_status' => 'approved',

            'approved_by' => auth()->id(),

        ]);

        return back()->with(
            'success',
            'Post approved successfully.'
        );
    }
}
