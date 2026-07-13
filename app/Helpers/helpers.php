<?php

use App\Models\Notification;

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
