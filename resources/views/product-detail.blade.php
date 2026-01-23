<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vatahari Vati - Product Detail Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

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
        body {
            font-family: 'Assistant', sans-serif;
            color: #121212;
            line-height: 1.6;
        }

        .announcement-bar {
            background-color: #f3f3f3;
            font-size: 13px;
            padding: 8px 0;
            text-align: center;
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: 500;
            letter-spacing: 1px;
        }

        /* Shopify Style Slider CSS */
        .product-image-container {
            position: sticky;
            top: 20px;
        }

        .carousel-item img {
            background-color: #f8f9fa;
            border-radius: 4px;
            width: 100%;
            height: auto;
        }

        .thumbnail-container {
            display: flex;
            gap: 10px;
            margin-top: 15px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .thumb-link {
            width: 80px;
            height: 80px;
            border: 1px solid #eee;
            cursor: pointer;
            flex-shrink: 0;
        }

        .thumb-link.active {
            border-color: #121212;
            border-width: 2px;
        }

        .thumb-link img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Product Details CSS */
        .product-title {
            font-size: 32px;
            font-weight: 400;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .price-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
        }

        .price-old {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 18px;
        }

        .price-current {
            font-size: 22px;
            font-weight: 500;
        }

        .badge-sale {
            background-color: #121212;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        /* Action Anchors styled as Buttons */
        .btn-add-to-cart {
            border: 1px solid #121212;
            background: white;
            color: #121212 !important;
            padding: 12px;
            width: 100%;
            font-weight: 500;
            margin-bottom: 12px;
            text-decoration: none;
            text-align: center;
            display: inline-block;
            transition: 0.3s;
        }

        .btn-add-to-cart:hover {
            background-color: #f8f9fa;
        }

        .btn-buy-now {
            background-color: #000000;
            color: white !important;
            padding: 10px 14px;
            width: 100%;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: none;
            transition: 0.3s;
        }

        .btn-buy-now:hover {
            opacity: 0.9;
        }

        .buy-now-subtext {
            font-size: 9px;
            opacity: 0.8;
            margin-top: 2px;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .offer-box {
            border: 1px dashed #28a745;
            background-color: #fafffa;
            padding: 12px;
            border-radius: 4px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .offer-highlight {
            color: #dc3545;
            font-weight: bold;
        }

        .content-section {
            margin-top: 25px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .section-title {
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .benefit-list {
            list-style: none;
            padding-left: 0;
        }

        .benefit-list li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .benefit-list li::before {
            content: "•";
            position: absolute;
            left: 5px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="announcement-bar">Welcome to our store</div>

    <nav class="navbar navbar-light bg-white py-3 border-bottom">
        <div class="container text-center">
            <a class="navbar-brand mx-auto" href="{{ route('page.home') }}">VATAHARI</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row g-5">
            <div class="col-md-7">
                <div class="product-image-container">
                    <div id="productCarousel" class="carousel slide" data-bs-ride="false">
                        <div class="carousel-inner">
                            @foreach ($product->images as $key => $img)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset($img->image_path) }}" class="d-block w-100" alt="Product Image">
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle" aria-hidden="true"></span>
                        </button>
                    </div>

                    <div class="thumbnail-container">
                        @foreach ($product->images as $key => $img)
                            <div class="thumb-link {{ $key == 0 ? 'active' : '' }}" data-bs-target="#productCarousel"
                                data-bs-slide-to="{{ $key }}">
                                <img src="{{ asset($img->image_path) }}" alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb small text-uppercase" style="letter-spacing: 1px; color: #6c757d;">
                        <li class="breadcrumb-item">Vatahari Vati</li>
                        <li class="breadcrumb-item active">Natural Joint Relief</li>
                    </ol>
                </nav>

                <h1 class="product-title">{{ $product->title }}</h1>

                <div class="price-wrapper">
                    <span class="price-old">Rs.{{ $product->compare_at_price }}</span>
                    <span class="price-current">Rs.{{ $product->price }}</span>
                    <span class="badge badge-sale">Sale</span>
                </div>

                {{-- <a href="{{ route('add-to-cart', $product->id) }}" class="btn-add-to-cart"
                    onclick="addToCartEvent()">Add to cart</a> --}}

                <a href="{{ $product->external_link }}" class="btn-add-to-cart" onclick="addToCartEvent()">Add to
                    cart</a>

                <a href="{{ $product->external_link }}" class="btn-buy-now" target="_blank" onclick="buyNowEvent()">
                    <span>BUY NOW</span>
                    <div class="buy-now-subtext">
                        <img src="" alt="" style="height: 12px; filter: brightness(0) invert(1);">
                        {{-- <span style="font-size: 8px;">& more Powered by</span>
                        <strong style="font-size: 8px;">Shiprocket</strong> --}}
                    </div>
                </a>

                <div class="offer-box">
                    <span>⚡</span>
                    <p class="mb-0" style="color: #1a5928; font-size: 14px; font-weight: 500;">
                        Limited Offer: Buy now and get <span
                            class="offer-highlight">{{ $product->discount_percentage }}% OFF</span>
                    </p>
                </div>

                <div class="mt-4">
                    <p class="text-muted small">
                        <strong>Vatahari Vati</strong> is a traditional Ayurvedic formulation designed to support
                        healthy joints, muscles, and nerves. Enriched with carefully selected herbs, it helps balance
                        Vata dosha—the root cause of stiffness, pain, and weakness in the body.
                    </p>
                </div>

                <div class="content-section">
                    <div class="section-title text-success">✅ Key Benefits</div>
                    <ul class="benefit-list text-muted">
                        <li>Provides relief from <strong>joint pain, stiffness, and swelling</strong></li>
                        <li>Supports <strong>healthy mobility and flexibility</strong></li>
                        <li>Helps reduce <strong>muscle cramps, back pain, and sciatica symptoms</strong></li>
                        <li>Strengthens bones, muscles, and nervous system</li>
                        <li>Promotes overall <strong>Vata balance</strong> for long-term comfort</li>
                    </ul>
                </div>

                <div class="content-section">
                    <div class="section-title">🌱 Ingredients</div>
                    <div class="info-card bg-light p-3 rounded small text-muted">
                        Vatahari Vati is made with a blend of potent Ayurvedic herbs (e.g., <strong>Ashwagandha, Rasna,
                            Eranda</strong>). Each herb is carefully chosen for its anti-inflammatory, pain-relieving,
                        and strengthening properties.
                    </div>
                </div>

                <div class="content-section">
                    <div class="section-title">🧾 How to Use</div>
                    <p class="small text-muted mb-1">Take <strong>1–2 tablets twice daily</strong> with lukewarm water
                        or as directed by your physician.</p>
                    <p class="small text-muted"><em>Best results are seen with regular use along with a balanced diet &
                            lifestyle.</em></p>
                </div>

                <div class="content-section">
                    <div class="section-title">⚡ Why Choose Vatahari Vati?</div>
                    <ul class="benefit-list text-muted small">
                        <li>100% Ayurvedic formulation</li>
                        <li>Free from harmful chemicals</li>
                        <li>Safe for long-term use</li>
                        <li>Trusted by Ayurvedic practitioners</li>
                    </ul>
                </div>

                <div class="mt-4 p-3 border-start border-3 border-dark bg-light small">
                    👉 Ideal for those suffering from <strong>arthritis, back pain, sciatica, or age-related
                        stiffness</strong>, Vatahari Vati is your natural companion for active living.
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Thumbnail click update
        const thumbs = document.querySelectorAll('.thumb-link');
        thumbs.forEach(thumb => {
            thumb.addEventListener('click', function() {
                thumbs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        fbq('track', 'ViewContent', {
            content_name: 'Vatahari Vati',
            content_type: 'product'
        });
    </script>

    <script src="{{ asset('meta/pixel.js') }}"></script>
</body>

</html>
