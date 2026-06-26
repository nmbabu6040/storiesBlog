<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

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
                    stor<span>ies.</span>
                </h2>

                <p class="text-muted">
                    Admin Login
                </p>

            </div>

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Email
                    </label>

                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>

                    @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Password
                    </label>

                    <input type="password" name="password" class="form-control" required>

                    @error('password')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="form-check mb-4">

                    <input class="form-check-input" type="checkbox" name="remember" id="remember">

                    <label class="form-check-label" for="remember">

                        Remember Me

                    </label>

                </div>

                <button type="submit" class="btn btn-primary w-100">

                    Login

                </button>

            </form>

        </div>

    </div>

</body>

</html>
