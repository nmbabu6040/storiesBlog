<header>

    <div class="top-header">

        <div class="container">

            <div class="d-flex justify-content-between align-items-center py-4">

                <a href="{{ route('frontend.home') }}" class="logo">

                    @if (!empty($siteSetting->header_logo))
                        <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Logo" height="50">
                    @else
                        {{ $siteSetting->site_name ?? 'Stories Blog' }}
                    @endif

                </a>

                <div class="top-menu d-flex align-items-center">

                    <a href="#">Layouts</a>

                    <a href="#">UI Document</a>

                    <a href="#">Search</a>

                    <a href="#" class="buy-btn">

                        Buy Now

                    </a>

                </div>

            </div>

        </div>

    </div>

    <nav class="navbar navbar-expand-lg bg-white border-top border-bottom">

        <div class="container">

            <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainMenu">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="mainMenu">

                <ul class="navbar-nav me-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Travel
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Mega Menu
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Guides
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Food
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Hotels
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            Reviews
                        </a>
                    </li>

                </ul>

                <form action="{{ route('frontend.search') }}" method="GET" class="d-flex">

                    <input type="text" name="keyword" class="form-control me-2" placeholder="Search">

                    <button class="btn btn-primary">

                        Search

                    </button>

                </form>

            </div>

        </div>

    </nav>

</header>
