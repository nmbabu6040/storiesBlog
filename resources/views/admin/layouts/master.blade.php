<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', $siteSetting->site_name ?? 'Stories Blog')
    </title>

    <meta name="description" content="@yield('meta_description', 'Latest news, guides and blog articles')">

    @if (!empty($siteSetting->favicon))
        <link rel="icon" href="{{ asset('storage/' . $siteSetting->favicon) }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <div class="container-fluid">

        <div class="row">

            @include('admin.partials.sidebar')

            <main class="col-md-10 ms-sm-auto px-md-4 py-4">

                @include('admin.partials.navbar')

                @yield('content')

            </main>

        </div>

    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

    @stack('scripts')
</body>

</html>
