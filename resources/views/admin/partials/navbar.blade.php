<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>Admin Panel</h2>
    </div>

    <div class="d-flex align-items-center gap-3">

        {{-- Notification --}}
        <div class="dropdown">

            <a href="#" class="text-dark position-relative" data-bs-toggle="dropdown">

                <i class="fas fa-bell fs-4"></i>

                @if ($notificationCount)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger ">

                        {{ $notificationCount }}

                        {{-- @if ($notification->type == 'post')
                        @elseif($notification->type == 'comment')

                        @elseif($notification->type == 'subscriber')

                        @elseif($notification->type == 'message')
                        @else
                        @endif

                        {{ ucfirst($notification->type) }} --}}

                    </span>
                @endif

            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow" style="width:350px; max-height:400px; overflow:auto;">

                <li class="dropdown-header d-flex justify-content-between">

                    <strong>Notifications</strong>

                    <a href="{{ route('admin.notifications.index') }}">

                        View All

                    </a>

                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>

                @forelse($notifications as $notification)
                    <li>

                        <form action="{{ route('admin.notifications.read', $notification) }}" method="POST">

                            @csrf

                            <button class="dropdown-item text-start">

                                <strong>

                                    @if ($notification->type == 'post')
                                        <i class="fas fa-newspaper text-primary me-2"></i>
                                    @elseif($notification->type == 'comment')
                                        <i class="fas fa-comments text-success me-2"></i>
                                    @elseif($notification->type == 'subscriber')
                                        <i class="fas fa-user-plus text-warning me-2"></i>
                                    @elseif($notification->type == 'message')
                                        <i class="fas fa-envelope text-info me-2"></i>
                                    @endif

                                    {{ $notification->title }}

                                </strong>

                                <br>

                                <small class="d-block text-muted">

                                    {{ Str::limit($notification->message, 40) }}

                                </small>

                                <small class="text-secondary">

                                    {{ $notification->created_at->diffForHumans() }}

                                </small>
                            </button>

                        </form>

                    </li>

                @empty

                    <li>

                        <div class="text-center py-4">

                            <i class="fas fa-bell-slash fa-2x text-secondary mb-3"></i>

                            <p class="mb-0">

                                No Notifications Found

                            </p>

                        </div>
                    </li>
                @endforelse

            </ul>

        </div>

        {{-- Profile --}}

        <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : asset('images/user.png') }}"
            class="rounded-circle" width="40" height="40">

        <a href="{{ route('admin.profile.edit') }}" class="text-success text-decoration-none fw-bold">

            {{ auth()->user()->name }}

        </a>

        <button id="themeToggle" class="btn btn-dark">

            🌙

        </button>

        <form action="{{ route('logout') }}" method="POST">

            @csrf

            <button class="btn btn-primary" type="submit">

                Logout

            </button>

        </form>

    </div>

</div>
