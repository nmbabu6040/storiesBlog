<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', ActivityLog::class);

        $logs = ActivityLog::with('user')

            ->when($request->module, function ($q) use ($request) {

                $q->where('module', $request->module);
            })

            ->when($request->action, function ($q) use ($request) {

                $q->where('action', $request->action);
            })

            ->latest()

            ->paginate(20);

        return view(
            'admin.activity.index',
            compact('logs')
        );
    }

    public function destroy(ActivityLog $activityLog)
    {
        $this->authorize('delete', $activityLog);

        $activityLog->delete();

        return back()->with(
            'success',
            'Activity deleted successfully.'
        );
    }

    public function clear()
    {
        $this->authorize('clear', ActivityLog::class);

        ActivityLog::truncate();

        activityLog(
            'Activity Log',
            'Clear',
            auth()->user()->name . ' cleared all activity logs.'
        );

        return back()->with(
            'success',
            'All activity logs cleared.'
        );
    }
}
