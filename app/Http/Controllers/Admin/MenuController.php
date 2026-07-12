<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with(['parent', 'category'])
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('admin.menus.index', [
            'adminMenus' => $menus,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();

        $pages = Page::where('status', 1)
            ->orderBy('title')
            ->pluck('title', 'slug');

        $parents = Menu::orderBy('name')->get();

        return view('admin.menus.create', compact(
            'categories',
            'pages',
            'parents'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',

            'type' => 'required|in:custom,page,category',

            'menu_location' => 'required|in:header,footer_1,footer_2,footer_3,footer_4',

            'parent_id' => 'nullable|exists:menus,id',

            'category_id' => 'required_if:type,category|nullable|exists:categories,id',

            'page_slug' => 'required_if:type,page|nullable',

            'url' => 'required_if:type,custom|nullable|string',

            'target' => 'required|in:_self,_blank',

            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [

            'name' => $request->name,

            'type' => $request->type,

            'menu_location' => $request->menu_location,

            'parent_id' => $request->parent_id,

            'target' => $request->target,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->boolean('status'),

            'url' => null,

            'page_slug' => null,

            'category_id' => null,

        ];

        switch ($request->type) {

            case 'custom':

                $data['url'] = $request->url;

                break;

            case 'page':

                $data['page_slug'] = $request->page_slug;

                break;

            case 'category':

                $data['category_id'] = $request->category_id;

                break;
        }

        Menu::create($data);

        return redirect()
            ->route('admin.menus.index')
            ->with(
                'success',
                'Menu Created Successfully'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $categories = Category::where('status', 1)->get();

        $pages = Page::where('status', 1)
            ->orderBy('title')
            ->pluck('title', 'slug');

        $parents = Menu::where('id', '!=', $menu->id)
            ->orderBy('name')
            ->get();

        return view('admin.menus.edit', compact(
            'menu',
            'categories',
            'pages',
            'parents'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|max:255',

            'type' => 'required|in:custom,page,category',

            'menu_location' => 'required|in:header,footer_1,footer_2,footer_3,footer_4',

            'parent_id' => 'nullable|exists:menus,id',

            'category_id' => 'required_if:type,category|nullable|exists:categories,id',

            'page_slug' => 'required_if:type,page|nullable',

            'url' => 'required_if:type,custom|nullable|string',

            'target' => 'required|in:_self,_blank',

            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data = [

            'name' => $request->name,

            'type' => $request->type,

            'menu_location' => $request->menu_location,

            'parent_id' => $request->parent_id,

            'target' => $request->target,

            'sort_order' => $request->sort_order ?? 0,

            'status' => $request->boolean('status'),

            'url' => null,

            'page_slug' => null,

            'category_id' => null,

        ];

        switch ($request->type) {

            case 'custom':

                $data['url'] = $request->url;

                break;

            case 'page':

                $data['page_slug'] = $request->page_slug;

                break;

            case 'category':

                $data['category_id'] = $request->category_id;

                break;
        }

        $menu->update($data);

        return redirect()
            ->route('admin.menus.index')
            ->with(
                'success',
                'Menu Updated Successfully'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function trash()
    // {
    //     $menus = Menu::onlyTrashed()
    //         ->latest('deleted_at')
    //         ->paginate(10);

    //     return view('admin.menus.trash', compact('menus'));
    // }

    public function trash()
    {
        $trashMenus = Menu::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        // dd(get_class($menus));

        return view('admin.menus.trash', compact('trashMenus'));
    }

    public function restore($id)
    {
        Menu::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Menu restored.');
    }

    public function forceDelete($id)
    {
        Menu::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Menu permanently deleted.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return back()->with('success', 'Menu moved to trash.');
    }
}
