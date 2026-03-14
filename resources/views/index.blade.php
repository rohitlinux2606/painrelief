@extends('layouts.app')

@push('styles')
    <style>
        /* Modern Design System Tokens */
        :root {
            --ayurveda-green: #1a4d2e;
            --ayurveda-light: #f4f7f2;
            --ayurveda-gold: #c5a059;
            --text-muted: #555;
            --transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        /* Section Styling */
        .section-padding {
            padding: 80px 0;
        }

        .section-title-wrapper {
            margin-bottom: 50px;
            text-align: center;
        }

        .section-subtitle {
            color: var(--ayurveda-gold);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.9rem;
            margin-bottom: 10px;
            display: block;
        }

        .section-main-title {
            font-weight: 800;
            font-size: 2.5rem;
            color: #121212;
        }

        /* Ayurvedic Science Section */
        .science-section {
            background: var(--ayurveda-light);
            overflow: hidden;
            position: relative;
        }

        .science-section::before {
            content: "";
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(26, 77, 46, 0.03);
            border-radius: 50%;
            z-index: 0;
        }

        .science-card {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 1;
        }

        .science-image {
            border-radius: 20px;
            box-shadow: 20px 20px 0 var(--ayurveda-green);
            width: 100%;
        }

        /* Benefits Grid */
        .benefit-card {
            text-align: center;
            padding: 35px;
            background: #fff;
            border-radius: 16px;
            border: 1px solid #eee;
            transition: var(--transition);
            height: 100%;
        }

        .benefit-card:hover {
            transform: translateY(-10px);
            border-color: var(--ayurveda-green);
            box-shadow: 0 15px 40px rgba(26, 77, 46, 0.1);
        }

        .benefit-icon {
            width: 70px;
            height: 70px;
            background: var(--ayurveda-light);
            color: var(--ayurveda-green);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 20px;
            font-size: 1.8rem;
            transition: var(--transition);
        }

        .benefit-card:hover .benefit-icon {
            background: var(--ayurveda-green);
            color: #fff;
        }

        .benefit-card h4 {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 15px;
        }

        .benefit-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Ingredients Styles */
        .ingredient-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            background: #000;
            height: 350px;
            cursor: pointer;
        }

        .ingredient-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.7;
            transition: var(--transition);
        }

        .ingredient-card:hover .ingredient-img {
            transform: scale(1.1);
            opacity: 0.5;
        }

        .ingredient-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 30px;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.9), transparent);
            color: #fff;
        }

        .ingredient-name {
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .ingredient-desc {
            font-size: 0.85rem;
            opacity: 0;
            transform: translateY(20px);
            transition: var(--transition);
        }

        .ingredient-card:hover .ingredient-desc {
            opacity: 1;
            transform: translateY(0);
        }

        /* Usage & Trust Section */
        .trust-section {
            background: var(--ayurveda-green);
            color: #fff;
        }

        .usage-step {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 30px;
        }

        .step-num {
            width: 40px;
            height: 40px;
            border: 2px solid var(--ayurveda-gold);
            color: var(--ayurveda-gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            flex-shrink: 0;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 15px;
            background: rgba(255, 255, 255, 0.05);
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 15px;
            transition: var(--transition);
        }

        .trust-badge:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: scale(1.02);
        }

        .trust-badge i {
            font-size: 2rem;
            color: var(--ayurveda-gold);
        }

        /* Ideal For Chips */
        .target-chip {
            display: inline-block;
            padding: 12px 25px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 50px;
            margin: 8px;
            font-weight: 600;
            color: #333;
            transition: var(--transition);
        }

        .target-chip:hover {
            background: var(--ayurveda-green);
            color: #fff;
            border-color: var(--ayurveda-green);
        }

        .max-width-700 {
            max-width: 700px;
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

        @media (max-width: 768px) {
            .section-main-title {
                font-size: 2rem;
            }

            .science-card {
                padding: 30px;
            }

            .science-image {
                margin-top: 30px;
                box-shadow: 10px 10px 0 var(--ayurveda-green);
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Banner -->
    <section class="banner-section">
        <img src="{{ asset('banner/meesho.webp') }}" alt="Joint Pain Relief Banner">
    </section>

    <!-- Featured Products Section -->
    <section class="container py-5" id="combo-offers">
        <div class="limited-offer-bar">
            ⏰ Limited Time Offer – <span class="time" id="offerTimer">01:00:00</span> Left
        </div>

        <h2 class="h1 fw-bold mb-5">Featured Products</h2>
        <div class="row g-4">
            @forelse ($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card">
                        {{-- <a href="{{ route('product-detail', $product->id) }}" class="text-decoration-none">
                            <div class="product-img-container">
                                <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}">
                            </div>
                            <h4 class="product-title text-center">{{ $product->title }}</h4>
                        </a> --}}
                        <a href="#" class="text-decoration-none">
                            <div class="product-img-container">
                                <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->title }}">
                            </div>
                            <h4 class="product-title text-center">{{ $product->title }}</h4>
                        </a>
                        <div class="price-wrapper my-2">
                            <span class="price-sale">₹{{ number_format($product->price, 2) }}</span>
                            @if ($product->compare_at_price)
                                <span class="price-old">₹{{ number_format($product->compare_at_price, 2) }}</span>
                            @endif
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <a href="{{ $product->external_link }}" class="btn-custom btn-atc" onclick="buyNowEvent()">Buy
                                Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">No products found.</div>
            @endforelse
        </div>
    </section>

    <!-- Ayurvedic Science Section -->
    <section class="science-section section-padding">
        <div class="container">
            <div class="row align-items-center">
                {{-- <div class="col-lg-6">
                    <div class="science-card">
                        <span class="section-subtitle">Ancient Wisdom Meets Modern Life</span>
                        <h2 class="section-main-title mb-4">The Science of Vata Balance</h2>
                        <p class="lead text-muted mb-4">Vatahari Vati is a traditional Ayurvedic formulation designed to
                            support healthy joints, muscles, and nerves.</p>
                        <p class="text-muted">Enriched with carefully selected herbs, it helps balance <strong>Vata
                                dosha</strong>—the root cause of stiffness, pain, and weakness in the body. When Vata is
                            balanced, mobility becomes effortless and life becomes pain-free.</p>
                        <div class="mt-4">
                            <a href="#combo-offers" class="btn btn-dark btn-lg px-4" style="border-radius: 50px;">Explore
                                Offers</a>
                        </div>
                    </div>
                </div> --}}
                <div class="col-lg-12">
                    <img src="{{ asset('cdn/002.png') }}" alt="Natural Ayurveda" class="science-image">
                </div>
            </div>
        </div>
    </section>

    {{-- <!-- Key Benefits Section -->
    <section class="section-padding">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="section-subtitle">Why Vatahari Vati?</span>
                <h2 class="section-main-title">Proven Natural Benefits</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="bi bi-shield-check"></i></div>
                        <h4>Joint Health Improvement </h4>
                        <p>Provides deep relief from chronic joint pain, stiffness, and inflammatory swelling.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="bi bi-activity"></i></div>
                        <h4>Effortless Mobility</h4>
                        <p>Supports healthy mobility and flexibility, allowing you to move freely without discomfort.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="bi bi-lightning-charge"></i></div>
                        <h4>Nerve Support</h4>
                        <p>Helps reduce muscle cramps, back pain, and debilitating sciatica symptoms effectively.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="bi bi-award"></i></div>
                        <h4>Full Strength</h4>
                        <p>Strengthens bones, muscles, and the nervous system from within for long-term health.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon"><i class="bi bi-peace"></i></div>
                        <h4>Vata Balance</h4>
                        <p>Promotes overall Vata balance—the root cause of ortho issues—for lasting comfort.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Potent Ingredients Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="section-subtitle">The Power of Nature</span>
                <h2 class="section-main-title">Potent Ayurvedic Ingredients</h2>
                <p class="text-muted mt-3">A precise blend of herbs chosen for their anti-inflammatory & pain-relieving
                    properties.</p>
            </div>
            <div class="row g-4">
                <!-- Row 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/ashwagandha.png') }}" alt="Ashwagandha" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Ashwagandha</div>
                            <div class="ingredient-desc">Known for reducing inflammation and strengthening the nervous
                                system.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/rasna.png') }}" alt="Rasna" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Rasna</div>
                            <div class="ingredient-desc">Possesses anti-inflammatory properties, making it an ideal herb for
                                joint health.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/eranda.png') }}" alt="Eranda" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Eranda</div>
                            <div class="ingredient-desc">Powerful Vata-pacifying herb that helps reduce numbness and
                                swelling.</div>
                        </div>
                    </div>
                </div>
                <!-- Row 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/suranjan.png') }}" alt="Sweet Suranjan Soumya"
                            class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Sweet Suranjan</div>
                            <div class="ingredient-desc">Highly effective in relieving joint pain, inflammation, and
                                symptoms of arthritis.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/shankha.png') }}" alt="Shankha Bhasma" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Shankha Bhasma</div>
                            <div class="ingredient-desc">A natural, pure source of calcium that strengthens bones and
                                reduces acidity.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/godanti.png') }}" alt="Godanti Bhasma" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Godanti Bhasma</div>
                            <div class="ingredient-desc">Provides essential calcium for bone density and helps relieve
                                chronic bodily weakness.</div>
                        </div>
                    </div>
                </div>
                <!-- Row 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/mocharas.png') }}" alt="Mocharas" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Mocharas</div>
                            <div class="ingredient-desc">Strengthens muscles and connective tissues, promoting better joint
                                stability.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/aruga.png') }}" alt="Aruga" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Aruga</div>
                            <div class="ingredient-desc">An excellent natural remedy for stubborn musculoskeletal pain and
                                swelling.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="ingredient-card">
                        <img src="{{ asset('ingredients/yograj.png') }}" alt="Yograj Guggulu" class="ingredient-img">
                        <div class="ingredient-overlay">
                            <div class="ingredient-name">Yograj Guggulu</div>
                            <div class="ingredient-desc">A classical Ayurvedic blend that detoxifies joints and beautifully
                                pacifies Vata dosha.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Usage & Trust Section -->
    <section class="section-padding trust-section">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6">
                    <h2 class="section-main-title text-white mb-5">How to Use & Dosage</h2>
                    <div class="usage-step">
                        <div class="step-num">01</div>
                        <div>
                            <h5 class="fw-bold">Twice Daily</h5>
                            <p class="opacity-75">Take 1–2 tablets in the morning and evening for consistent relief.</p>
                        </div>
                    </div>
                    <div class="usage-step">
                        <div class="step-num">02</div>
                        <div>
                            <h5 class="fw-bold">Lukewarm Water</h5>
                            <p class="opacity-75">Consume with lukewarm water as it helps in better absorption of herbs.
                            </p>
                        </div>
                    </div>
                    <div class="usage-step">
                        <div class="step-num">03</div>
                        <div>
                            <h5 class="fw-bold">Consistency is Key</h5>
                            <p class="opacity-75">Best results are seen with regular use along with a balanced diet &
                                lifestyle.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="section-main-title text-white mb-5">Built on Trust</h2>
                    <div class="trust-badge">
                        <i class="bi bi-check2-circle"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Ayurvedic Formulation</h6>
                            <p class="small mb-0 opacity-75">Pure herbal extracts without harmful additives.</p>
                        </div>
                    </div>
                    <div class="trust-badge">
                        <i class="bi bi-slash-circle"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Free from Chemicals</h6>
                            <p class="small mb-0 opacity-75">No steroids or artificial fillers used.</p>
                        </div>
                    </div>
                    <div class="trust-badge">
                        <i class="bi bi-heart-pulse"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Safe for Long-term Use</h6>
                            <p class="small mb-0 opacity-75">Natural healing that works with your body.</p>
                        </div>
                    </div>
                    <div class="trust-badge">
                        <i class="bi bi-people"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Practitioner Trusted</h6>
                            <p class="small mb-0 opacity-75">Highly recommended by Ayurvedic experts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    {{-- <!-- Ideal For Section -->
    <section class="section-padding text-center">
        <div class="container">
            <div class="section-title-wrapper">
                <span class="section-subtitle">Who is this for?</span>
                <h2 class="section-main-title">Ideal for Daily Relief</h2>
            </div>
            <div class="max-width-700 mx-auto">
                <span class="target-chip">Arthritis Relief</span>
                <span class="target-chip">Back Pain Support</span>
                <span class="target-chip">Sciatica Comfort</span>
                <span class="target-chip">Age-related Stiffness</span>
                <span class="target-chip">Post-injury Recovery</span>
                <span class="target-chip">Muscle Strength</span>
            </div>
            <p class="mt-5 text-muted lead">Vatahari Vati is your natural companion for active living.</p>
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
                                            src="https://www.youtube.com/embed/{{ $video->getYoutubeId() }}?autoplay=0&mute=0&loop=1&playlist={{ $video->getYoutubeId() }}"
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
    @endif --}}
@endsection

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

            let oneHour = 60 * 60;
            let display = document.querySelector('#offerTimer');
            if (display) startCountdown(oneHour, display);
        });
    </script>
@endpush
