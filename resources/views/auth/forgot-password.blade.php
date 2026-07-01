<!DOCTYPE html>
<html lang="en">

@php
    $siteSetting = \App\Models\Setting::first();
@endphp

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $siteSetting->site_name }} | Login</title>

    @if (!empty($siteSetting->favicon))
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $siteSetting->favicon) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 100%;
            max-width: 450px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .08);
        }

        .brand {
            font-size: 32px;
            font-weight: 700;
        }

        .brand span {
            color: #5f6fff;
        }
    </style>

</head>

<body>

    <div class="card login-card">

        <div class="card-body p-5">

            <div class="text-center mb-4">

                <h2 class="brand">
                    stories<span>.</span>
                </h2>

                <p class="text-muted">
                    Forgot Password
                </p>

            </div>

            <p class="text-muted small mb-4">
                Enter your email address and we'll send you a password reset link.
            </p>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">

                @csrf

                <div class="mb-4">

                    <label class="form-label">
                        Email Address
                    </label>

                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>

                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>

                <button type="submit" class="btn btn-primary w-100">

                    Send Reset Link

                </button>

                <div class="text-center mt-3">

                    <a href="{{ route('login') }}">
                        Back to Login
                    </a>

                </div>

            </form>

        </div>

    </div>

</body>

</html>
