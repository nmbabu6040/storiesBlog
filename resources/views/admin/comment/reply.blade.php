@extends('admin.layouts.master')

@section('title', 'Reply Comment')

@section('content')

    <div class="card">

        <div class="card-header">

            <h4>Reply Comment</h4>

        </div>

        <div class="card-body">

            <div class="alert alert-light">

                <strong>{{ $comment->name }}</strong>

                <hr>

                {{ $comment->comment }}

            </div>

            <form method="POST" action="{{ route('admin.comments.reply.store', $comment->id) }}">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Your Reply

                    </label>

                    <textarea name="comment" class="form-control" rows="6" required></textarea>

                </div>

                <button class="btn btn-primary">

                    Send Reply

                </button>

            </form>

        </div>

    </div>

@endsection
