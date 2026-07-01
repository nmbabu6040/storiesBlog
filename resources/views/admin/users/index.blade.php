@extends('admin.layouts.master')

@section('title', 'Users')

@section('content')

    <h3 class="mb-4">
        Users
    </h3>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
        Add User
    </a>

    <div class="card">
        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->email }}</td>

                            <td>

                                {{ $user->roles->pluck('name')->implode(', ') ?: 'No Role' }}

                            </td>

                            <td>

                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">

                                    Edit

                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No users found.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $users->links() }}

        </div>
    </div>

@endsection
