<?php

use App\Models\Notification;
use App\Models\ActivityLog;

if (!function_exists('createNotification')) {

    function createNotification(
        $title,
        $message,
        $url = null,
        $type = 'info'
    ) {

        Notification::create([

            'title' => $title,

            'message' => $message,

            'url' => $url,

            'type' => $type,

            'is_read' => false,

        ]);
    }
}

if (!function_exists('activityLog')) {

    function activityLog($module, $action, $description = null)
    {

        ActivityLog::create([

            'user_id' => auth()->id(),

            'module' => $module,

            'action' => $action,

            'description' => $description,

            'ip' => request()->ip(),

            'browser' => request()->userAgent(),

        ]);
    }
}
