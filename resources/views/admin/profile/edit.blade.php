@extends('admin.layouts.master')

@section('title', 'My Profile')

@section('content')

    <div class="row">

        <div class="col-lg-8">

            <div class="card mb-4">

                <div class="card-header">

                    <h4>Edit Profile</h4>

                </div>

                <div class="card-body">

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label>Name</label>

                            <input type="text" name="name" class="form-control"
                                value="{{ old('name', auth()->user()->name) }}">

                        </div>

                        <div class="mb-3">

                            <label>Email</label>

                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', auth()->user()->email) }}">

                        </div>

                        <div class="mb-3">

                            <label>Profile Image</label>

                            <input type="file" name="image" class="form-control">

                        </div>

                        @if (auth()->user()->image)
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" width="120" class="rounded mb-3">
                        @endif

                        <div class="mb-3">

                            <label>About Me</label>

                            <textarea name="bio" rows="5" class="form-control">{{ old('bio', auth()->user()->bio) }}</textarea>

                        </div>

                        <button class="btn btn-primary">

                            Update Profile

                        </button>

                    </form>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">

                    <h4>Change Password</h4>

                </div>

                <div class="card-body">

                    <form action="{{ route('admin.profile.password') }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label>Current Password</label>

                            <input type="password" name="current_password" class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>New Password</label>

                            <input type="password" name="password" class="form-control">

                        </div>

                        <div class="mb-3">

                            <label>Confirm Password</label>

                            <input type="password" name="password_confirmation" class="form-control">

                        </div>

                        <button class="btn btn-success w-100">

                            Change Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
