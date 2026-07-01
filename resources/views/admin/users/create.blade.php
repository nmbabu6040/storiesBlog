@extends('admin.layouts.master')

@section('title', 'Create User')

@section('content')

    <h3 class="mb-4">
        Create User
    </h3>

    <form action="{{ route('admin.users.store') }}" method="POST">

        @csrf

        <div class="card">

            <div class="card-body">

                <div class="mb-3">
                    <label>Name</label>

                    <input type="text" name="name" class="form-control" value="{{ old('name') }}">

                </div>

                <div class="mb-3">
                    <label>Email</label>

                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">

                </div>

                <div class="mb-3">
                    <label>Password</label>

                    <input type="password" name="password" class="form-control">

                </div>

                <div class="mb-3">
                    <label>Confirm Password</label>

                    <input type="password" name="password_confirmation" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Role</label>

                    <select name="role" class="form-select">

                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">

                                {{ $role->name }}

                            </option>
                        @endforeach

                    </select>

                </div>

                <button class="btn btn-primary">

                    Save User

                </button>

            </div>

        </div>

    </form>

@endsection
