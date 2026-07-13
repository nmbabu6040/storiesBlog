<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Mail\NewsletterMail;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Http\Request;


class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::latest()->paginate(20);

        return view(
            'admin.subscribers.index',
            compact('subscribers')
        );
    }

    public function create()
    {

        return view('admin.subscribers.newsletter');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        $subscribers = Subscriber::all();

        foreach ($subscribers as $subscriber) {

            Mail::to($subscriber->email)
                ->send(
                    new NewsletterMail(
                        $request->subject,
                        $request->body
                    )
                );
        }

        activityLog(
            'Subscriber',
            'Send',
            $request->subject
        );

        return redirect()
            ->route('admin.subscribers.index')
            ->with('success', 'Newsletter sent successfully.');
    }


    public function trash()
    {
        $trashSubscribers = Subscriber::onlyTrashed()
            ->latest('deleted_at')
            ->paginate(10);

        return view(
            'admin.subscribers.trash',
            compact('trashSubscribers')
        );
    }

    public function restore($id)
    {
        Subscriber::onlyTrashed()
            ->findOrFail($id)
            ->restore();

        return back()->with(
            'success',
            'Subscriber restored successfully.'
        );
    }

    public function forceDelete($id)
    {
        Subscriber::onlyTrashed()
            ->findOrFail($id)
            ->forceDelete();

        return back()->with(
            'success',
            'Subscriber permanently deleted.'
        );
    }

    public function destroy(Subscriber $subscriber)
    {
        activityLog(
            'Subscriber',
            'Delete',
            $subscriber->email
        );

        $subscriber->delete();
        return back()->with(
            'success',
            'Subscriber moved to trash.'
        );
    }


    public function bulkDelete(Request $request)
    {
        Subscriber::whereIn(
            'id',
            $request->ids ?? []
        )->delete();

        return back()->with(
            'success',
            'Selected subscribers deleted successfully.'
        );
    }

    public function export()
    {
        $fileName = 'subscribers.csv';

        $subscribers = Subscriber::latest()->get();

        $headers = [

            'Content-Type' => 'text/csv',

            'Content-Disposition' => "attachment; filename=$fileName",

        ];

        $callback = function () use ($subscribers) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [

                'Name',

                'Email',

                'Subscribed At'

            ]);

            foreach ($subscribers as $subscriber) {

                fputcsv($file, [

                    $subscriber->name,

                    $subscriber->email,

                    $subscriber->created_at

                ]);
            }

            fclose($file);
        };

        return response()->stream(
            $callback,
            200,
            $headers
        );
    }
}
