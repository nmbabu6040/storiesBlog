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
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 100%;
            max-width: 500px;
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
                    Verify Your Email
                </p>

            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success">

                    A new verification link has been sent to your email address.

                </div>
            @endif

            <p class="text-muted">

                Thanks for signing up! Before getting started, please verify your email address by clicking on the link
                we emailed to you.

            </p>

            <form method="POST" action="{{ route('verification.send') }}">

                @csrf

                <button class="btn btn-primary w-100 mb-3">

                    Resend Verification Email

                </button>

            </form>

            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button class="btn btn-outline-secondary w-100">

                    Logout

                </button>

            </form>

        </div>

    </div>

</body>

</html>
