@extends('admin.layouts.master')

@section('title', 'Menus')

@section('content')

    <h6 class="mb-3">
        Total Menus: {{ $adminMenus->count() }}
    </h6>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h4>Menus</h4>

        <a href="{{ route('admin.menus.create') }}" class="btn btn-primary">
            Add Menu
        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <div class="card">

        <div class="card-body">

            <table class="table table-bordered align-middle">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Name</th>

                        <th>URL</th>

                        <th>Parent</th>

                        <th>Location</th>

                        <th>Order</th>

                        <th>Status</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($adminMenus as $menu)
                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $menu->name }}</td>

                            <td>

                                @if ($menu->type == 'custom')
                                    <span class="badge bg-secondary">
                                        {{ $menu->url }}
                                    </span>
                                @elseif($menu->type == 'page')
                                    <span class="badge bg-info">
                                        {{ $menu->page_slug }}
                                    </span>
                                @elseif($menu->type == 'category')
                                    <span class="badge bg-primary">
                                        {{ $menu->category?->name }}
                                    </span>
                                @endif

                            </td>

                            <td>{{ $menu->parent?->name ?? '-' }}</td>

                            <td>

                                @switch($menu->menu_location)
                                    @case('header')
                                        <span class="badge bg-primary">Header</span>
                                    @break

                                    @case('footer_1')
                                        <span class="badge bg-success">Footer 1</span>
                                    @break

                                    @case('footer_2')
                                        <span class="badge bg-success">Footer 2</span>
                                    @break

                                    @case('footer_3')
                                        <span class="badge bg-success">Footer 3</span>
                                    @break

                                    @case('footer_4')
                                        <span class="badge bg-success">Footer 4</span>
                                    @break
                                @endswitch

                            </td>
                            <td>{{ $menu->sort_order }}</td>

                            <td>

                                @if ($menu->status)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.menus.edit', $menu->id) }}" class="btn btn-sm btn-warning">

                                    Edit

                                </a>

                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Delete Menu?')" class="btn btn-sm btn-danger">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="text-center">

                                    No Menu Found

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    @endsection
