<div class="card">
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control"
                value="{{ old('title', $page->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Slug</label>
            <input type="text" name="slug" id="slug" class="form-control"
                value="{{ old('slug', $page->slug ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Banner Image</label>

            <input type="file" name="banner_image" class="form-control">

            @if (isset($page) && $page->banner_image)
                <img src="{{ asset('storage/' . $page->banner_image) }}" width="180" class="mt-3 rounded">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>

            <textarea id="content" name="content" rows="12" class="form-control">{{ old('content', $page->content ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Title</label>

            <input type="text" name="meta_title" class="form-control"
                value="{{ old('meta_title', $page->meta_title ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Description</label>

            <textarea name="meta_description" rows="4" class="form-control">{{ old('meta_description', $page->meta_description ?? '') }}</textarea>
        </div>

        <div class="form-check mb-4">

            <input class="form-check-input" type="checkbox" name="status" value="1"
                {{ old('status', $page->status ?? true) ? 'checked' : '' }}>

            <label class="form-check-label">
                Active
            </label>

        </div>

    </div>
</div>
