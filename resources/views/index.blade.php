@extends('layouts.web')

@section('content')
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <span class="hero-badge">Purely Ayurvedic • Natural Wellness</span>
                <h1 class="hero-title">Experience Life With Ayurveda</h1>

                <p class="hero-subtitle">Sanjeevani Ortho Lab brings you authentic Vatahari Care formulations specifically
                    crafted
                    to support joint comfort and restore mobility naturally.</p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="#products" class="btn-premium btn-primary-premium text-decoration-none">Shop Products</a>
                    <a href="{{ route('page.about') }}" class="btn-premium btn-outline-premium text-decoration-none">Learn
                        More</a>
                </div>
            </div>
        </div>
        <div class="hero-image-wrapper d-none d-lg-block">
            <img src="{{ asset('banner/hero-banner.png') }}" alt="Natural Wellness">
        </div>
    </section>

    <div class="trust-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <div class="trust-icon"><i class="bi bi-shield-check"></i></div>
                        <div class="trust-text">
                            <h5>Ayurvedic</h5>
                            <p>Pure herbal extracts</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <div class="trust-icon"><i class="bi bi-truck"></i></div>
                        <div class="trust-text">
                            <h5>Fast Delivery</h5>
                            <p>Across India</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <div class="trust-icon"><i class="bi bi-cash-stack"></i></div>
                        <div class="trust-text">
                            <h5>COD Available</h5>
                            <p>Pay on delivery</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="trust-item">
                        <div class="trust-icon"><i class="bi bi-patch-check"></i></div>
                        <div class="trust-text">
                            <h5>Quality Assured</h5>
                            <p>Traditional formulation</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="container py-5 mt-5" id="products">

        <div class="limited-offer-bar">
            ⏰ Limited Time Offer – <span class="time" id="offerTimer">01:00:00</span> Left
        </div>

        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Featured Products</h2>
            <p class="text-muted">Explore our premium range for daily comfort</p>
        </div>

        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="product-card">
                        <div class="product-img-container shadow-sm">
                            <a href="{{ route('product-detail', $product->id) }}">
                                <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}">
                            </a>
                            @if ($product->compare_at_price > $product->price)
                                <span class="sale-tag">Save
                                    ₹{{ number_format($product->compare_at_price - $product->price, 0) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product-detail', $product->id) }}" class="text-decoration-none">
                            <h4 class="product-title">{{ $product->title }}</h4>
                        </a>
                        <div class="price-wrapper mb-3">
                            <span class="price-sale">₹{{ number_format($product->price, 0) }}</span>
                            @if ($product->compare_at_price)
                                <span class="price-old">₹{{ number_format($product->compare_at_price, 0) }}</span>
                            @endif
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ route('add-to-cart', $product->id) }}"
                                class="btn-premium btn-outline-premium text-decoration-none text-center py-2"
                                onclick="addToCartEvent()">Add To Cart</a>
                            <a href="{{ route('buy-now', $product->id) }}"
                                class="btn-premium btn-primary-premium text-decoration-none text-center py-2"
                                onclick="buyNowEvent()">Buy Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">No products found.</div>
            @endforelse
        </div>
    </section>

    <section class="banner-section my-5 text-center">
        <img src="{{ asset('cdn/03.webp') }}" alt="Quality Banner" class="img-fluid">
    </section>

    {{-- <section class="ayurvedic-excellence py-5">
        <div class="container text-center">
            <h2 class="display-6 fw-bold mb-5">Our Ayurvedic Excellence</h2>
            <div class="row g-4 justify-content-center">
                <div class="col-md-2 col-6">
                    <div class="excellence-card h-100 p-4 rounded-4 shadow-sm">
                        <img src="{{ asset('cdn/images/ayurvedic.webp') }}" alt="Authentic" class="img-fluid mb-3"
                            style="width: 60px;">
                        <h6 class="fw-bold">AUTHENTIC & AYURVEDIC</h6>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="excellence-card h-100 p-4 rounded-4 shadow-sm">
                        <img src="{{ asset('cdn/images/safe.webp') }}" alt="Safe" class="img-fluid mb-3"
                            style="width: 60px;">
                        <h6 class="fw-bold">SAFE & EFFECTIVE</h6>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="excellence-card h-100 p-4 rounded-4 shadow-sm">
                        <img src="{{ asset('cdn/images/gmp.webp') }}" alt="GMP" class="img-fluid mb-3"
                            style="width: 60px;">
                        <h6 class="fw-bold">GMP CERTIFIED PRODUCTS</h6>
                    </div>
                </div>
                <div class="col-md-2 col-6">
                    <div class="excellence-card h-100 p-4 rounded-4 shadow-sm">
                        <img src="{{ asset('cdn/images/chemical-free.webp') }}" alt="Chemical Free" class="img-fluid mb-3"
                            style="width: 60px;">
                        <h6 class="fw-bold">CHEMICAL FREE PRODUCTS</h6>
                    </div>
                </div>
                <div class="col-md-2 col-12">
                    <div class="excellence-card h-100 p-4 rounded-4 shadow-sm">
                        <img src="{{ asset('cdn/images/customers.webp') }}" alt="Customers" class="img-fluid mb-3"
                            style="width: 60px;">
                        <h6 class="fw-bold">20 LAKHS+ HAPPY CUSTOMERS</h6>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    @if (!empty($videos) && count($videos) > 0)
        <section class="shorts-section py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="display-6 fw-bold">Shop by Shorts</h2>
                    <p class="text-muted">Real experiences, real stories</p>
                </div>

                <div class="row row-cols-2 row-cols-lg-5 g-3 g-lg-4">
                    @foreach ($videos as $video)
                        <div class="col">
                            <div class="shorts-card h-100 shadow-sm border-0">
                                <div class="video-wrapper">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $video->getYoutubeId() }}?autoplay=0&mute=0&loop=1&playlist={{ $video->getYoutubeId() }}"
                                        loading="lazy" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
                                    </iframe>
                                </div>
                                <a href="{{ route('product-detail', $video->product->id) }}"
                                    class="d-flex align-items-center p-2 p-md-3 text-decoration-none border-top">
                                    <div class="flex-shrink-0">
                                        <img src="{{ asset($video->product->thumbnail) }}" alt="product" class="rounded"
                                            style="width: 40px; height: 40px; object-fit: cover;">
                                    </div>
                                    <div class="ms-2 ms-md-3 overflow-hidden">
                                        <h6 class="mb-0 text-dark text-truncate small fw-bold">
                                            {{ $video->product->title }}</h6>
                                        <div class="text-primary-green small fw-bold mt-1">
                                            ₹{{ number_format($video->product->price, 0) }}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="testimonial-section py-5">
        <div class="container text-center">
            <div class="mb-5">
                <h2 class="display-6 fw-bold">Happy Customers</h2>
                <p class="text-muted">Join thousands who enjoy our Ayurvedic lifestyle</p>
            </div>

            <div class="swiper testimonial-swiper pb-5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-card mx-auto" style="max-width: 700px;">
                            <i class="bi bi-quote quote-icon mb-4 d-block"></i>
                            <p class="fs-5 mb-4 italic text-secondary">"I've been using Vatahari Vati for 3 months now. My
                                daily comfort has significantly improved, and I feel much more active. Truly
                                a great lifestyle choice!"</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Rajesh Kumar</h6>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card mx-auto" style="max-width: 700px;">
                            <i class="bi bi-quote quote-icon mb-4 d-block"></i>
                            <p class="fs-5 mb-4 italic text-secondary">"The combo packs are great value. I bought the Smart
                                Combo 2 and it's much more supportive than expectations. No side effects at all."</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Anita Sharma</h6>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card mx-auto" style="max-width: 700px;">
                            <i class="bi bi-quote quote-icon mb-4 d-block"></i>
                            <p class="fs-5 mb-4 italic text-secondary">"Fast delivery and genuine products. The wellness
                                oil
                                is very soothing. Highly recommend Sanjeevani Ortho Lab for Ayurvedic
                                wellness."</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Suresh G.</h6>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Duplicated slides to ensure Swiper loop works with minimum required slides -->
                    <div class="swiper-slide">
                        <div class="testimonial-card mx-auto" style="max-width: 700px;">
                            <i class="bi bi-quote quote-icon mb-4 d-block"></i>
                            <p class="fs-5 mb-4 italic text-secondary">"I've been using Vatahari Vati for 3 months now. My
                                daily comfort has significantly improved, and I feel much more active. Truly
                                a great lifestyle choice!"</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Rajesh Kumar</h6>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card mx-auto" style="max-width: 700px;">
                            <i class="bi bi-quote quote-icon mb-4 d-block"></i>
                            <p class="fs-5 mb-4 italic text-secondary">"The combo packs are great value. I bought the Smart
                                Combo 2 and it's much more supportive than expectations. No side effects at all."</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Anita Sharma</h6>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="testimonial-card mx-auto" style="max-width: 700px;">
                            <i class="bi bi-quote quote-icon mb-4 d-block"></i>
                            <p class="fs-5 mb-4 italic text-secondary">"Fast delivery and genuine products. The wellness
                                oil
                                is very soothing. Highly recommend Sanjeevani Ortho Lab for Ayurvedic
                                wellness."</p>
                            <div class="d-flex align-items-center justify-content-center">
                                <div class="bg-light rounded-circle p-2 me-3"><i class="bi bi-person fs-4"></i></div>
                                <div class="text-start">
                                    <h6 class="mb-0 fw-bold">Suresh G.</h6>
                                    <small class="text-muted">Verified Customer</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination mt-4"></div>
                <div class="swiper-button-next d-none d-md-flex"></div>
                <div class="swiper-button-prev d-none d-md-flex"></div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Hero Section Styling */
        .hero-section {
            position: relative;
            background: #f8f9fa;
            padding: 100px 0;
            overflow: hidden;
            min-height: 600px;
            display: flex;
            align-items: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 600px;
        }

        .hero-badge {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(26, 77, 46, 0.1);
            color: var(--primary-green);
            border-radius: 50px;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 25px;
            color: var(--text-dark);
        }

        .hero-subtitle {
            font-size: 1.1rem;
            line-height: 1.6;
            color: var(--text-muted);
            margin-bottom: 35px;
        }

        .hero-image-wrapper {
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            z-index: 1;
        }

        .hero-image-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            mask-image: linear-gradient(to right, transparent, black 20%);
        }

        /* Trust Badges */
        .trust-section {
            padding: 40px 0;
            background: #fff;
            border-bottom: 1px solid #f0f0f0;
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .trust-icon {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--primary-green);
        }

        .trust-text h5 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
        }

        .trust-text p {
            margin: 0;
            font-size: 13px;
            color: var(--text-muted);
        }

        /* Product Card Styling */
        .product-card {
            background: #fff;
            border-radius: 16px;
            padding: 15px;
            transition: var(--transition-smooth);
            border: 1px solid transparent;
            height: 100%;
            text-decoration: none !important;
            display: block;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--premium-shadow);
            border-color: #f0f0f0;
        }

        .product-img-container {
            background: #f8f9fa;
            aspect-ratio: 1/1;
            overflow: hidden;
            border-radius: 12px;
            margin-bottom: 20px;
            position: relative;
        }

        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-smooth);
        }

        .product-card:hover img {
            transform: scale(1.08);
        }

        .sale-tag {
            position: absolute;
            top: 12px;
            right: 12px;
            background: #ff4d4d;
            color: #fff;
            padding: 5px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
        }

        .product-title {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            min-height: 3.2rem;
        }

        .price-sale {
            font-weight: 800;
            font-size: 1.6rem;
            color: var(--primary-green);
        }

        .price-old {
            text-decoration: line-through;
            color: #bbb;
            margin-left: 8px;
            font-size: 1.1rem;
        }

        /* Buttons Content */
        .btn-premium {
            padding: 12px 28px;
            font-weight: 700;
            border-radius: 8px;
            transition: var(--transition-smooth);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-size: 14px;
        }

        .btn-primary-premium {
            background: var(--primary-green);
            color: #fff;
            border: none;
        }

        .btn-primary-premium:hover {
            background: var(--accent-green);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(26, 77, 46, 0.2);
        }

        .btn-outline-premium {
            background: transparent;
            border: 2px solid var(--text-dark);
            color: var(--text-dark);
        }

        .btn-outline-premium:hover {
            background: var(--text-dark);
            color: #fff;
        }

        /* Excellence Cards */
        .ayurvedic-excellence {
            background: #f8f9fa;
        }

        .excellence-card {
            background: #fff;
            transition: var(--transition-smooth);
        }

        .excellence-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--premium-shadow) !important;
        }

        .excellence-card h6 {
            color: var(--primary-green);
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        /* Testimonials */
        .testimonial-section {
            background: #fff;
        }

        .testimonial-card {
            padding: 40px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        .testimonial-swiper .swiper-button-next,
        .testimonial-swiper .swiper-button-prev {
            color: var(--primary-green);
        }

        .testimonial-swiper .swiper-pagination-bullet-active {
            background: var(--primary-green);
        }

        .quote-icon {
            font-size: 40px;
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        /* Shorts Styles */
        .shorts-section {
            padding: 100px 0;
            background: #fff;
        }

        .shorts-card {
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .video-wrapper {
            position: relative;
            padding-top: 177.77%;
            /* 9:16 Aspect Ratio */
            background: #000;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
        }

        .limited-offer-bar {
            background: linear-gradient(90deg, #1a4d2e, #2d7a4d);
            color: #fff;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            font-weight: 700;
            margin-bottom: 50px;
        }

        @media (max-width: 991px) {
            .hero-section {
                padding: 60px 0;
                text-align: center;
                display: flex;
                flex-direction: column;
                align-items: center;
                min-height: auto;
            }

            .hero-content {
                max-width: 100%;
                margin: 0 auto;
                order: 1;
            }

            .hero-title {
                font-size: 2.8rem;
            }

            .hero-image-wrapper {
                position: relative;
                width: 100%;
                height: 300px;
                margin-top: 40px;
                display: block !important;
                order: 2;
                right: auto;
                top: auto;
            }

            .hero-image-wrapper img {
                mask-image: none;
                object-fit: contain;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var testimonialSwiper = new Swiper('.testimonial-swiper', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    992: {
                        slidesPerView: 3,
                        spaceBetween: 30
                    }
                }
            });
        });
    </script>
    <script>
        function startCountdown(duration, display) {
            let timer = duration,
                hours, minutes, seconds;

            setInterval(function() {
                hours = parseInt(timer / 3600, 10);
                minutes = parseInt((timer % 3600) / 60, 10);
                seconds = parseInt(timer % 60, 10);

                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                display.textContent = hours + ":" + minutes + ":" + seconds;

                if (--timer < 0) {
                    timer = 0;
                }
            }, 1000);
        }

        document.addEventListener("DOMContentLoaded", function() {
            let oneHour = 60 * 60; // 1 hour = 3600 seconds
            let display = document.querySelector('#offerTimer');
            if (display) {
                startCountdown(oneHour, display);
            }
        });

        function addToCartEvent() {
            if (typeof fbq === 'function') {
                fbq('track', 'AddToCart', {
                    content_name: 'Vatahari Vati',
                    content_category: 'Ayurvedic Product',
                    value: 1,
                    currency: 'INR'
                });
            }
        }

        function buyNowEvent() {
            if (typeof fbq === 'function') {
                fbq('track', 'InitiateCheckout', {
                    content_name: 'Vatahari Vati',
                    value: 1,
                    currency: 'INR'
                });
            }
        }
    </script>
@endpush
