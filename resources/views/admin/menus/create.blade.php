@extends('admin.layouts.master')

@section('title', 'Create Menu')

@section('content')

    <form action="{{ route('admin.menus.store') }}" method="POST">

        @csrf

        @include('admin.menus._form')

        <div class="d-flex gap-3">
            <button class="btn btn-primary mt-3">

                Save Menu

            </button>

            <a href="{{ route('admin.menus.index') }}" class="btn btn-danger mt-3">
                Cancel
            </a>
        </div>

    </form>

@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const type = document.getElementById("menuType");

            const menuName = document.getElementById("menuName");

            const urlBox = document.getElementById("urlBox");

            const pageBox = document.getElementById("pageBox");

            const categoryBox = document.getElementById("categoryBox");

            const pageSelect = document.querySelector("[name='page_slug']");

            const categorySelect = document.querySelector("[name='category_id']");

            function toggleFields() {

                urlBox.style.display = 'none';

                pageBox.style.display = 'none';

                categoryBox.style.display = 'none';

                if (type.value == 'custom') {

                    urlBox.style.display = 'block';

                }

                if (type.value == 'page') {

                    pageBox.style.display = 'block';

                }

                if (type.value == 'category') {

                    categoryBox.style.display = 'block';

                }

            }

            toggleFields();

            type.addEventListener("change", toggleFields);

            pageSelect.addEventListener("change", function() {

                const text = this.options[this.selectedIndex].dataset.name;

                if (text) {

                    menuName.value = text;

                }

            });

            categorySelect.addEventListener("change", function() {

                const text = this.options[this.selectedIndex].dataset.name;

                if (text) {

                    menuName.value = text;

                }

            });

        });
    </script>
@endpush
