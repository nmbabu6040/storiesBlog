<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Maintenance Mode</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container vh-100 d-flex justify-content-center align-items-center">

        <div class="text-center">

            <h1 class="display-1 fw-bold text-warning">
                503
            </h1>

            <h2 class="mb-3">
                Website Under Maintenance
            </h2>

            <p class="text-muted mb-4">

                We are currently improving our website.

                <br>

                Please come back again shortly.

            </p>

            @php
                $setting = \App\Models\Setting::first();
            @endphp

            @if ($setting?->logo)
                <img src="{{ asset('storage/' . $setting->logo) }}" width="140" class="mt-3">
            @endif

        </div>

    </div>

</body>

</html>
