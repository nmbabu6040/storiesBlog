@extends('admin.layouts.master')

@section('title', 'Activity Log')

@section('content')

    <div class="d-flex justify-content-between mb-4">

        <h3>Activity Logs</h3>

        <form action="{{ route('admin.activity.clear') }}" method="POST" onsubmit="return confirm('Clear all logs?')">

            @csrf
            @method('DELETE')

            <button class="btn btn-danger">

                Clear All

            </button>

        </form>

    </div>

    <form class="row mb-4">

        <div class="col-md-3">

            <input type="text" name="module" class="form-control" placeholder="Module" value="{{ request('module') }}">

        </div>

        <div class="col-md-3">

            <input type="text" name="action" class="form-control" placeholder="Action" value="{{ request('action') }}">

        </div>

        <div class="col-md-2">

            <button class="btn btn-primary">

                Filter

            </button>

        </div>

    </form>

    <div class="card">

        <div class="table-responsive">

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>User</th>

                        <th>Module</th>

                        <th>Action</th>

                        <th>Description</th>

                        <th>IP</th>

                        <th>Date</th>

                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($logs as $log)
                        <tr>

                            <td>

                                {{ $log->user?->name ?? 'System' }}

                            </td>

                            <td>

                                {{ $log->module }}

                            </td>

                            <td>

                                {{ $log->action }}

                            </td>

                            <td>

                                {{ $log->description }}

                            </td>

                            <td>

                                {{ $log->ip }}

                            </td>

                            <td>

                                {{ $log->created_at->diffForHumans() }}

                            </td>

                            <td>

                                <form action="{{ route('admin.activity.destroy', $log) }}" method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7">

                                No Activity Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-4">

        {{ $logs->links() }}

    </div>

@endsection
