@extends('admin.layouts.master')

@section('title', 'Create User')

@section('content')

    <h3 class="mb-4">
        Create User
    </h3>

    <form action="{{ route('admin.users.update', $user) }}') }}" method="POST">

        @csrf
        @method('PUT')

        <div class="card">

            <div class="card-body">

                <div class="mb-3">
                    <label>Name</label>

                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">

                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">

                </div>

                <div class="mb-3">
                    <label>Password</label>

                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">

                    <small class="text-muted">

                        Leave blank if you don't want to change the password.

                    </small>

                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>

                    <input type="password" name="password_confirmation" class="form-control">

                </div>

                <div class="mb-3">
                    <label class="form-label">Role</label>

                    <select name="role" class="form-select">

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>

                                {{ $role->name }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="d-flex gap-3">
                    <button class="btn btn-primary">

                        Save User

                    </button>

                    <a href="{{ route('admin.users.index') }}" class="btn btn-danger">
                        Cancel
                    </a>
                </div>

            </div>

        </div>

    </form>

@endsection
