<div class="card">

    <div class="card-body">

        {{-- Menu Name --}}
        <div class="mb-3">

            <label class="form-label">
                Menu Name
            </label>

            <input id="menuName" type="text" name="name" class="form-control"
                value="{{ old('name', $menu->name ?? '') }}">

        </div>

        {{-- Menu Type --}}
        <div class="mb-3">

            <label class="form-label">
                Menu Type
            </label>

            <select id="menuType" name="type" class="form-select">

                <option value="custom" {{ old('type', $menu->type ?? '') == 'custom' ? 'selected' : '' }}>

                    Custom URL

                </option>

                <option value="page" {{ old('type', $menu->type ?? '') == 'page' ? 'selected' : '' }}>

                    Page

                </option>

                <option value="category" {{ old('type', $menu->type ?? '') == 'category' ? 'selected' : '' }}>

                    Category

                </option>

            </select>

        </div>

        {{-- Menu Location --}}
        <div class="mb-3">

            <label class="form-label">
                Menu Location
            </label>

            <select name="menu_location" class="form-select">

                <option value="header"
                    {{ old('menu_location', $menu->menu_location ?? '') == 'header' ? 'selected' : '' }}>
                    Header Navigation
                </option>

                <option value="footer_1"
                    {{ old('menu_location', $menu->menu_location ?? '') == 'footer_1' ? 'selected' : '' }}>
                    Footer Quick Links
                </option>

                <option value="footer_2"
                    {{ old('menu_location', $menu->menu_location ?? '') == 'footer_2' ? 'selected' : '' }}>
                    Footer Resources
                </option>

                <option value="footer_3"
                    {{ old('menu_location', $menu->menu_location ?? '') == 'footer_3' ? 'selected' : '' }}>
                    Footer Column 4
                </option>

                <option value="footer_4"
                    {{ old('menu_location', $menu->menu_location ?? '') == 'footer_4' ? 'selected' : '' }}>
                    Reserved
                </option>

            </select>

        </div>

        {{-- Custom URL --}}
        <div class="mb-3" id="urlBox">

            <label class="form-label">
                Custom URL
            </label>

            <input type="text" name="url" class="form-control" value="{{ old('url', $menu->url ?? '') }}"
                placeholder="/about-us or https://google.com">

        </div>

        {{-- Page --}}
        <div class="mb-3" id="pageBox">

            <label class="form-label">
                Select Page
            </label>

            <select name="page_slug" class="form-select">

                <option value="">Select Page</option>

                @foreach ($pages as $slug => $title)
                    <option value="{{ $slug }}"
                        {{ old('page_slug', $menu->page_slug ?? '') == $slug ? 'selected' : '' }}>

                        {{ $title }}

                    </option>
                @endforeach

            </select>

        </div>

        {{-- Category --}}
        <div class="mb-3" id="categoryBox">

            <label class="form-label">
                Select Category
            </label>

            <select name="category_id" class="form-select">

                <option value="">
                    Select Category
                </option>

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" data-name="{{ $category->name }}"
                        {{ old('category_id', $menu->category_id ?? '') == $category->id ? 'selected' : '' }}>

                        {{ $category->name }}

                    </option>
                @endforeach

            </select>

        </div>

        {{-- Parent --}}
        <div class="mb-3">

            <label class="form-label">
                Parent Menu
            </label>

            <select name="parent_id" class="form-select">

                <option value="">
                    None
                </option>

                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}"
                        {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>

                        {{ $parent->name }}

                    </option>
                @endforeach

            </select>

        </div>

        {{-- Target --}}
        <div class="mb-3">

            <label class="form-label">
                Target
            </label>

            <select name="target" class="form-select">

                <option value="_self" {{ old('target', $menu->target ?? '_self') == '_self' ? 'selected' : '' }}>

                    Same Tab

                </option>

                <option value="_blank" {{ old('target', $menu->target ?? '') == '_blank' ? 'selected' : '' }}>

                    New Tab

                </option>

            </select>

        </div>

        {{-- Sort --}}
        <div class="mb-3">

            <label class="form-label">
                Sort Order
            </label>

            <input type="number" name="sort_order" class="form-control"
                value="{{ old('sort_order', $menu->sort_order ?? 0) }}">

        </div>

        {{-- Status --}}
        <div class="form-check mb-4">

            <input class="form-check-input" type="checkbox" name="status" value="1"
                {{ old('status', $menu->status ?? true) ? 'checked' : '' }}>

            <label class="form-check-label">

                Active

            </label>

        </div>

    </div>

</div>

@section('scripts')
    <script>
        const type = document.getElementById('menuType');

        const page = document.querySelector('[name="page_slug"]');

        const category = document.querySelector('[name="category_id"]');

        const name = document.getElementById('menuName');

        page.addEventListener('change', function() {

            if (type.value === 'page') {

                name.value = this.options[this.selectedIndex].text;

            }

        });

        category.addEventListener('change', function() {

            if (type.value === 'category') {

                name.value = this.options[this.selectedIndex].text;

            }

        });
    </script>
@endsection
