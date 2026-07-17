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
        $this->authorize('viewAny', Advertisement::class);
        $advertisements = Advertisement::latest()->paginate(15);

        return view('admin.advertisement.index', compact('advertisements'));
    }

    public function create()
    {
        $this->authorize('create', Advertisement::class);
        return view('admin.advertisement.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Advertisement::class);
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

        $advertisement = Advertisement::create([
            'title'      => $request->title,
            'position'   => $request->position,
            'type'       => $request->type,
            'code'       => $request->code,
            'image'      => $image,
            'url'        => $request->url,
            'status'     => $request->status ? 1 : 0,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        activityLog(
            'Advertisement',
            'Create',
            $advertisement->title
        );

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'Advertisement created successfully.');
    }

    public function edit(Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);
        return view('admin.advertisement.edit', compact('advertisement'));
    }

    public function update(Request $request, Advertisement $advertisement)
    {
        $this->authorize('update', $advertisement);
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

        activityLog(
            'Advertisement',
            'Update',
            $advertisement->title
        );

        return redirect()
            ->route('admin.advertisements.index')
            ->with('success', 'Advertisement updated successfully.');
    }

    public function trash()
    {
        $this->authorize('viewAny', Advertisement::class);
        $advertisements = Advertisement::onlyTrashed()->latest('deleted_at')->paginate(10);

        return view('admin.advertisement.trash', compact('advertisements'));
    }

    public function restore($id)
    {
        $advertisement = Advertisement::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('restore', $advertisement);

        $advertisement->restore();

        activityLog(
            'Advertisement',
            'Restore',
            $advertisement->title
        );

        return back()->with('success', 'Advertisement restored.');
    }

    public function forceDelete($id)
    {
        $advertisement = Advertisement::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('forceDelete', $advertisement);

        activityLog(
            'Advertisement',
            'Permanent Delete',
            $advertisement->title
        );

        if (
            $advertisement->image &&
            Storage::disk('public')->exists($advertisement->image)
        ) {
            Storage::disk('public')->delete($advertisement->image);
        }

        $advertisement->forceDelete();

        return back()->with('success', 'Advertisement permanently deleted.');
    }

    public function destroy(Advertisement $advertisement)
    {
        $this->authorize('delete', $advertisement);
        activityLog(
            'Advertisement',
            'Delete',
            $advertisement->title
        );
        $advertisement->delete();

        return back()->with('success', 'Advertisement moved to trash.');
    }
}
