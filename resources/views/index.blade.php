@extends('layouts.web')

@section('content')
    <section class="banner-section">
        <img src="{{ asset('banner/flipkart.jpeg') }}" alt="Joint Pain Relief Banner">
    </section>

    <section class="container py-5">

        <div class="limited-offer-bar">
            ⏰ Limited Time Offer – <span class="time" id="offerTimer">01:00:00</span> Left
        </div>

        <h2 class="h1 fw-bold mb-5">Featured Products by Sanjeevani Ortho Lab</h2>
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
                            <a href="{{ route('add-to-cart', $product->id) }}" class="btn-custom btn-atc"
                                onclick="addToCartEvent()">Add To Cart</a>

                            {{-- <a href="{{ $product->external_link }}" class="btn-custom btn-atc">Add & Checkout</a> --}}
                            <a href="{{ route('buy-now', $product->id) }}" class="btn-custom btn-buy"
                                onclick="buyNowEvent()">Buy Now</a>
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
            @foreach ($products as $product)
                @php
                    // Map loop index to original static designs
                    $isMostPopular = $loop->index == 1;
                    $badge = null;
                    $badgeClass = '';
                    $description = $product->short_description;

                    if ($loop->index == 0) {
                        $badge = 'Trial Pack';
                        $badgeClass = 'bg-secondary';
                    } elseif ($loop->index == 1) {
                        $badge = 'Most Popular';
                        $badgeClass = 'bg-success';
                    } elseif ($loop->index == 2) {
                        $badge = 'Best Value';
                        $badgeClass = 'bg-warning text-dark';
                    } elseif ($loop->index == 3) {
                        $badge = 'Maximum Savings';
                        $badgeClass = 'bg-danger';
                    }
                @endphp

                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card h-100 {{ $isMostPopular ? 'shadow border-2 border-success' : 'shadow-sm border-0' }}">
                        <div class="card-body text-center position-relative">
                            @if ($badge)
                                @if ($isMostPopular)
                                    <span
                                        class="badge {{ $badgeClass }} position-absolute top-0 start-50 translate-middle">{{ $badge }}</span>
                                @else
                                    <span class="badge {{ $badgeClass }} mb-2">{{ $badge }}</span>
                                @endif
                            @endif

                            <h5 class="fw-bold {{ $isMostPopular ? 'mt-3' : '' }}">{{ $product->title }}</h5>
                            <p class="text-muted small">{{ $description ?? 'Quality Care Product' }}</p>

                            <div class="my-3">
                                @if ($product->compare_at_price)
                                    <span
                                        class="text-decoration-line-through text-muted">₹{{ number_format($product->compare_at_price, 0) }}</span>
                                @endif
                                <span class="fs-3 fw-bold ms-2">₹{{ number_format($product->price, 0) }}</span>
                            </div>

                            @if ($product->compare_at_price && $product->compare_at_price > $product->price)
                                <p class="{{ $isMostPopular ? 'text-success' : 'text-danger' }} fw-bold small">
                                    You Save ₹{{ number_format($product->compare_at_price - $product->price, 0) }}
                                </p>
                            @endif

                            @php
                                // Attempt to calculate "Per product" if it's a pack
preg_match('/Pack of (\d+)/i', $product->title, $matches);
                                $packCount = isset($matches[1]) ? (int) $matches[1] : 1;
                            @endphp

                            @if ($packCount > 1)
                                <p class="small text-muted">(Per product:
                                    ₹{{ number_format($product->price / $packCount, 0) }})</p>
                            @endif

                            <div class="d-grid mt-3">
                                <a href="{{ route('buy-now', $product->id) }}" class="btn btn-dark"
                                    onclick="buyNowEvent()">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
@endsection

@push('styles')
    <style>
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


        .limited-offer-bar {
            background: #fff;
            color: #000;
            border: 2px solid #000;
            text-align: center;
            padding: 16px 20px;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.5px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .limited-offer-bar .time {
            font-weight: 900;
        }
    </style>
@endpush

@push('scripts')
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
            startCountdown(oneHour, display);
        });
    </script>
@endpush
