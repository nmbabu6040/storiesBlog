<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::query()
            ->latest()
            ->paginate(10);

        return view('admin.messages.index', compact('messages'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message moved to trash.');
    }

    public function trash()
    {
        $trashMessages = ContactMessage::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'admin.messages.trash',
            compact('trashMessages')
        );
    }

    public function restore($id)
    {
        ContactMessage::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('admin.messages.trash')
            ->with('success', 'Message restored.');
    }

    public function forceDelete($id)
    {
        ContactMessage::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return redirect()
            ->route('admin.messages.trash')
            ->with('success', 'Message permanently deleted.');
    }
}
