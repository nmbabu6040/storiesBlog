@extends('admin.layouts.master')

@section('title', 'Create User')

@section('content')

    <h3 class="mb-4">
        Edit User
    </h3>

    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data" autocomplete="off">

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
                    <label>Profile Image</label>

                    @if ($user->image)
                        <div class="mb-2">

                            <img src="{{ asset('storage/' . $user->image) }}" width="100" class="rounded">

                        </div>
                    @endif

                    <input type="file" name="image" class="form-control">

                    @error('image')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label>Password</label>

                    <input type="password" name="password" class="form-control" autocomplete="new-password">

                    <small class="text-muted">

                        Leave blank if you don't want to change the password.

                    </small>

                    @error('password')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>

                    <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
                    @error('password_confirmation')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
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
