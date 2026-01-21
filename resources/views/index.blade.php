<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vatahari – Natural Ortho Care Solutions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <style>
        :root {
            --primary-green: #1a4d2e;
            --text-dark: #121212;
            --font-main: 'Assistant', sans-serif;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* Announcement Bar */
        .announcement-bar {
            background: #f8f9fa;
            font-size: 13px;
            letter-spacing: 1px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }

        /* Navbar Styling */
        .navbar-brand {
            font-weight: 800;
            font-size: 24px;
            color: #000 !important;
        }

        .nav-link {
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            color: #333 !important;
        }

        /* Banner Style */
        .banner-section img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Product Card Styling */
        .product-card {
            border: none;
            background: #fff;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .product-img-container {
            background: #f3f3f3;
            aspect-ratio: 1/1;
            overflow: hidden;
            border-radius: 4px;
        }

        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .product-card:hover img {
            transform: scale(1.05);
        }

        .product-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-top: 15px;
            color: #121212;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-decoration: none;
            min-height: 40px;
        }

        .price-sale {
            font-weight: 800;
            font-size: 1.6rem;
            color: #000;
        }

        .price-old {
            text-decoration: line-through;
            color: #888;
            margin-left: 8px;
            font-size: 1.3rem;
        }

        /* Buttons Custom */
        .btn-custom {
            padding: 12px;
            font-size: 13px;
            font-weight: 700;
            border-radius: 4px;
            text-transform: uppercase;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: center;
        }

        .btn-atc {
            border: 1.5px solid #000;
            color: #000;
            background: transparent;
        }

        .btn-buy {
            background: #000;
            color: #fff;
            border: 1.5px solid #000;
        }

        .btn-atc:hover {
            background: #f0f0f0;
        }

        .btn-buy:hover {
            background: #333;
        }

        /* Shorts Slider Styling */
        .shorts-section {
            padding: 60px 0;
            background: #fff;
        }

        .shorts-card {
            border-radius: 12px;
            border: 1px solid #eee;
            overflow: hidden;
            background: #fff;
            height: 100%;
        }

        .video-wrapper {
            position: relative;
            padding-top: 177.77%;
            background: #000;
            cursor: pointer;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .short-product-info {
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none !important;
        }

        .short-product-info img {
            width: 45px;
            height: 45px;
            border-radius: 6px;
            object-fit: cover;
        }

        .short-product-info h4 {
            margin: 0;
            font-size: 1.3rem;
            font-weight: 700;
            color: #000;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Swiper Custom Arrows */
        .swiper-button-next,
        .swiper-button-prev {
            background: #fff;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            color: #000;
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 14px;
            font-weight: bold;
        }
    </style>

    {{-- <style>
        .whatsapp-float {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #25D366;
            color: #fff;
            border-radius: 50px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            text-decoration: none;
        }

        .whatsapp-float:hover {
            background: #1ebe5d;
            color: #fff;
        }
    </style> --}}

    {{-- <style>
        .support-float {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #0d6efd;
            color: #fff;
            border-radius: 50px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            text-decoration: none;
        }

        .support-float:hover {
            background: #0b5ed7;
            color: #fff;
        }
    </style> --}}

    <style>
        .support-float {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #000;
            color: #fff;
            border-radius: 50px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .support-float:hover {
            background: #fff;
            color: #000;
            border: 1px solid #000;
        }
    </style>
</head>

{{-- <a href="https://wa.me/910?text=Hello%20I%20want%20to%20know%20about%20Vatahari%20products" class="whatsapp-float"
    target="_blank">
    <i class="bi bi-whatsapp fs-4"></i>
    Chat on WhatsApp
</a> --}}

{{-- <a href="tel:+919999999999" class="support-float">
    <i class="bi bi-telephone-fill fs-4"></i>
    Call Support
</a> --}}

{{-- <a href="mailto:support@vatahari.com" class="support-float">
    <i class="bi bi-envelope-fill fs-4"></i>
    Email Support
</a> --}}

<a href="#" class="support-float">
    <i class="bi bi-headset fs-4"></i>
    Customer Support
</a>

<body>

    <div class="announcement-bar text-center">
        WELCOME TO OUR STORE
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand" href="#">VATAHARI</a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <i class="bi bi-list fs-1"></i>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav mx-auto">
                    {{-- <li class="nav-item"><a class="nav-link px-3" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#">Shop All</a></li>
                    <li class="nav-item"><a class="nav-link px-3" href="#">Ayurvedic Tips</a></li> --}}
                </ul>
                <div class="d-flex align-items-center gap-4">
                    <i class="bi bi-search fs-5" style="cursor:pointer"></i>
                    <i class="bi bi-person fs-5" style="cursor:pointer"></i>
                    <div class="position-relative">
                        <i class="bi bi-bag fs-5" style="cursor:pointer"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                            style="font-size: 9px;">0</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <section class="banner-section">
        <img src="{{ asset('cdn/001.png') }}" alt="Joint Pain Relief Banner">
    </section>

    <section class="container py-5">
        <h2 class="h1 fw-bold mb-5">Featured Products</h2>
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        <a href="{{ route('product-detail', $product->id) }}" class="text-decoration-none">
                            <div class="product-img-container">
                                <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}">
                            </div>
                            <h4 class="product-title">{{ $product->title }}</h4>
                        </a>
                        <div class="price-wrapper my-2">
                            <span class="price-sale">₹{{ number_format($product->price, 2) }}</span>
                            @if ($product->compare_at_price)
                                <span class="price-old">₹{{ number_format($product->compare_at_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <a href="#" class="btn-custom btn-atc">Add to Cart</a>
                            <a href="{{ $product->external_link }}" target="_blank" class="btn-custom btn-buy">Buy
                                Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">No products found.</div>
            @endforelse
        </div>
    </section>

    <section class="banner-section my-5">
        <img src="{{ asset('cdn/002.png') }}" alt="Quality Banner">
    </section>

    <section class="container py-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Smart Combo Offers</h2>
            <p class="text-muted">High Attraction + Higher Cart Value</p>
        </div>

        <div class="row g-4">

            <!-- Pack 1 -->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <h5 class="fw-bold">Pack of 1</h5>
                        <p class="text-muted small">Best for first-time users</p>

                        <div class="my-3">
                            <span class="text-decoration-line-through text-muted">₹700</span>
                            <span class="fs-3 fw-bold ms-2">₹600</span>
                        </div>

                        <p class="text-danger fw-bold small">आप बचाते हैं ₹100</p>

                        <span class="badge bg-secondary mb-3">Trial Pack</span>

                        <div class="d-grid mt-3">
                            <a href="https://www.flipkart.com/ytm-vatahari-vati-original-tablet-pack-1-arthritis-sciatica-joint-pain-tablets/p/itm18780af6afda0?pid=BPRGA4FGMMZGCR9Z"
                                class="btn btn-dark">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pack 2 -->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow border-2 border-success">
                    <div class="card-body text-center position-relative">

                        <span class="badge bg-success position-absolute top-0 start-50 translate-middle">Most
                            Popular</span>

                        <h5 class="fw-bold mt-3">Pack of 2</h5>
                        <p class="text-muted small">Couple / 1 Month Regular Use</p>

                        <div class="my-3">
                            <span class="text-decoration-line-through text-muted">₹1400</span>
                            <span class="fs-3 fw-bold ms-2">₹1,099</span>
                        </div>

                        <p class="text-success fw-bold small">आप बचाते हैं ₹301</p>
                        <p class="small text-muted">(Per product: ₹549)</p>

                        <div class="d-grid mt-3">
                            <a href="https://www.flipkart.com/ytm-vatahari-vati-ayurvedic-tablets-joints-pain-2-x-30-units/p/itm01296c4901bcb?pid=BPRGRZTETYFET8VJ"
                                class="btn btn-dark">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pack 3 -->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <span class="badge bg-warning text-dark mb-2">Best Value</span>

                        <h5 class="fw-bold">Pack of 3</h5>
                        <p class="text-muted small">Family Pack / 2–3 Months Use</p>

                        <div class="my-3">
                            <span class="text-decoration-line-through text-muted">₹2100</span>
                            <span class="fs-3 fw-bold ms-2">₹1,499</span>
                        </div>

                        <p class="text-danger fw-bold small">आप बचाते हैं ₹601</p>
                        <p class="small text-muted">(Per product: ₹499)</p>

                        <div class="d-grid mt-3">
                            <a href="https://www.flipkart.com/ytm-watahari-wati-cartilage-bone-joint-support-supplement-collagen-glucosamine/p/itm975ad3d38b0d7?pid=AYDHJFPKTYNFSUMB"
                                class="btn btn-dark">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pack 5 -->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <span class="badge bg-danger mb-2">Maximum Savings</span>

                        <h5 class="fw-bold">Pack of 5</h5>
                        <p class="text-muted small">Long-Term Health Users</p>

                        <div class="my-3">
                            <span class="text-decoration-line-through text-muted">₹3500</span>
                            <span class="fs-3 fw-bold ms-2">₹2,299</span>
                        </div>

                        <p class="text-danger fw-bold small">आप बचाते हैं ₹1,201</p>
                        <p class="small text-muted">(Per product: ₹459)</p>

                        <div class="d-grid mt-3">
                            <a href="https://www.flipkart.com/ytm-watahari-wati-jodo-ghutnon-aur-nason-ke-dard-arthritis-pain-ki-ayurvedic-dawa/p/itm452a7b807eebb?pid=AYDHJCD8DKEUP3HS"
                                class="btn btn-dark">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Pack 10 -->
            <div class="col-md-6 col-lg-4 col-xl-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body text-center">
                        <span class="badge bg-primary mb-2">Wholesale Pack</span>

                        <h5 class="fw-bold">Pack of 10</h5>
                        <p class="text-muted small">Big Families / Resellers</p>

                        <div class="my-3">
                            <span class="text-decoration-line-through text-muted">₹7000</span>
                            <span class="fs-3 fw-bold ms-2">₹3,999</span>
                        </div>

                        <p class="text-success fw-bold small">आप बचाते हैं ₹3,001</p>
                        <p class="small text-muted">(Per product: ₹399)</p>

                        <div class="d-grid mt-3">
                            <a href="#" class="btn btn-dark">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </section>


    @if (!empty($videos) && count($videos) > 0)
        <section class="shorts-section bg-light">
            <div class="container">
                <h2 class="h1 fw-bold text-center mb-5">Shop by Shorts</h2>

                <div class="swiper myShortsSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($videos as $video)
                            <div class="swiper-slide">
                                <div class="shorts-card shadow-sm">
                                    <div class="video-wrapper" onclick="this.style.pointerEvents='auto'">
                                        <iframe
                                            src="https://www.youtube.com/embed/{{ $video->getYoutubeId() }}?autoplay=0&mute=1&loop=1&playlist={{ $video->getYoutubeId() }}"
                                            loading="lazy" frameborder="0" allow="autoplay; encrypted-media"
                                            allowfullscreen>
                                        </iframe>

                                    </div>
                                    <a href="{{ route('product-detail', $video->product->id) }}"
                                        class="short-product-info">
                                        <img src="{{ asset($video->product->thumbnail) }}" alt="product">
                                        <div class="w-100 overflow-hidden">
                                            <h4>{{ $video->product->title }}</h4>
                                            <div class="text-muted small fw-bold">
                                                ₹{{ number_format($video->product->price, 2) }}</div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
    @endif

    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row g-4">

                <!-- Brand -->
                <div class="col-md-10">
                    <h4 class="fw-bold">VATAHARI</h4>
                    <p class="text-secondary small">
                        Natural Ortho Care Solutions for Better Life.
                    </p>
                </div>

                <!-- Contact Info -->
                <div class="col-md-2">
                    <h5 class="fw-bold mb-3">Contact Us</h5>

                    {{-- <p class="small mb-2">
                        <i class="bi bi-person me-2"></i> Rohit Kumar
                    </p> --}}

                    {{-- <p class="small mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:+919999999999" class="text-white text-decoration-none">
                            +91 99999 99999
                        </a>
                    </p> --}}

                    <p class="small mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:support@vatahari.in" class="text-white text-decoration-none">
                            support@vatahari.in
                        </a>
                    </p>

                    <p class="small">
                        <i class="bi bi-geo-alt me-2"></i>
                        Indore, Madhya Pradesh, India
                    </p>
                </div>

                {{-- <!-- Quick Links -->
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-secondary text-decoration-none">Home</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">Shop</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">About Us</a></li>
                        <li><a href="#" class="text-secondary text-decoration-none">Contact</a></li>
                    </ul>
                </div> --}}

            </div>

            <hr class="border-secondary my-4">

            <div class="text-center pb-4">
                <p class="text-secondary small mb-0">
                    © 2026 Vatahari Ayurveda. All Rights Reserved.
                </p>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var swiper = new Swiper('.myShortsSwiper', {
                slidesPerView: 2,
                spaceBetween: 15,
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                breakpoints: {
                    750: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    990: {
                        slidesPerView: 5,
                        spaceBetween: 25
                    }
                }
            });
        });
    </script>
</body>

</html>
