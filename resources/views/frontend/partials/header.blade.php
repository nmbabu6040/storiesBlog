@if ($headerAd)

    <div class="container py-3 text-center">

        @if ($headerAd->type == 'image')
            <a href="{{ $headerAd->url }}" target="_blank">

                <img src="{{ asset('storage/' . $headerAd->image) }}" class="img-fluid">

            </a>
        @else
            {!! $headerAd->code !!}
        @endif

    </div>

@endif
<header>
    <nav class="navbar navbar-expand-lg bg-white py-3">

        <div class="container">

            <a href="{{ route('frontend.home') }}" class="logo">

                @if (!empty($siteSetting->header_logo))
                    <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" height="50">
                @else
                    {{ $siteSetting->site_name ?? 'Stories Blog' }}
                @endif

            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="mainMenu">

                <ul class="navbar-nav m-auto">

                    @foreach ($menus as $menu)
                        @php
                            $path = trim(parse_url($menu->link, PHP_URL_PATH), '/');

                            $isActive = $path === '' ? request()->routeIs('frontend.home') : request()->is($path);

                            $hasActiveChild = $menu->children->contains(function ($child) {
                                $childPath = trim(parse_url($child->link, PHP_URL_PATH), '/');

                                return $childPath === ''
                                    ? request()->routeIs('frontend.home')
                                    : request()->is($childPath);
                            });
                        @endphp

                        @if ($menu->children->count())
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle {{ $hasActiveChild ? 'active' : '' }}" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    {{ $menu->name }}

                                </a>

                                <ul class="dropdown-menu">

                                    @foreach ($menu->children as $child)
                                        @php
                                            $childActive =
                                                request()->fullUrlIs($child->link) ||
                                                request()->is(ltrim(parse_url($child->link, PHP_URL_PATH), '/'));
                                        @endphp

                                        <li>

                                            <a class="dropdown-item {{ $childActive ? 'active' : '' }}"
                                                href="{{ $child->link }}" target="{{ $child->target }}">

                                                {{ $child->name }}

                                            </a>

                                        </li>
                                    @endforeach

                                </ul>

                            </li>
                        @else
                            <li class="nav-item">

                                <a class="nav-link {{ $isActive ? 'active' : '' }}" href="{{ $menu->link }}"
                                    target="{{ $menu->target }}">

                                    {{ $menu->name }}

                                </a>

                            </li>
                        @endif
                    @endforeach

                </ul>

                <form action="{{ route('frontend.search') }}" method="GET" class="d-flex">

                    <input type="text" name="keyword" class="form-control me-2" placeholder="Search...">

                    <button class="btn btn-primary" type="submit">

                        Search

                    </button>

                </form>

                <button id="themeToggleFrontend" type="button" class="btn btn-outline-secondary btn-sm ms-2">

                    🌙

                </button>

            </div>

        </div>

    </nav>

</header>
