<div class="d-flex justify-content-between align-items-center mb-4">

    <div class="">
        <h2>
            Admin Panel
        </h2>

    </div>

    <form action="{{ route('logout') }}" method="POST">

        @csrf
        <div class="d-flex gap-3 justify-content-end align-items-center">
            <h6 class="text-success">{{ auth()->user()->name }}</h6>
            <button class="btn btn-primary" type="submit">

                Logout

            </button>
        </div>

    </form>

</div>
