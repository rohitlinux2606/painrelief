<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sanjeevani Ortho Lab – Home of Vatahari Ayurveda')</title>
    <meta name="facebook-domain-verification" content="4n5jhw95om6losg50kplq68f3n0axz" />

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
            --text-dark: #121212;
            --font-main: 'Assistant', sans-serif;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-dark);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        /* WhatsApp Float Button */
        .whatsapp-float {
            position: fixed;
            bottom: 110px;
            right: 25px;
            background: #25D366;
            color: #fff;
            border-radius: 50px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            z-index: 9999;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        /* Support Float Button */
        .support-float {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #000;
            color: #fff;
            border-radius: 50px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            z-index: 9999;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .whatsapp-float:hover {
            background: #1ebe5d;
            color: #fff;
            transform: scale(1.05);
        }

        .support-float:hover {
            background: #333;
            color: #fff;
            transform: scale(1.05);
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            .float-text {
                display: none;
            }

            .whatsapp-float,
            .support-float {
                padding: 0;
                width: 55px;
                height: 55px;
                justify-content: center;
                border-radius: 50%;
                right: 15px;
            }

            .whatsapp-float {
                bottom: 90px;
            }

            .support-float {
                bottom: 20px;
            }

            .whatsapp-float i,
            .support-float i {
                font-size: 1.6rem !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>

    <a href="https://chat.whatsapp.com/IleJbXZJJLzI8nKSa7iXOD" class="whatsapp-float" target="_blank">
        <i class="bi bi-whatsapp fs-4"></i>
        <span class="float-text">Join Community</span>
    </a>

    <a href="tel:+919691905073" class="support-float">
        <i class="bi bi-headset fs-4"></i>
        <span class="float-text">Customer Support</span>
    </a>

    @if (!request()->is('checkout'))
        <div class="announcement-bar text-center">
            WELCOME TO OUR STORE
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand" href="{{ route('page.home') }}">SANJEEVANI ORTHO LAB</a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navMenu">
                    <i class="bi bi-list fs-1"></i>
                </button>

                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('page.home') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('page.about') }}">About Us</a></li>
                        <li class="nav-item"><a class="nav-link px-3" href="{{ route('page.contact') }}">Contact Us</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center gap-4">
                        {{-- <i class="bi bi-search fs-5" style="cursor:pointer"></i>
                    <i class="bi bi-person fs-5" style="cursor:pointer"></i> --}}
                        <div class="position-relative">
                            <a href="{{ route('show-cart') }}" class="text-black"><i class="bi bi-bag fs-5"
                                    style="cursor:pointer"></i></a>
                            {{-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark"
                            style="font-size: 9px;">0</span> --}}
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    @else
        <nav class="navbar navbar-light bg-white border-bottom py-3">
            <div class="container justify-content-center">
                <a class="navbar-brand" href="{{ route('page.home') }}">SANJEEVANI ORTHO LAB</a>
            </div>
        </nav>
    @endif

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="bg-dark text-white pt-5 mt-auto">
        <div class="container">
            <div class="row g-4">

                <!-- Brand -->
                <div class="col-md-4">
                    <h4 class="fw-bold">SANJEEVANI ORTHO LAB</h4>
                    <p class="text-secondary small"> Natural Ortho Care Solutions for Better Life.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="{{ route('page.home') }}" class="text-secondary text-decoration-none">Home</a></li>
                        <li><a href="{{ route('page.about') }}" class="text-secondary text-decoration-none">About Us</a>
                        </li>
                        <li><a href="{{ route('page.contact') }}" class="text-secondary text-decoration-none">Contact
                                Us</a></li>
                        <li><a href="{{ route('page.privacy') }}" class="text-secondary text-decoration-none">Privacy
                                Policy</a></li>
                        {{-- <li><a href="{{ route('page.terms') }}" class="text-secondary text-decoration-none">Terms and
                                Conditions</a></li>
                        <li><a href="{{ route('page.refund') }}" class="text-secondary text-decoration-none">Refund
                                Policy</a></li>
                        <li><a href="{{ route('page.return') }}" class="text-secondary text-decoration-none">Return
                                Policy</a></li> --}}
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-md-4">
                    <h5 class="fw-bold mb-3">Contact Us</h5>

                    {{-- <p class="small mb-2">
                        <i class="bi bi-person me-2"></i> Rohit Kumar
                    </p> --}}

                    <p class="small mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        <a href="tel:+919691905073" class="text-white text-decoration-none">
                            +91 96919 05073
                        </a>
                    </p>

                    <p class="small mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:info@vatahari.in" class="text-white text-decoration-none">
                            info@vatahari.in
                        </a>
                    </p>

                    <p class="small">
                        <i class="bi bi-geo-alt me-2"></i>
                        Building No./Flat No.: HANUMANT PALACE INDORE, BLOCK-C,<br>
                        Road/Street: 2-A,<br>
                        City/Town/Village: Indore,<br>
                        District: Indore,<br>
                        State: Madhya Pradesh,<br>
                        PIN Code: 452002
                    </p>
                </div>

            </div>

            <hr class="border-secondary my-4">

            <div class="text-center pb-4">
                <p class="text-secondary small mb-0">
                    © 2026 Sanjeevani Ortho Lab. All Rights Reserved. | A Brand by Sanjeevani Ortho Lab
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
