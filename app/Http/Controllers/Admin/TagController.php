<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tags.index');
    }

    public function trash()
    {
        $tags = Tag::onlyTrashed()->latest('deleted_at')->paginate(10);

        return view('admin.tag.trash', compact('tags'));
    }

    public function restore($id)
    {
        Tag::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Tag restored.');
    }

    public function forceDelete($id)
    {
        Tag::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Tag permanently deleted.');
    }
}
