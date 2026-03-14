<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Vatahari'))</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Assistant:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <link rel="shortcut icon" href="{{ asset('fevicon.png') }}" type="image/x-icon">

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
        fbq('init', '1641429127233505');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1641429127233505&ev=PageView&noscript=1" /></noscript>
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
        }

        /* Floating Buttons */
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

        /* Announcement Bar */
        .announcement-bar {
            background: #f8f9fa;
            font-size: 13px;
            letter-spacing: 1px;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            text-align: center;
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
    </style>
    @stack('styles')
</head>

<body>
    <div id="app">
        <a href="https://chat.whatsapp.com/IleJbXZJJLzI8nKSa7iXOD" class="whatsapp-float" target="_blank">
            <i class="bi bi-whatsapp fs-4"></i>
            <span class="float-text">Join Community</span>
        </a>

        <a href="tel:+919691905073" class="support-float">
            <i class="bi bi-headset fs-4"></i>
            <span class="float-text">Customer Support</span>
        </a>

        <div class="announcement-bar">
            WELCOME TO OUR STORE
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand" href="{{ route('page.home') }}">VATAHARI</a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navMenu">
                    <i class="bi bi-list fs-1"></i>
                </button>

                <div class="collapse navbar-collapse" id="navMenu">
                    <ul class="navbar-nav mx-auto"></ul>
                    <div class="d-flex align-items-center gap-4">
                        <i class="bi bi-search fs-5" style="cursor:pointer"></i>
                        <i class="bi bi-person fs-5" style="cursor:pointer"></i>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer class="bg-dark text-white pt-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-8">
                        <h4 class="fw-bold">VATAHARI</h4>
                        <p class="text-secondary small">Natural Ortho Care Solutions for Better Life.</p>
                    </div>
                    <div class="col-md-4">
                        <h5 class="fw-bold mb-3">Contact Us</h5>
                        <p class="small mb-2">
                            <i class="bi bi-telephone me-2"></i>
                            <a href="tel:+919691905073" class="text-white text-decoration-none">+91 96919 05073</a>
                        </p>
                        <p class="small mb-2">
                            <i class="bi bi-envelope me-2"></i>
                            <a href="mailto:orthosanjeevanilab@gmail.com"
                                class="text-white text-decoration-none">orthosanjeevanilab@gmail.com</a>
                        </p>
                        <p class="small">
                            <i class="bi bi-geo-alt me-2"></i> Indore, Madhya Pradesh, India
                        </p>
                    </div>
                </div>
                <hr class="border-secondary my-4">
                <div class="text-center pb-4">
                    <p class="text-secondary small mb-0">© 2026 Vatahari Ayurveda. All Rights Reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- <script src="{{ asset('meta/pixel.js') }}"></script> --}}
    @stack('scripts')
</body>

</html>
