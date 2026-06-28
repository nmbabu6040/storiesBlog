@extends('admin.layouts.master')

@section('title', 'Settings')

@section('content')

    <h3 class="mb-4">
        Website Settings
    </h3>

    @if (session('success'))
        <div class="alert alert-success">

            {{ session('success') }}

        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">

        @csrf

        <div class="card">

            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">
                        Site Name
                    </label>

                    <input type="text" name="site_name" class="form-control" value="{{ $setting->site_name ?? '' }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Site Description

                    </label>

                    <textarea name="site_description" rows="3" class="form-control">{{ old('site_description', $setting->site_description) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Default Meta Keywords

                    </label>

                    <textarea name="meta_keywords" rows="3" class="form-control" placeholder="blog, travel, lifestyle, news">{{ old('meta_keywords', $setting->meta_keywords) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Header Logo
                    </label>

                    <input type="file" name="header_logo" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Footer Logo
                    </label>

                    <input type="file" name="footer_logo" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Favicon
                    </label>

                    <input type="file" name="favicon" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Author Name
                    </label>

                    <input type="text" name="author_name" class="form-control" value="{{ $setting->author_name ?? '' }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Author Image
                    </label>

                    <input type="file" name="author_image" class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Author Description
                    </label>

                    <textarea name="author_description" rows="4" class="form-control">{{ $setting->author_description ?? '' }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Hero Title

                    </label>

                    <input type="text" name="hero_title" class="form-control"
                        value="{{ old('hero_title', $setting->hero_title) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Hero Subtitle

                    </label>

                    <textarea name="hero_subtitle" rows="3" class="form-control">{{ old('hero_subtitle', $setting->hero_subtitle) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Hero Animated Text

                    </label>

                    <input type="text" name="hero_type_text" class="form-control"
                        placeholder="Travel Blogger,Content Writer,Food Guide"
                        value="{{ old('hero_type_text', $setting->hero_type_text) }}">

                    <small class="text-muted">

                        Separate values with commas (,)

                    </small>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Hero Image
                    </label>

                    <input type="file" name="hero_image" class="form-control">

                </div>

                <div class="mb-3">
                    <label>Travel Category</label>

                    <select name="travel_category_id" class="form-select">

                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('travel_category_id', $setting->travel_category_id) == $category->id)>

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label>Destination Category</label>

                    <select name="destination_category_id" class="form-select">

                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('destination_category_id', $setting->destination_category_id) == $category->id)>

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label>Lifestyle Category</label>

                    <select name="lifestyle_category_id" class="form-select">

                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('lifestyle_category_id', $setting->lifestyle_category_id) == $category->id)>

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label>Photography Category</label>

                    <select name="photography_category_id" class="form-select">

                        <option value="">Select Category</option>

                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('photography_category_id', $setting->photography_category_id) == $category->id)>

                                {{ $category->name }}

                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Facebook URL
                    </label>

                    <input type="text" name="facebook_url" class="form-control"
                        value="{{ $setting->facebook_url ?? '' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Instagram URL
                    </label>

                    <input type="text" name="instagram_url" class="form-control"
                        value="{{ $setting->instagram_url ?? '' }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        YouTube URL
                    </label>

                    <input type="text" name="youtube_url" class="form-control"
                        value="{{ $setting->youtube_url ?? '' }}">
                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Footer Column 1 Title

                    </label>

                    <input type="text" class="form-control" name="footer_title_1"
                        value="{{ old('footer_title_1', $setting->footer_title_1) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Footer Column 2 Title

                    </label>

                    <input type="text" class="form-control" name="footer_title_2"
                        value="{{ old('footer_title_2', $setting->footer_title_2) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Footer Column 3 Title

                    </label>

                    <input type="text" class="form-control" name="footer_title_3"
                        value="{{ old('footer_title_3', $setting->footer_title_3) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Footer Column 4 Title

                    </label>

                    <input type="text" class="form-control" name="footer_title_4"
                        value="{{ old('footer_title_4', $setting->footer_title_4) }}">

                </div>

                <hr>

                <h4 class="mb-3">

                    Contact Information

                </h4>

                <div class="mb-3">

                    <label class="form-label">

                        Phone

                    </label>

                    <input type="text" name="phone" class="form-control"
                        value="{{ old('phone', $setting->phone) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Email

                    </label>

                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $setting->email) }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Address

                    </label>

                    <textarea name="address" rows="3" class="form-control">{{ old('address', $setting->address) }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Google Map (Embed iframe)

                    </label>

                    <textarea name="google_map" rows="6" class="form-control">{{ old('google_map', $setting->google_map) }}</textarea>

                </div>

                <div class="mb-3">
                    <label class="form-label">
                        Copyright Text
                    </label>

                    <textarea name="copyright_text" class="form-control" rows="3">{{ $setting->copyright_text ?? '' }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">

                    Save Settings

                </button>

            </div>

        </div>

    </form>

@endsection
