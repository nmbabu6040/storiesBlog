<div class="bg-dark text-white p-0 position-fixed top-0 start-0 vh-100 d-flex flex-column"
    style="width:16.666667%; overflow-y:auto;">

    <div class="p-3 mb-5">

        {{-- <h4>
            Stories Blog
        </h4> --}}

        <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Stories Blog" class="img-fluid">

    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-primary' : '' }}">

                <i class="fa-solid fa-gauge"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">

            <a href="{{ route('admin.menus.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.menus.*') ? 'bg-primary' : '' }}">

                <i class="fa-solid fa-bars"></i>

                <span>Menus</span>

            </a>

        </li>

        @role('Super Admin|Admin')
            <li class="nav-item">

                <a href="{{ route('admin.pages.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.pages.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-file-lines"></i>

                    <span>Pages</span>

                </a>

            </li>
        @endrole

        @role('Super Admin|Admin|Editor')
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-list"></i>
                    Categories
                </a>
            </li>
        @endrole

        @role('Super Admin|Admin|Editor|Author')
            <li class="nav-item">
                <a href="{{ route('admin.posts.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.posts.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-newspaper"></i>
                    Posts
                </a>
            </li>
        @endrole



        <li class="nav-item">

            <a href="{{ route('admin.messages.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.messages.*') ? 'bg-primary' : '' }}">

                <i class="fa-solid fa-message"></i>
                Messages

            </a>

        </li>

        <li class="nav-item">

            <a href="{{ route('admin.subscribers.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.subscribers.*') ? 'bg-primary' : '' }}">

                <i class="fa-solid fa-user"></i>
                Subscribers

            </a>

        </li>

        @role('Super Admin')
            <li class="nav-item">
                <a href="{{ route('admin.settings.edit') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.settings.edit') ? 'bg-primary' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        @endrole

        @role('Super Admin|Admin|Editor')
            <li class="nav-item">

                <a href="{{ route('admin.galleries.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.galleries.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-image"></i>
                    Gallery

                </a>

            </li>
        @endrole

        <li class="nav-item">

            <a href="{{ route('admin.media.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.media.*') ? 'bg-primary' : '' }}">

                <i class="fa-solid fa-photo-film"></i>

                Media Library

            </a>

        </li>

        @role('Super Admin|Admin|Editor')
            <li class="nav-item">

                <a href="{{ route('admin.comments.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.comments.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-comment"></i>
                    Comments

                </a>
            </li>
        @endrole

        @role('Super Admin|Admin')
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        @endrole

        <li class="nav-item">
            <a href="{{ route('admin.advertisements.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.advertisements.*') ? 'bg-primary' : '' }}">
                <i class="fas fa-ad"></i>
                Advertisements
            </a>
        </li>

    </ul>
    <div class="mt-auto p-3">

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button class="btn btn-danger w-100">

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </button>

        </form>

    </div>
</div>
