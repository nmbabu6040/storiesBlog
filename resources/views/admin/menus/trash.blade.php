@extends('admin.layouts.master')

@section('title', 'Trash Menus')

@section('content')


    <div class="d-flex justify-content-between mb-4">

        <h3>Trash Menus</h3>

        <a href="{{ route('admin.menus.index') }}" class="btn btn-primary">

            Back

        </a>

    </div>

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Name</th>

                        <th>Link</th>

                        <th>Target</th>

                        <th>Deleted At</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($trashMenus as $menu)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $menu->name }}</td>

                            <td>{{ $menu->link }}</td>

                            <td>{{ $menu->target }}</td>

                            <td>{{ $menu->deleted_at }}</td>

                            <td>

                                <form action="{{ route('admin.menus.restore', $menu->id) }}" method="POST" class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        Restore

                                    </button>

                                </form>

                                <form action="{{ route('admin.menus.forceDelete', $menu->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Delete permanently?')">

                                    @csrf

                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete Forever

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                Trash is empty.

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

            {{ $trashMenus->links() }}

        </div>

    </div>

@endsection
