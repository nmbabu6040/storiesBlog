@extends('admin.layouts.master')

@section('title', 'Messages')

@section('content')

    <h3 class="mb-4">
        Contact Messages
    </h3>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>Name</th>

                <th>Email</th>

                <th>Subject</th>

                <th>Message</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($messages as $message)
                <tr>

                    <td>{{ $message->name }}</td>

                    <td>{{ $message->email }}</td>

                    <td>{{ $message->subject }}</td>

                    <td>{{ $message->message }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

@endsection
