<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>500 - Server Error</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container vh-100 d-flex justify-content-center align-items-center">

        <div class="text-center">

            <h1 class="display-1 fw-bold text-warning">

                500

            </h1>

            <h2>

                Internal Server Error

            </h2>

            <p class="text-muted">

                Something went wrong on our server.

                Please try again later.

            </p>

            <a href="{{ url('/') }}" class="btn btn-primary">

                Back Home

            </a>

        </div>

    </div>

</body>

</html>
