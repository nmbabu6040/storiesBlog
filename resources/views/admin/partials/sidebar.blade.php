<div class="bg-dark text-white p-0 position-fixed top-0 start-0 vh-100 d-flex flex-column"
    style="width:16.666667%; overflow-y:auto;">

    <div class="p-3 mb-5">



        <img src="{{ asset('storage/' . $siteSetting->header_logo) }}" alt="Stories Blog" class="img-fluid">

    </div>

    <ul class="nav flex-column">

        @can('dashboard')
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>
            </li>
        @endcan

        @can('manage-menus')
            <li class="nav-item">
                <a href="{{ route('admin.menus.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.menus.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-bars"></i>

                    <span>Menus</span>

                </a>
            </li>
        @endcan


        @can('manage-pages')
            <li class="nav-item">
                <a href="{{ route('admin.pages.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.pages.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-file-lines"></i>

                    <span>Pages</span>

                </a>
            </li>
        @endcan


        @can('manage-categories')
            <li class="nav-item">
                <a href="{{ route('admin.categories.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-list"></i>
                    Categories
                </a>
            </li>
        @endcan

        @can('manage-posts')
            <li class="nav-item">
                <a href="{{ route('admin.posts.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.posts.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-newspaper"></i>
                    Posts
                </a>
            </li>
        @endcan


        @can('manage-tags')
            <li class="nav-item">

                <a href="{{ route('admin.tags.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.tags.*') ? 'active' : '' }}">

                    <i class="fas fa-tags me-2"></i>

                    <span>

                        Tags

                    </span>

                </a>

            </li>
        @endcan



        @can('manage-messages')
            <li class="nav-item">

                <a href="{{ route('admin.messages.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.messages.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-message"></i>
                    Messages

                </a>

            </li>
        @endcan

        @can('manage-subscribers')
            <li class="nav-item">

                <a href="{{ route('admin.subscribers.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.subscribers.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-user"></i>
                    Subscribers

                </a>

            </li>
        @endcan




        @can('manage-settings')
            <li class="nav-item">
                <a href="{{ route('admin.settings.edit') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.settings.edit') ? 'bg-primary' : '' }}">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        @endcan

        @can('manage-gallery')
            <li class="nav-item">

                <a href="{{ route('admin.galleries.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.galleries.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-image"></i>
                    Gallery

                </a>

            </li>
        @endcan


        @can('manage-media')
            <li class="nav-item">

                <a href="{{ route('admin.media.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.media.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-photo-film"></i>

                    Media Library

                </a>

            </li>
        @endcan



        @can('manage-comments')
            <li class="nav-item">

                <a href="{{ route('admin.comments.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.comments.*') ? 'bg-primary' : '' }}">

                    <i class="fa-solid fa-comment"></i>
                    Comments

                </a>
            </li>
        @endcan

        @can('manage-users')
            <li class="nav-item">
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.users.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
        @endcan



        @can('manage-profile')
            <li class="nav-item">

                <a href="{{ route('admin.profile.edit') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.profile.edit') ? 'bg-primary' : '' }}">

                    <i class="fas fa-user-circle"></i>

                    My Profile

                </a>

            </li>
        @endcan


        @can('manage-backup')
            <li class="nav-item">

                <a href="{{ route('admin.backup.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.backups.*') ? 'bg-primary' : '' }}">

                    <i class="fas fa-database"></i>

                    <span>

                        Backup

                    </span>

                </a>

            </li>
        @endcan


        @can('manage-activity')
            <li class="nav-item">

                <a href="{{ route('admin.activity.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.activity.index') ? 'bg-primary' : '' }}">

                    <i class="fas fa-history"></i>

                    Activity Log

                </a>

            </li>
        @endcan


        @can('manage-advertisements')
            <li class="nav-item">
                <a href="{{ route('admin.advertisements.index') }}"
                    class="nav-link text-white {{ request()->routeIs('admin.advertisements.*') ? 'bg-primary' : '' }}">
                    <i class="fas fa-ad"></i>
                    Advertisements
                </a>
            </li>
        @endcan

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
