<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vatahari – Natural Ortho Care Solutions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '774268225654141');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=774268225654141&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->
    <style>
        :root {
            --primary-green: #1a4d2e;
            --accent-green: #28a745;
            --text-dark: #121212;
            --font-main: 'Assistant', sans-serif;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-dark);
            overflow-x: hidden;
            background-color: #f9f9f9;
        }

        /* Announcement Bar */
        .announcement-bar {
            background: #fff;
            color: #000;
            font-size: 14px;
            font-weight: 600;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            text-transform: uppercase;
        }

        /* Navbar Styling */
        .navbar {
            padding: 15px 0;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 28px;
            color: #000 !important;
            letter-spacing: 1px;
        }

        /* Hero Banner */
        .hero-banner img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Question Section */
        .question-section {
            background: #fff;
            padding: 60px 0;
            text-align: center;
        }

        .question-title {
            color: #d32f2f;
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 30px;
        }

        .bottles-img {
            max-width: 600px;
            width: 100%;
            height: auto;
        }

        /* Trusted Solutions Green Bar */
        .trusted-bar {
            background: #1a8a44;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            font-weight: 700;
            font-size: 1.2rem;
            font-style: italic;
        }

        /* Certification Section */
        .cert-section {
            background: #fff;
            padding: 30px 0;
            border-bottom: 1px dashed #ccc;
        }

        .cert-img {
            max-width: 100%;
            height: auto;
        }

        /* Discount Bar */
        .discount-bar {
            background: #1a8a44;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            font-weight: 900;
            font-size: 2rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        /* Timer Bar */
        .timer-bar {
            background: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .timer-title {
            font-weight: 800;
            font-size: 1.8rem;
            text-transform: uppercase;
        }

        .timer-display {
            font-weight: 900;
        }

        /* Product Cards */
        .product-card {
            border: 1px solid #eee;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            transition: box-shadow 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .product-img-wrapper {
            aspect-ratio: 1/1;
            overflow: hidden;
            margin-bottom: 15px;
        }

        .product-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .product-name {
            font-weight: 700;
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 10px;
            height: 45px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .price-curr {
            font-weight: 800;
            font-size: 1.4rem;
            color: #000;
        }

        .price-orig {
            text-decoration: line-through;
            color: #888;
            font-size: 1rem;
            margin-left: 8px;
        }

        .btn-atc {
            border: 1px solid #000;
            color: #000;
            background: #fff;
            font-weight: 700;
            padding: 10px;
            margin-bottom: 10px;
            transition: 0.3s;
        }

        .btn-atc:hover {
            background: #f8f9fa;
        }

        .btn-buy {
            background: #000;
            color: #fff;
            font-weight: 700;
            padding: 10px;
            transition: 0.3s;
        }

        .btn-buy:hover {
            background: #333;
        }

        /* Sections Headings */
        .section-heading {
            background: #1a8a44;
            color: #fff;
            padding: 15px 0;
            text-align: center;
            font-weight: 800;
            font-size: 2rem;
            text-transform: uppercase;
            margin-bottom: 40px;
        }

        /* Shorts Section */
        .shorts-section {
            padding: 60px 0;
        }

        .shorts-card {
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .video-wrapper {
            position: relative;
            padding-top: 177.77%;
            background: #000;
        }

        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* Order Now CTA */
        .order-now-section {
            padding: 60px 0;
            text-align: center;
            background: #fff;
        }

        .click-here-text {
            font-weight: 900;
            font-size: 2.5rem;
            text-transform: uppercase;
            display: inline-block;
            vertical-align: middle;
            margin: 0 20px;
        }

        .order-now-badge {
            max-width: 200px;
            cursor: pointer;
            transition: transform 0.3s;
        }

        .order-now-badge:hover {
            transform: scale(1.1);
        }

        /* Footer */
        footer {
            background: #1a1a1a;
            color: #fff;
            padding: 60px 0 20px;
        }

        footer h4 {
            font-weight: 800;
            margin-bottom: 20px;
        }

        footer a {
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }

        footer a:hover {
            color: #fff;
        }

        /* Floating Buttons */
        .whatsapp-float {
            position: fixed;
            bottom: 100px;
            right: 25px;
            background: #25D366;
            color: #fff;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 600;
            z-index: 1000;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        .support-float {
            position: fixed;
            bottom: 30px;
            right: 25px;
            background: #000;
            color: #fff;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: 600;
            z-index: 1000;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        @media (max-width: 768px) {
            .question-title {
                font-size: 1.8rem;
            }

            .discount-bar {
                font-size: 1.4rem;
            }

            .timer-title {
                font-size: 1.3rem;
            }

            .click-here-text {
                font-size: 1.5rem;
                margin: 10px;
            }

            .order-now-badge {
                max-width: 140px;
            }

            .float-text {
                display: none;
            }

            .whatsapp-float,
            .support-float {
                width: 55px;
                height: 55px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                right: 15px;
            }

            .whatsapp-float {
                bottom: 85px;
            }

            .support-float {
                bottom: 20px;
            }

            .whatsapp-float i,
            .support-float i {
                margin: 0 !important;
                font-size: 1.5rem !important;
            }
        }
    </style>
</head>

<body>

    {{-- <div class="announcement-bar text-center">
        WELCOME TO OUR STORE
    </div> --}}

    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="/">VATAHARI</a>
            <div class="ms-auto d-flex align-items-center gap-3">
                <i class="bi bi-search fs-5"></i>
                <i class="bi bi-person fs-5"></i>
            </div>
        </div>
    </nav>

    <section class="hero-banner">
        <img src="{{ asset('assets/images/landingpage/banner.jpeg') }}" alt="Vatahari Relief" class="img-fluid">
    </section>

    <section class="question-section">
        <div class="container">
            <h1 class="question-title">
                <span class="text-danger" style="font-size: 2rem !important">पुराने से पुराने</span> <br>
                <span class="text-black" style="font-size: 2.5rem !important">
                    जोड़ों के दर्द से परेशान हैं ?
                </span>
            </h1>
            <img src="{{ asset('assets/images/landingpage/3-bottles.png') }}" alt="Vatahari Bottles"
                class="bottles-img px-5">
        </div>
    </section>

    <div class="trusted-bar">
        “हजारों लोगों का भरोसेमंद आयुर्वेदिक समाधान”
    </div>

    <section class="cert-section">
        <div class="container text-center">
            <img src="{{ asset('assets/images/landingpage/certification.png') }}" alt="Certifications" class="cert-img">
        </div>
    </section>

    <div class="discount-bar">
        GET EXTRA 15% DISCOUNT
    </div>

    <section class="timer-bar">
        <div class="container">
            <h2 class="timer-title">LIMITED TIME OFFER - <span class="timer-display text-danger"
                    id="offerTimer">00:00:00</span></h2>
        </div>
    </section>

    <section class="container py-5">
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card text-center">
                        <a href="{{ route('product-detail', $product->id) }}" class="text-decoration-none">
                            <div class="product-img-wrapper">
                                <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}">
                            </div>
                            <h4 class="product-name text-center">{{ $product->title }}</h4>
                        </a>
                        <div class="mb-3">
                            <span class="price-curr">₹{{ number_format($product->price, 2) }}</span>
                            @if ($product->compare_at_price)
                                <span class="price-orig">₹{{ number_format($product->compare_at_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-grid gap-2">
                            <a href="{{ $product->external_link }}" class="btn btn-atc">ADD & CHECKOUT</a>
                            <a href="{{ $product->external_link }}" target="_blank" class="btn btn-buy"
                                onclick="fbq('track', 'AddToCart')">BUY NOW</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">No products available.</div>
            @endforelse
        </div>
    </section>

    @if (!empty($videos) && count($videos) > 0)
        <div class="section-heading">
            Customer's Feedback
        </div>

        <section class="shorts-section bg-light">
            <div class="container">
                <div class="row g-3">
                    @foreach ($videos as $video)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="shorts-card">
                                <div class="video-wrapper">
                                    <iframe
                                        src="https://www.youtube.com/embed/{{ $video->getYoutubeId() }}?autoplay=0&mute=1&loop=1&playlist={{ $video->getYoutubeId() }}"
                                        loading="lazy" frameborder="0" allow="autoplay; encrypted-media"
                                        allowfullscreen>
                                    </iframe>
                                </div>
                                <a href="{{ route('product-detail', $video->product->id) }}"
                                    class="p-3 d-flex align-items-center gap-3 text-decoration-none border-top">
                                    <img src="{{ asset($video->product->thumbnail) }}" width="45" height="45"
                                        style="border-radius:5px; object-fit:cover;">
                                    <div class="overflow-hidden">
                                        <h6 class="mb-0 text-dark fw-bold text-truncate">
                                            {{ $video->product->title }}</h6>
                                        <small
                                            class="text-muted">₹{{ number_format($video->product->price, 2) }}</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="order-now-section">
        <div class="container">
            <span class="click-here-text">CLICK HERE</span>
            <a href="#products">
                <img src="{{ asset('assets/images/landingpage/order-btn.png') }}" alt="Order Now"
                    class="order-now-badge">
            </a>
            <span class="click-here-text">CLICK HERE</span>
        </div>
    </section>

    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-8">
                    <h4 class="fw-bold">VATAHARI</h4>
                    <p class="text-secondary">Natural Ortho Care Solutions for Better Life. Dedicated to providing
                        authentic Ayurvedic solutions for joint and muscle pain relief.</p>
                </div>
                <div class="col-md-4">
                    <h5 class="fw-bold mb-4">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-telephone me-3"></i><a href="tel:+919691905073">+91 96919
                                05073</a></li>
                        <li class="mb-2"><i class="bi bi-envelope me-3"></i><a
                                href="mailto:orthosanjeevanilab@gmail.com">orthosanjeevanilab@gmail.com</a></li>
                        <li class="mb-2"><i class="bi bi-geo-alt me-3"></i>Indore, Madhya Pradesh, India</li>
                    </ul>
                </div>
            </div>
            <hr class="border-secondary mt-5 mb-4">
            <p class="text-center text-secondary small mb-0">© 2026 Vatahari Ayurveda. All Rights Reserved.</p>
        </div>
    </footer>

    <a href="https://chat.whatsapp.com/IleJbXZJJLzI8nKSa7iXOD" class="whatsapp-float" target="_blank">
        <i class="bi bi-whatsapp fs-4"></i> <span class="float-text ms-2">Join Community</span>
    </a>

    <a href="tel:+919691905073" class="support-float">
        <i class="bi bi-headset fs-4"></i> <span class="float-text ms-2">Customer Support</span>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Timer Logic
            let time = 3600; // 1 hour
            setInterval(() => {
                let h = Math.floor(time / 3600);
                let m = Math.floor((time % 3600) / 60);
                let s = time % 60;
                document.getElementById('offerTimer').innerText =
                    (h < 10 ? '0' : '') + h + ":" + (m < 10 ? '0' : '') + m + ":" + (s < 10 ? '0' : '') + s;
                if (time > 0) time--;
            }, 1000);
        });
    </script>
</body>

</html>
