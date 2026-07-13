@extends('admin.layouts.master')

@section('title', 'Notifications')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3>Notifications</h3>

        <div>

            <form action="{{ route('admin.notifications.readAll') }}" method="POST" class="d-inline">

                @csrf

                <button class="btn btn-success">

                    Read All

                </button>

            </form>

            <form action="{{ route('admin.notifications.clear') }}" method="POST" class="d-inline"
                onsubmit="return confirm('Clear all notifications?')">

                @csrf
                @method('DELETE')

                <button class="btn btn-danger">

                    Clear All

                </button>

            </form>

        </div>

    </div>

    <div class="card">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead>

                    <tr>

                        <th>Title</th>

                        <th>Message</th>

                        <th>Type</th>

                        <th>Status</th>

                        <th>Date</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($notifications as $notification)
                        <tr class="{{ !$notification->is_read ? 'table-warning' : '' }}">

                            <td>

                                {{ $notification->title }}

                            </td>

                            <td>

                                {{ $notification->message }}

                            </td>

                            <td>

                                <span class="badge bg-info">

                                    {{ ucfirst($notification->type) }}

                                </span>

                            </td>

                            <td>

                                @if ($notification->is_read)
                                    <span class="badge bg-success">

                                        Read

                                    </span>
                                @else
                                    <span class="badge bg-warning">

                                        Unread

                                    </span>
                                @endif

                            </td>

                            <td>

                                {{ $notification->created_at->diffForHumans() }}

                            </td>

                            <td>

                                @if (!$notification->is_read)
                                    <form action="{{ route('admin.notifications.read', $notification) }}" method="POST"
                                        class="d-inline">

                                        @csrf

                                        <button class="btn btn-success btn-sm">

                                            Read

                                        </button>

                                    </form>
                                @endif

                                <form action="{{ route('admin.notifications.destroy', $notification) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete notification?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No Notifications Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">

        {{ $notifications->links() }}

    </div>

@endsection
