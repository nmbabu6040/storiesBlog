@extends('admin.layouts.master')

@section('title', 'Backup')

@section('content')

    <div class="card">

        <div class="card-header d-flex justify-content-between">

            <h4>System Backup</h4>

            <form action="{{ route('admin.backup.create') }}" method="POST">

                @csrf

                <button class="btn btn-primary">

                    Create Backup

                </button>

            </form>

        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>File</th>

                        <th>Size</th>

                        <th>Date</th>

                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($files as $file)
                        <tr>

                            <td>{{ $file->getFilename() }}</td>

                            <td>{{ round($file->getSize() / 1024 / 1024, 2) }} MB</td>

                            <td>{{ date('d M Y h:i A', $file->getMTime()) }}</td>

                            <td>

                                <a href="{{ route('admin.backup.download', $file->getFilename()) }}"
                                    class="btn btn-success btn-sm">

                                    Download

                                </a>

                                <form action="{{ route('admin.backup.delete', $file->getFilename()) }}" method="POST"
                                    class="d-inline">

                                    @csrf

                                    @method('DELETE')

                                    <button onclick="return confirm('Delete Backup?')" class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="text-center">

                                No Backup Found

                            </td>

                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

@endsection
