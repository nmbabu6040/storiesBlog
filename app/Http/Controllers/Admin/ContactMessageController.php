<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()
            ->get();

        return view(
            'admin.messages.index',
            compact('messages')
        );
    }

    public function trash()
    {
        $messages = ContactMessage::onlyTrashed()->latest('deleted_at')->paginate(10);

        return view('admin.message.trash', compact('messages'));
    }

    public function restore($id)
    {
        ContactMessage::onlyTrashed()->findOrFail($id)->restore();

        return back()->with('success', 'Message restored.');
    }

    public function forceDelete($id)
    {
        ContactMessage::onlyTrashed()->findOrFail($id)->forceDelete();

        return back()->with('success', 'Message permanently deleted.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();

        return back()->with('success', 'Message moved to trash.');
    }
}
