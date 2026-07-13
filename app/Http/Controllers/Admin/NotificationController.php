<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(20);

        return view(
            'admin.notification.index',
            compact('notifications')
        );
    }

    public function read(Notification $notification)
    {
        $notification->update([
            'is_read' => true
        ]);

        return redirect($notification->url);
    }

    public function readAll()
    {
        Notification::where(
            'is_read',
            false
        )->update([

            'is_read' => true

        ]);

        return back();
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return back()->with(
            'success',
            'Notification deleted successfully.'
        );
    }

    public function clear()
    {
        Notification::truncate();

        return back()->with(
            'success',
            'All notifications cleared.'
        );
    }
}
