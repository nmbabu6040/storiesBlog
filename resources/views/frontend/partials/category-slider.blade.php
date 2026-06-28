{{-- categories section  --}}
<section class="categories_section py-5">

    <div class="container">

        <h5 class="section-title">
            CATEGORIES
        </h5>

        <div class="row g-4">

            <div class="categorySlider owl-carousel owl-theme">

                @foreach ($categories as $category)
                    <div class="item">

                        <div class="post-card text-center">

                            <a href="{{ route('frontend.category.show', $category->slug) }}">

                                <img class="post-image-sm" src="{{ asset('storage/' . $category->image) }}"
                                    alt="{{ $category->name }}">

                            </a>

                            <div class="post-content">

                                <h5>

                                    <a href="{{ route('frontend.category.show', $category->slug) }}">

                                        {{ $category->name }}

                                    </a>

                                </h5>

                                <small>

                                    {{ $category->posts()->count() }}
                                    Posts

                                </small>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>
    </div>

</section>
@push('scripts')
    <script>
        $('.categorySlider').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            autoplay: true,
            autoplayTimeout: 3000,
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                768: {
                    items: 3
                },
                992: {
                    items: 5
                }
            }
        });
    </script>
@endpush
