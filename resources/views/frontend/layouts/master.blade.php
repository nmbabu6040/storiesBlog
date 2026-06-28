<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', $siteSetting->site_name)</title>

    <meta name="description" content="@yield('meta_description', $siteSetting->site_description)">

    <meta name="keywords" content="@yield('meta_keywords', $siteSetting->meta_keywords)">

    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="@yield('title', $siteSetting->site_name)">

    <meta property="og:description" content="@yield('meta_description', $siteSetting->site_description ?? '')">

    <meta property="og:url" content="{{ url()->current() }}">

    <meta property="og:type" content="website">

    <meta property="og:image"
        content="{{ !empty($siteSetting->header_logo) ? asset('storage/' . $siteSetting->header_logo) : asset('images/default-og.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">

    <meta name="twitter:title" content="@yield('title', $siteSetting->site_name)">

    <meta name="twitter:description" content="@yield('meta_description', $siteSetting->site_description ?? '')">

    <meta name="twitter:image"
        content="{{ !empty($siteSetting->header_logo) ? asset('storage/' . $siteSetting->header_logo) : asset('images/default-og.jpg') }}">



    @if (!empty($siteSetting->favicon))
        <link rel="icon" href="{{ asset('storage/' . $siteSetting->favicon) }}">
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&family=Noto+Sans+JP:wght@100..900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    @stack('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    @include('frontend.partials.header')

    <main>

        @yield('content')

    </main>

    @include('frontend.partials.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    @stack('scripts')

</body>

</html>
