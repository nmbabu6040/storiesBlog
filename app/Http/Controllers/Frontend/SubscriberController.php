<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'unique:subscribers,email']
        ]);

        Subscriber::create([
            'name' => $request->name,
            'email' => $request->email
        ]);

        activityLog(
            'Subscriber',
            'Subscribe',
            $request->email . ' subscribed.'
        );

        createNotification(
            'New Subscriber',
            $request->email,
            route('admin.subscribers.index'),
            'subscriber'
        );



        return back()->with(
            'subscribe_success',
            'Thanks for subscribing.'
        );
    }
}
