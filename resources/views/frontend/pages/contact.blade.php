@extends('frontend.layouts.master')

@section('title', 'Contact Us')

@section('content')

    <div class="container py-5">

        <h1 class="mb-4">
            Contact Us
        </h1>

        @if (session('success'))
            <div class="alert alert-success">

                {{ session('success') }}

            </div>
        @endif

        <form action="{{ route('frontend.contact.submit') }}" method="POST">

            @csrf

            <div class="mb-3">

                <input type="text" name="name" class="form-control" placeholder="Your Name" required>

            </div>

            <div class="mb-3">

                <input type="email" name="email" class="form-control" placeholder="Your Email" required>

            </div>

            <div class="mb-3">

                <input type="text" name="subject" class="form-control" placeholder="Subject">

            </div>

            <div class="mb-3">

                <textarea name="message" rows="6" class="form-control" placeholder="Message" required></textarea>

            </div>

            <button class="btn btn-primary">

                Send Message

            </button>

        </form>

    </div>

@endsection
