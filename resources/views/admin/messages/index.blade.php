@extends('admin.layouts.master')

@section('title', 'Messages')

@section('content')

    <div class="d-flex justify-content-between mb-4">
        <h3 class="mb-4">
            Contact Messages
        </h3>

        <a href="{{ route('admin.messages.trash') }}" class="btn btn-warning">

            Trash
        </a>
    </div>



    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Name</th>

                <th>Email</th>

                <th>Subject</th>

                <th>Message</th>

                <th>Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($messages as $message)
                <tr>

                    <td>{{ $message->name }}</td>

                    <td>{{ $message->email }}</td>

                    <td>{{ $message->subject }}</td>

                    <td>{{ $message->message }}</td>

                    <td>


                        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm">

                                Delete

                            </button>

                        </form>

                    </td>

                </tr>
            @endforeach

        </tbody>

    </table>

@endsection
