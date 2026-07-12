@extends('admin.layouts.master')

@section('title', 'Send Newsletter')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Send Newsletter</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('admin.newsletter.send') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label>Subject</label>

                    <input type="text" name="subject" class="form-control" required>

                </div>

                <div class="mb-3">

                    <label>Message</label>

                    <textarea id="content" name="body" class="form-control" rows="10"></textarea>

                </div>

                <button class="btn btn-primary">

                    Send Newsletter

                </button>

            </form>

        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(function() {

            $('#content').summernote({

                height: 350

            });

        });
    </script>
@endpush
