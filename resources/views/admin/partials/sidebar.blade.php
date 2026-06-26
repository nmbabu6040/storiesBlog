<div class="col-md-2 bg-dark min-vh-100 p-0">

    <div class="p-3 text-white">

        <h4>
            Stories Blog
        </h4>

    </div>

    <ul class="nav flex-column">

        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"
                class="nav-link text-white {{ request()->routeIs('admin.dashboard') ? 'bg-primary' : '' }}">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.categories.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.categories.*') ? 'bg-primary' : '' }}">
                Categories
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('admin.posts.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.posts.*') ? 'bg-primary' : '' }}">
                Posts
            </a>
        </li>

        <li class="nav-item">

            <a href="{{ route('admin.messages.index') }}" class="nav-link text-white">

                Messages

            </a>

        </li>

        <li class="nav-item">

            <a href="{{ route('admin.subscribers.index') }}" class="nav-link text-white">

                Subscribers

            </a>

        </li>

        <li class="nav-item">

            <a href="{{ route('admin.settings.edit') }}" class="nav-link text-white">

                Settings

            </a>

        </li>

        <li class="nav-item">

            <a href="{{ route('admin.galleries.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.galleries.*') ? 'bg-primary' : '' }}">

                Gallery

            </a>

        </li>

        <li class="nav-item">

            <a href="{{ route('admin.comments.index') }}"
                class="nav-link text-white {{ request()->routeIs('admin.comments.*') ? 'bg-primary' : '' }}">

                Comments

            </a>

        </li>

    </ul>

</div>
