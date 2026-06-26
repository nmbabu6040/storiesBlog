<footer class="footer-main">

    <div class="container">

        <div class="row">

            <div class="col-lg-3">

                <a href=" {{ route('frontend.home') }}" class="logo">
                    @if (!empty($siteSetting->footer_logo))
                        <img src="{{ asset('storage/' . $siteSetting->footer_logo) }}" alt="Footer Logo" height="50">
                    @endif
                </a>

                <p class="mt-3">

                    Start writing, no matter what.
                    The water does not flow until
                    the faucet is turned on.

                </p>

                <div class="social-links">

                    <span>Follow Us:</span>

                    <div class="d-flex gap-3 mt-3">
                        @if ($siteSetting?->facebook_url)
                            <a href="{{ $siteSetting->facebook_url }}" target="_blank">
                                <i class="fa-brands fa-facebook-f"></i>
                            </a>
                        @endif

                        @if ($siteSetting?->instagram_url)
                            <a href="{{ $siteSetting->instagram_url }}" target="_blank">
                                <i class="fa-brands fa-instagram"></i>
                            </a>
                        @endif

                        @if ($siteSetting?->youtube_url)
                            <a href="{{ $siteSetting->youtube_url }}" target="_blank">
                                <i class="fa-brands fa-youtube"></i>
                            </a>
                        @endif
                    </div>

                </div>

            </div>

            <div class="col-lg-3">

                <h5 class="footer-title">
                    QUICK LINKS
                </h5>

                <div class="footer-links">

                    <a href="{{ route('frontend.about') }}">About</a>

                    <a href="{{ route('frontend.contact') }}">Contact</a>

                    <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>

                    <a href="{{ route('frontend.terms') }}">Terms & Conditions</a>

                    <a href="{{ route('frontend.disclaimer') }}">Disclaimer</a>

                </div>

            </div>

            <div class="col-lg-3">

                <h5 class="footer-title">
                    TAG CLOUD
                </h5>

                <div class="d-flex flex-wrap gap-2">

                    @foreach ($footerCategories as $category)
                        <a href="{{ route('frontend.category.show', $category->slug) }}"
                            class="tag btn btn-outline-primary">

                            {{ $category->name }}

                        </a>
                    @endforeach

                </div>

            </div>

            <div class="col-lg-3">

                <h5 class="footer-title">
                    NEWSLETTER
                </h5>

                <div class="sidebar-widget">

                    @if (session('subscribe_success'))
                        <div class="alert alert-success">

                            {{ session('subscribe_success') }}

                        </div>
                    @endif

                    <form action="{{ route('frontend.subscribe') }}" method="POST">

                        @csrf

                        <input type="email" name="email" class="form-control mb-3" placeholder="Email Address"
                            required>

                        <button type="submit" class="btn btn-dark w-100">

                            Subscribe

                        </button>

                    </form>

                </div>
            </div>

        </div>

        <hr>

        <div class="text-center">

            {{ $siteSetting->copyright_text }}

        </div>

    </div>

</footer>
