<div class="card">
    <div class="card-body">

        <div class="mb-3">
            <label class="form-label">Title</label>

            <input type="text" name="title" class="form-control"
                value="{{ old('title', $advertisement->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Position</label>

            <select name="position" class="form-select" required>

                <option value="">Select Position</option>

                @foreach ([
        'header' => 'Header',
        'sidebar' => 'Sidebar',
        'before_post' => 'Before Post',
        'after_post' => 'After Post',
        'footer' => 'Footer',
    ] as $key => $value)
                    <option value="{{ $key }}" @selected(old('position', $advertisement->position ?? '') == $key)>
                        {{ $value }}
                    </option>
                @endforeach

            </select>

        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>

            <select name="type" id="type" class="form-select">

                <option value="adsense" @selected(old('type', $advertisement->type ?? '') == 'adsense')>

                    Adsense

                </option>

                <option value="html" @selected(old('type', $advertisement->type ?? '') == 'html')>

                    HTML

                </option>

                <option value="image" @selected(old('type', $advertisement->type ?? '') == 'image')>

                    Image Banner

                </option>

            </select>

        </div>

        <div id="codeSection">

            <div class="mb-3">

                <label class="form-label">

                    HTML / Adsense Code

                </label>

                <textarea name="code" rows="8" class="form-control">{{ old('code', $advertisement->code ?? '') }}</textarea>

            </div>

        </div>

        <div id="imageSection">

            <div class="mb-3">

                <label class="form-label">

                    Banner Image

                </label>

                <input type="file" name="image" class="form-control">

                @if (isset($advertisement) && $advertisement->image)
                    <img src="{{ asset('storage/' . $advertisement->image) }}" class="img-thumbnail mt-3"
                        width="220">
                @endif

            </div>

            <div class="mb-3">

                <label class="form-label">

                    Banner URL

                </label>

                <input type="text" name="url" class="form-control"
                    value="{{ old('url', $advertisement->url ?? '') }}">

            </div>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Sort Order

            </label>

            <input type="number" name="sort_order" class="form-control"
                value="{{ old('sort_order', $advertisement->sort_order ?? 0) }}">

        </div>

        <div class="form-check mb-4">

            <input class="form-check-input" type="checkbox" name="status" value="1"
                {{ old('status', $advertisement->status ?? true) ? 'checked' : '' }}>

            <label class="form-check-label">

                Active

            </label>

        </div>

    </div>
</div>

@push('scripts')
    <script>
        function toggleAdFields() {

            let type = $("#type").val();

            if (type === "image") {

                $("#imageSection").show();

                $("#codeSection").hide();

            } else {

                $("#imageSection").hide();

                $("#codeSection").show();

            }

        }

        toggleAdFields();

        $("#type").on("change", toggleAdFields);
    </script>
@endpush
