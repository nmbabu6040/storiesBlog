@extends('admin.layouts.master')

@section('title', 'Subscribers')

@section('content')

    <h3 class="mb-4">
        Subscribers
    </h3>

    <table class="table table-bordered">

        <thead>

            <tr>

                <th>ID</th>

                <th>Email</th>

                <th>Date</th>

            </tr>

        </thead>

        <tbody>

            @foreach ($subscribers as $subscriber)
                <tr>

                    <td>{{ $subscriber->id }}</td>

                    <td>{{ $subscriber->email }}</td>

                    <td>{{ $subscriber->created_at }}</td>

                </tr>
            @endforeach

        </tbody>

    </table>

@endsection
