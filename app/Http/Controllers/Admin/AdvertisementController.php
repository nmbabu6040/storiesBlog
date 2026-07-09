<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function index()
    {
        $advertisements = Advertisement::latest()->paginate(15);

        return view('admin.advertisement.index', compact('advertisements'));
    }

    public function create()
    {
        return view('admin.advertisement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'position' => 'required',
            'type' => 'required',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')
                ->store('advertisements', 'public');
        }

        Advertisement::create([
            'title'      => $request->title,
            'position'   => $request->position,
            'type'       => $request->type,
            'code'       => $request->code,
            'image'      => $image,
            'url'        => $request->url,
            'status'     => $request->status ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'Advertisement created successfully.');
    }

    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisement.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $request->validate([
            'title' => 'required|max:255',
            'position' => 'required',
            'type' => 'required',
        ]);

        $image = $advertisement->image;

        if ($request->hasFile('image')) {

            if ($advertisement->image) {
                Storage::disk('public')->delete($advertisement->image);
            }

            $image = $request->file('image')
                ->store('advertisements', 'public');
        }

        $advertisement->update([
            'title'      => $request->title,
            'position'   => $request->position,
            'type'       => $request->type,
            'code'       => $request->code,
            'image'      => $image,
            'url'        => $request->url,
            'status'     => $request->status ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'Advertisement updated successfully.');
    }

    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->image) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->delete();

        return back()->with('success', 'Advertisement deleted successfully.');
    }
}
