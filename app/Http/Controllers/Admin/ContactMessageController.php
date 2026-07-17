<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', ContactMessage::class);
        $messages = ContactMessage::query()
            ->latest()
            ->paginate(10);

        return view('admin.messages.index', compact('messages'));
    }

    public function destroy(ContactMessage $message)
    {
        $this->authorize('delete', $message);
        activityLog(

            'Message',

            'Delete',

            $message->email

        );

        $message->delete();

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Message moved to trash.');
    }

    public function trash()
    {
        $this->authorize('viewAny', ContactMessage::class);
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
        $message = ContactMessage::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('restore', $message);

        $message->restore();

        activityLog(
            'Message',
            'Restore',
            $message->email
        );

        return redirect()
            ->route('admin.messages.trash')
            ->with('success', 'Message restored.');
    }

    public function forceDelete($id)
    {
        $message = ContactMessage::onlyTrashed()
            ->findOrFail($id);

        $this->authorize('forceDelete', $message);

        activityLog(
            'Message',
            'Permanent Delete',
            $message->email
        );

        $message->forceDelete();

        return redirect()
            ->route('admin.messages.trash')
            ->with('success', 'Message permanently deleted.');
    }
}
