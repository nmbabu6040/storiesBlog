<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>
        Admin Panel
    </h2>

    <form action="{{ route('logout') }}" method="POST">

        @csrf

        <button class="btn btn-danger" type="submit">

            Logout

        </button>

    </form>

</div>
