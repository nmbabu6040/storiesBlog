<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
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
        $activityLog->delete();

        return back()->with(
            'success',
            'Activity deleted successfully.'
        );
    }

    public function clear()
    {
        ActivityLog::truncate();

        return back()->with(
            'success',
            'All activity logs cleared.'
        );
    }
}
