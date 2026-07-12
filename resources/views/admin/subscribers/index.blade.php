@extends('admin.layouts.master')

@section('title', 'Subscribers')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="mb-0">
            Subscribers
        </h3>

        <div class="d-flex gap-2">

            <a href="{{ route('admin.subscribers.export') }}" class="btn btn-success">
                Export CSV
            </a>

            <a href="{{ route('admin.subscribers.trash') }}" class="btn btn-warning">
                Trash
            </a>

        </div>

    </div>

    <form action="{{ route('admin.subscribers.bulkDelete') }}" method="POST"
        onsubmit="return confirm('Delete selected subscribers?')">

        @csrf

        <div class="mb-3">

            <button type="submit" class="btn btn-danger">

                Delete Selected

            </button>

        </div>

        <table class="table table-bordered table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th width="50">

                        <input type="checkbox" id="checkAll">

                    </th>

                    <th width="80">#</th>

                    <th>Name</th>

                    <th>Email</th>

                    <th width="180">Subscribed At</th>

                    <th width="170">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse ($subscribers as $subscriber)
                    <tr>

                        <td>

                            <input type="checkbox" name="ids[]" value="{{ $subscriber->id }}">

                        </td>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $subscriber->name ?? 'N/A' }}

                        </td>

                        <td>

                            {{ $subscriber->email }}

                        </td>

                        <td>

                            {{ $subscriber->created_at->format('d M, Y h:i A') }}

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST"
                                    onsubmit="return confirm('Delete this subscriber?')">

                                    @csrf

                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">

                                        Delete

                                    </button>

                                </form>

                                <a href="{{ route('admin.newsletter.create') }}" class="btn btn-sm btn-primary">

                                    Newsletter

                                </a>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No subscribers found.

                        </td>

                    </tr>
                @endforelse

            </tbody>

        </table>

        <div class="mt-3">

            {{ $subscribers->links() }}

        </div>

    </form>

@endsection

@push('scripts')
    <script>
        document.getElementById('checkAll').addEventListener('change', function() {

            document.querySelectorAll('input[name="ids[]"]').forEach(function(checkbox) {

                checkbox.checked = document.getElementById('checkAll').checked;

            });

        });
    </script>
@endpush
