<!doctype html>
<html class="js" lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="">
    <link rel="canonical" href="index.html">
    <link rel="icon" type="image/png"
        href="{{ asset('cdn/shop/files/VATAHARI.png?crop=center&height=32&v=1762950312&width=32') }}">
    <link rel="preconnect" href="https://fonts.shopifycdn.com" crossorigin>
    <title>
        Vatahari – Natural Ortho Care Solutions for Pain Relief &amp; Mobility
    </title>


    <meta name="description"
        content="Strengthen your bones, relieve joint pain, and restore natural movement with Vatahari. Our Ayurvedic ortho products blend traditional herbs with modern wellness for safe, long-lasting relief and improved quality of life.">


    <meta property="og:site_name" content="Vatahari">
    <meta property="og:title" content="Vatahari – Natural Ortho Care Solutions for Pain Relief &amp; Mobility">
    <meta property="og:type" content="website">
    <meta property="og:description"
        content="Strengthen your bones, relieve joint pain, and restore natural movement with Vatahari. Our Ayurvedic ortho products blend traditional herbs with modern wellness for safe, long-lasting relief and improved quality of life.">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Vatahari – Natural Ortho Care Solutions for Pain Relief &amp; Mobility">
    <meta name="twitter:description"
        content="Strengthen your bones, relieve joint pain, and restore natural movement with Vatahari. Our Ayurvedic ortho products blend traditional herbs with modern wellness for safe, long-lasting relief and improved quality of life.">


    <style data-shopify>
        @font-face {
            font-family: Assistant;
            font-weight: 400;
            font-style: normal;
            font-display: swap;
            src: url("{{ asset('cdn/fonts/assistant/assistant_n4.9120912a469cad1cc292572851508ca49d12e768.woff2') }}") format("woff2"),
                url("{{ asset('cdn/fonts/assistant/assistant_n4.6e9875ce64e0fefcd3f4446b7ec9036b3ddd2985.woff') }}") format("woff");
        }

        @font-face {
            font-family: Assistant;
            font-weight: 700;
            font-style: normal;
            font-display: swap;
            src: url("{{ asset('cdn/fonts/assistant/assistant_n7.bf44452348ec8b8efa3aa3068825305886b1c83c.woff2') }}") format("woff2"),
                url("{{ asset('cdn/fonts/assistant/assistant_n7.0c887fee83f6b3bda822f1150b912c72da0f7b64.woff') }}") format("woff");
        }



        @font-face {
            font-family: Assistant;
            font-weight: 400;
            font-style: normal;
            font-display: swap;
            src: url("{{ asset('cdn/fonts/assistant/assistant_n4.9120912a469cad1cc292572851508ca49d12e768.woff2') }}") format("woff2"),
                url("{{ asset('cdn/fonts/assistant/assistant_n4.6e9875ce64e0fefcd3f4446b7ec9036b3ddd2985.woff') }}") format("woff");
        }



        :root,
        .color-scheme-1 {
            --color-background: 255, 255, 255;

            --gradient-background: #ffffff;




            --color-foreground: 18, 18, 18;
            --color-background-contrast: 191, 191, 191;
            --color-shadow: 18, 18, 18;
            --color-button: 18, 18, 18;
            --color-button-text: 255, 255, 255;
            --color-secondary-button: 255, 255, 255;
            --color-secondary-button-text: 18, 18, 18;
            --color-link: 18, 18, 18;
            --color-badge-foreground: 18, 18, 18;
            --color-badge-background: 255, 255, 255;
            --color-badge-border: 18, 18, 18;
            --payment-terms-background-color: rgb(255 255 255);
        }


        .color-scheme-2 {
            --color-background: 243, 243, 243;

            --gradient-background: #f3f3f3;




            --color-foreground: 18, 18, 18;
            --color-background-contrast: 179, 179, 179;
            --color-shadow: 18, 18, 18;
            --color-button: 18, 18, 18;
            --color-button-text: 243, 243, 243;
            --color-secondary-button: 243, 243, 243;
            --color-secondary-button-text: 18, 18, 18;
            --color-link: 18, 18, 18;
            --color-badge-foreground: 18, 18, 18;
            --color-badge-background: 243, 243, 243;
            --color-badge-border: 18, 18, 18;
            --payment-terms-background-color: rgb(243 243 243);
        }


        .color-scheme-3 {
            --color-background: 36, 40, 51;

            --gradient-background: #242833;




            --color-foreground: 255, 255, 255;
            --color-background-contrast: 47, 52, 66;
            --color-shadow: 18, 18, 18;
            --color-button: 255, 255, 255;
            --color-button-text: 0, 0, 0;
            --color-secondary-button: 36, 40, 51;
            --color-secondary-button-text: 255, 255, 255;
            --color-link: 255, 255, 255;
            --color-badge-foreground: 255, 255, 255;
            --color-badge-background: 36, 40, 51;
            --color-badge-border: 255, 255, 255;
            --payment-terms-background-color: rgb(36 40 51);
        }


        .color-scheme-4 {
            --color-background: 18, 18, 18;

            --gradient-background: #121212;




            --color-foreground: 255, 255, 255;
            --color-background-contrast: 146, 146, 146;
            --color-shadow: 18, 18, 18;
            --color-button: 255, 255, 255;
            --color-button-text: 18, 18, 18;
            --color-secondary-button: 18, 18, 18;
            --color-secondary-button-text: 255, 255, 255;
            --color-link: 255, 255, 255;
            --color-badge-foreground: 255, 255, 255;
            --color-badge-background: 18, 18, 18;
            --color-badge-border: 255, 255, 255;
            --payment-terms-background-color: rgb(18 18 18);
        }


        .color-scheme-5 {
            --color-background: 51, 79, 180;

            --gradient-background: #334fb4;




            --color-foreground: 255, 255, 255;
            --color-background-contrast: 23, 35, 81;
            --color-shadow: 18, 18, 18;
            --color-button: 255, 255, 255;
            --color-button-text: 51, 79, 180;
            --color-secondary-button: 51, 79, 180;
            --color-secondary-button-text: 255, 255, 255;
            --color-link: 255, 255, 255;
            --color-badge-foreground: 255, 255, 255;
            --color-badge-background: 51, 79, 180;
            --color-badge-border: 255, 255, 255;
            --payment-terms-background-color: rgb(51 79 180);
        }


        body,
        .color-scheme-1,
        .color-scheme-2,
        .color-scheme-3,
        .color-scheme-4,
        .color-scheme-5 {
            color: rgba(var(--color-foreground), 0.75);
            background-color: rgb(var(--color-background));
        }

        :root {
            --font-body-family: Assistant, sans-serif;
            --font-body-style: normal;
            --font-body-weight: 400;
            --font-body-weight-bold: 700;

            --font-heading-family: Assistant, sans-serif;
            --font-heading-style: normal;
            --font-heading-weight: 400;

            --font-body-scale: 1.0;
            --font-heading-scale: 1.0;

            --media-padding: px;
            --media-border-opacity: 0.05;
            --media-border-width: 1px;
            --media-radius: 0px;
            --media-shadow-opacity: 0.0;
            --media-shadow-horizontal-offset: 0px;
            --media-shadow-vertical-offset: 4px;
            --media-shadow-blur-radius: 5px;
            --media-shadow-visible: 0;

            --page-width: 120rem;
            --page-width-margin: 0rem;

            --product-card-image-padding: 0.0rem;
            --product-card-corner-radius: 0.0rem;
            --product-card-text-alignment: left;
            --product-card-border-width: 0.0rem;
            --product-card-border-opacity: 0.1;
            --product-card-shadow-opacity: 0.0;
            --product-card-shadow-visible: 0;
            --product-card-shadow-horizontal-offset: 0.0rem;
            --product-card-shadow-vertical-offset: 0.4rem;
            --product-card-shadow-blur-radius: 0.5rem;

            --collection-card-image-padding: 0.0rem;
            --collection-card-corner-radius: 0.0rem;
            --collection-card-text-alignment: left;
            --collection-card-border-width: 0.0rem;
            --collection-card-border-opacity: 0.1;
            --collection-card-shadow-opacity: 0.0;
            --collection-card-shadow-visible: 0;
            --collection-card-shadow-horizontal-offset: 0.0rem;
            --collection-card-shadow-vertical-offset: 0.4rem;
            --collection-card-shadow-blur-radius: 0.5rem;

            --blog-card-image-padding: 0.0rem;
            --blog-card-corner-radius: 0.0rem;
            --blog-card-text-alignment: left;
            --blog-card-border-width: 0.0rem;
            --blog-card-border-opacity: 0.1;
            --blog-card-shadow-opacity: 0.0;
            --blog-card-shadow-visible: 0;
            --blog-card-shadow-horizontal-offset: 0.0rem;
            --blog-card-shadow-vertical-offset: 0.4rem;
            --blog-card-shadow-blur-radius: 0.5rem;

            --badge-corner-radius: 4.0rem;

            --popup-border-width: 1px;
            --popup-border-opacity: 0.1;
            --popup-corner-radius: 0px;
            --popup-shadow-opacity: 0.05;
            --popup-shadow-horizontal-offset: 0px;
            --popup-shadow-vertical-offset: 4px;
            --popup-shadow-blur-radius: 5px;

            --drawer-border-width: 1px;
            --drawer-border-opacity: 0.1;
            --drawer-shadow-opacity: 0.0;
            --drawer-shadow-horizontal-offset: 0px;
            --drawer-shadow-vertical-offset: 4px;
            --drawer-shadow-blur-radius: 5px;

            --spacing-sections-desktop: 0px;
            --spacing-sections-mobile: 0px;

            --grid-desktop-vertical-spacing: 8px;
            --grid-desktop-horizontal-spacing: 8px;
            --grid-mobile-vertical-spacing: 4px;
            --grid-mobile-horizontal-spacing: 4px;

            --text-boxes-border-opacity: 0.1;
            --text-boxes-border-width: 0px;
            --text-boxes-radius: 0px;
            --text-boxes-shadow-opacity: 0.0;
            --text-boxes-shadow-visible: 0;
            --text-boxes-shadow-horizontal-offset: 0px;
            --text-boxes-shadow-vertical-offset: 4px;
            --text-boxes-shadow-blur-radius: 5px;

            --buttons-radius: 0px;
            --buttons-radius-outset: 0px;
            --buttons-border-width: 1px;
            --buttons-border-opacity: 1.0;
            --buttons-shadow-opacity: 0.0;
            --buttons-shadow-visible: 0;
            --buttons-shadow-horizontal-offset: 0px;
            --buttons-shadow-vertical-offset: 4px;
            --buttons-shadow-blur-radius: 5px;
            --buttons-border-offset: 0px;

            --inputs-radius: 0px;
            --inputs-border-width: 1px;
            --inputs-border-opacity: 0.55;
            --inputs-shadow-opacity: 0.0;
            --inputs-shadow-horizontal-offset: 0px;
            --inputs-margin-offset: 0px;
            --inputs-shadow-vertical-offset: 4px;
            --inputs-shadow-blur-radius: 5px;
            --inputs-radius-outset: 0px;

            --variant-pills-radius: 40px;
            --variant-pills-border-width: 1px;
            --variant-pills-border-opacity: 0.55;
            --variant-pills-shadow-opacity: 0.0;
            --variant-pills-shadow-horizontal-offset: 0px;
            --variant-pills-shadow-vertical-offset: 4px;
            --variant-pills-shadow-blur-radius: 5px;
        }

        *,
        *::before,
        *::after {
            box-sizing: inherit;
        }

        html {
            box-sizing: border-box;
            font-size: calc(var(--font-body-scale) * 62.5%);
            height: 100%;
        }

        body {
            display: grid;
            grid-template-rows: auto auto 1fr auto;
            grid-template-columns: 100%;
            min-height: 100%;
            margin: 0;
            font-size: 1.5rem;
            letter-spacing: 0.06rem;
            line-height: calc(1 + 0.8 / var(--font-body-scale));
            font-family: var(--font-body-family);
            font-style: var(--font-body-style);
            font-weight: var(--font-body-weight);
        }

        @media screen and (min-width: 750px) {
            body {
                font-size: 1.6rem;
            }
        }
    </style>

    <link href="{{ asset('cdn/shop/t/3/assets/base.css?v=159841507637079171801763467722.css') }}" rel="stylesheet" type="text/css"
        media="all" />
    <link rel="stylesheet" href="{{ asset('cdn/shop/t/3/assets/component-cart-items.css?v=13033300910818915211763467722.css') }}"
        media="print" onload="this.media='all'">
    <link rel="preload" as="font"
        href="{{ asset('cdn/fonts/assistant/assistant_n4.9120912a469cad1cc292572851508ca49d12e768.woff2') }}" type="font/woff2"
        crossorigin>


    <link rel="preload" as="font"
        href="{{ asset('cdn/fonts/assistant/assistant_n4.9120912a469cad1cc292572851508ca49d12e768.woff2') }}" type="font/woff2"
        crossorigin>

    <link rel="stylesheet"
        href="{{ asset('cdn/shop/t/3/assets/component-predictive-search.css?v=118923337488134913561763467722.css') }}" media="print"
        onload="this.media='all'">

    <style>
        .shiprocket-headless {
            width: 100% !important
        }
    </style>
</head>

<body class="gradient">
    <a class="skip-to-content-link button visually-hidden" href="index.html#MainContent">
        Skip to content
    </a><!-- BEGIN sections: header-group -->
    <div id="shopify-section-sections--25919688868162__announcement-bar"
        class="shopify-section shopify-section-group-header-group announcement-bar-section">
        <link href="{{ asset('cdn/shop/t/3/assets/component-slideshow.css?v=17933591812325749411763467722.css') }}" rel="stylesheet"
            type="text/css" media="all" />
        <link href="{{ asset('cdn/shop/t/3/assets/component-slider.css?v=14039311878856620671763467722.css') }}" rel="stylesheet"
            type="text/css" media="all" />


        <div class="utility-bar color-scheme-1 gradient utility-bar--bottom-border">
            <div class="page-width utility-bar__grid">
                <div class="announcement-bar" role="region" aria-label="Announcement">
                    <p class="announcement-bar__message h5">
                        <span>Welcome to our store</span>
                    </p>
                </div>
                <div class="localization-wrapper">
                </div>
            </div>
        </div>


    </div>
    <div id="shopify-section-sections--25919688868162__header"
        class="shopify-section shopify-section-group-header-group section-header">
        <link rel="stylesheet" href="{{ asset('cdn/shop/t/3/assets/component-list-menu.css?v=151968516119678728991763467722.css') }}"
            media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('cdn/shop/t/3/assets/component-search.css?v=165164710990765432851763467722.css') }}"
            media="print" onload="this.media='all'">
        <link rel="stylesheet"
            href="{{ asset('cdn/shop/t/3/assets/component-menu-drawer.css?v=147478906057189667651763467722.css') }}" media="print"
            onload="this.media='all'">
        <link rel="stylesheet"
            href="{{ asset('cdn/shop/t/3/assets/component-cart-notification.css?v=54116361853792938221763467722.css') }}"
            media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('cdn/shop/t/3/assets/component-price.css?v=47596247576480123001763467722.css') }}"
            media="print" onload="this.media='all'">
        <style>
            header-drawer {
                justify-self: start;
                margin-left: -1.2rem;
            }

            @media screen and (min-width: 990px) {
                header-drawer {
                    display: none;
                }
            }

            .menu-drawer-container {
                display: flex;
            }

            .list-menu {
                list-style: none;
                padding: 0;
                margin: 0;
            }

            .list-menu--inline {
                display: inline-flex;
                flex-wrap: wrap;
            }

            summary.list-menu__item {
                padding-right: 2.7rem;
            }

            .list-menu__item {
                display: flex;
                align-items: center;
                line-height: calc(1 + 0.3 / var(--font-body-scale));
            }

            .list-menu__item--link {
                text-decoration: none;
                padding-bottom: 1rem;
                padding-top: 1rem;
                line-height: calc(1 + 0.8 / var(--font-body-scale));
            }

            @media screen and (min-width: 750px) {
                .list-menu__item--link {
                    padding-bottom: 0.5rem;
                    padding-top: 0.5rem;
                }
            }
        </style>
        <style data-shopify>
            .header {
                padding: 10px 3rem 10px 3rem;
            }

            .section-header {
                position: sticky;
                /* This is for fixing a Safari z-index issue. PR #2147 */
                margin-bottom: 0px;
            }

            @media screen and (min-width: 750px) {
                .section-header {
                    margin-bottom: 0px;
                }
            }

            @media screen and (min-width: 990px) {
                .header {
                    padding-top: 20px;
                    padding-bottom: 20px;
                }
            }
        </style>

        <sticky-header data-sticky-type="on-scroll-up"
            class="header-wrapper color-scheme-1 gradient header-wrapper--border-bottom">
            <header
                class="header header--middle-left header--mobile-center page-width header--has-menu header--has-account">

                <header-drawer data-breakpoint="tablet">
                    <details id="Details-menu-drawer-container" class="menu-drawer-container">
                        <summary class="header__icon header__icon--menu header__icon--summary link focus-inset"
                            aria-label="Menu">
                            <span><svg xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-hamburger"
                                    viewBox="0 0 18 16">
                                    <path fill="currentColor"
                                        d="M1 .5a.5.5 0 1 0 0 1h15.71a.5.5 0 0 0 0-1zM.5 8a.5.5 0 0 1 .5-.5h15.71a.5.5 0 0 1 0 1H1A.5.5 0 0 1 .5 8m0 7a.5.5 0 0 1 .5-.5h15.71a.5.5 0 0 1 0 1H1a.5.5 0 0 1-.5-.5" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-close"
                                    viewBox="0 0 18 17">
                                    <path fill="currentColor"
                                        d="M.865 15.978a.5.5 0 0 0 .707.707l7.433-7.431 7.579 7.282a.501.501 0 0 0 .846-.37.5.5 0 0 0-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 1 0-.707-.708L8.991 7.853 1.413.573a.5.5 0 1 0-.693.72l7.563 7.268z" />
                                </svg>
                            </span>
                        </summary>
                        <div id="menu-drawer" class="gradient menu-drawer motion-reduce color-scheme-1">
                            <div class="menu-drawer__inner-container">
                                <div class="menu-drawer__navigation-container">
                                    <nav class="menu-drawer__navigation">
                                        <ul class="menu-drawer__menu has-submenu list-menu" role="list">
                                            <li><a id="HeaderDrawer-home" href="index.html"
                                                    class="menu-drawer__menu-item list-menu__item link link--text focus-inset menu-drawer__menu-item--active"
                                                    aria-current="page">
                                                    Home
                                                </a></li>
                                            <li><a id="HeaderDrawer-catalog" href="collections/all.html"
                                                    class="menu-drawer__menu-item list-menu__item link link--text focus-inset">
                                                    Catalog
                                                </a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </details>
                </header-drawer>
                <h1 class="header__heading"><a href="index.html"
                        class="header__heading-link link link--text focus-inset"><span
                            class="h2">Vatahari</span></a>
                </h1>

                <nav class="header__inline-menu">
                    <ul class="list-menu list-menu--inline" role="list">
                        <li><a id="HeaderMenu-home" href="index.html"
                                class="header__menu-item list-menu__item link link--text focus-inset"
                                aria-current="page">
                                <span class="header__active-menu-item">Home</span>
                            </a></li>
                        <li><a id="HeaderMenu-catalog" href="collections/all.html"
                                class="header__menu-item list-menu__item link link--text focus-inset">
                                <span>Catalog</span>
                            </a></li>
                    </ul>
                </nav>
            </header>
        </sticky-header>

        <cart-notification>
            <div class="cart-notification-wrapper page-width">
                <div id="cart-notification" class="cart-notification focus-inset color-scheme-1 gradient"
                    aria-modal="true" aria-label="Item added to your cart" role="dialog" tabindex="-1">
                    <div class="cart-notification__header">
                        <h2 class="cart-notification__heading caption-large text-body"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" class="icon icon-checkmark"
                                viewBox="0 0 12 9">
                                <path fill="currentColor" fill-rule="evenodd"
                                    d="M11.35.643a.5.5 0 0 1 .006.707l-6.77 6.886a.5.5 0 0 1-.719-.006L.638 4.845a.5.5 0 1 1 .724-.69l2.872 3.011 6.41-6.517a.5.5 0 0 1 .707-.006z"
                                    clip-rule="evenodd" />
                            </svg>
                            Item added to your cart
                        </h2>
                        <button type="button"
                            class="cart-notification__close modal__close-button link link--text focus-inset"
                            aria-label="Close">
                            <span class="svg-wrapper"><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    class="icon icon-close" viewBox="0 0 18 17">
                                    <path fill="currentColor"
                                        d="M.865 15.978a.5.5 0 0 0 .707.707l7.433-7.431 7.579 7.282a.501.501 0 0 0 .846-.37.5.5 0 0 0-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 1 0-.707-.708L8.991 7.853 1.413.573a.5.5 0 1 0-.693.72l7.563 7.268z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    <div id="cart-notification-product" class="cart-notification-product"></div>
                    <div class="cart-notification__links">
                        <a href="#" id="cart-notification-button"
                            class="button button--secondary button--full-width">View cart</a>
                        <form action="#" method="post" id="cart-notification-form">
                            <button class="button button--primary button--full-width" name="checkout">
                                Check out
                            </button>
                        </form>
                        <button type="button" class="link button-label">Continue shopping</button>
                    </div>
                </div>
            </div>
        </cart-notification>
        <style data-shopify>
            .cart-notification {
                display: none;
            }
        </style>
    </div>
    <!-- END sections: header-group -->

    <main id="MainContent" class="content-for-layout focus-none" role="main" tabindex="-1">
        <section id="shopify-section-template--25919691653442__image_banner" class="shopify-section section">
            <link href="{{ asset('cdn/shop/t/3/assets/section-image-banner.css?v=124819179385751388401763467722.css') }}"
                rel="stylesheet" type="text/css" media="all" />
            <style data-shopify>
                @media screen and (max-width: 749px) {

                    #Banner-template--25919691653442__image_banner::before,
                    #Banner-template--25919691653442__image_banner .banner__media::before,
                    #Banner-template--25919691653442__image_banner:not(.banner--mobile-bottom) .banner__content::before {
                        padding-bottom: 32.87310979618672%;
                        content: '';
                        display: block;
                    }
                }

                @media screen and (min-width: 750px) {

                    #Banner-template--25919691653442__image_banner::before,
                    #Banner-template--25919691653442__image_banner .banner__media::before {
                        padding-bottom: 32.87310979618672%;
                        content: '';
                        display: block;
                    }
                }
            </style>
            <style data-shopify>
                #Banner-template--25919691653442__image_banner::after {
                    opacity: 0.4;
                }
            </style>
            <div id="Banner-template--25919691653442__image_banner"
                class="banner banner--content-align-center banner--content-align-mobile-center banner--adapt banner--adapt banner--desktop-transparent scroll-trigger animate--fade-in">
                <div class="banner__media media scroll-trigger animate--fade-in"><img
                        src="{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=3840') }}"
                        alt=""
                        srcset="{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=375') }} 375w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=550') }} 550w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=750') }} 750w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=1100') }} 1100w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=1500') }} 1500w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=1780') }} 1780w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=2000') }} 2000w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=3000') }} 3000w,{{ asset('cdn/shop/files/Natural_Joint_Pain_Relief_1.png?v=1757534362&width=3840') }} 3840w"
                        width="1521" height="500.0" sizes="100vw" fetchpriority="high">
                </div>
                <div
                    class="banner__content banner__content--bottom-center page-width scroll-trigger animate--slide-in">
                    <div
                        class="banner__box content-container content-container--full-width-mobile color-scheme-3 gradient">
                    </div>
                </div>
            </div>


        </section>
        <section id="shopify-section-template--25919691653442__featured_collection" class="shopify-section section">
            <link href="{{ asset('cdn/shop/t/3/assets/component-card.css?v=120341546515895839841763467722.css') }}"
                rel="stylesheet" type="text/css" media="all" />
            <link href="{{ asset('cdn/shop/t/3/assets/component-price.css?v=47596247576480123001763467722.css') }}"
                rel="stylesheet" type="text/css" media="all" />

            <link href="{{ asset('cdn/shop/t/3/assets/component-slider.css?v=14039311878856620671763467722.css') }}"
                rel="stylesheet" type="text/css" media="all" />
            <link href="{{ asset('cdn/shop/t/3/assets/template-collection.css?v=58558206033505836701763467722.css') }}"
                rel="stylesheet" type="text/css" media="all" />

            <style data-shopify>
                .section-template--25919691653442__featured_collection-padding {
                    padding-top: 33px;
                    padding-bottom: 27px;
                }

                @media screen and (min-width: 750px) {
                    .section-template--25919691653442__featured_collection-padding {
                        padding-top: 44px;
                        padding-bottom: 36px;
                    }
                }
            </style>
            <div class="color-scheme-1 isolate gradient">
                <div class="collection section-template--25919691653442__featured_collection-padding"
                    id="collection-template--25919691653442__featured_collection"
                    data-id="template--25919691653442__featured_collection">
                    <div class="collection__title title-wrapper title-wrapper--no-top-margin page-width">
                        <h2 class="title inline-richtext h1 scroll-trigger animate--slide-in">
                            Best Sellers
                        </h2>
                    </div>

                    <slider-component
                        class="slider-mobile-gutter page-width page-width-desktop scroll-trigger animate--slide-in">
                        <ul id="Slider-template--25919691653442__featured_collection"
                            data-id="template--25919691653442__featured_collection"
                            class="grid product-grid contains-card contains-card--product contains-card--standard grid--4-col-desktop grid--2-col-tablet-down"
                            role="list" aria-label="Slider">




                            <li id="Slide-template--25919691653442__featured_collection-1"
                                class="grid__item scroll-trigger animate--slide-in" data-cascade
                                style="--animation-order: 1;">

                                <link
                                    href="{{ asset('cdn/shop/t/3/assets/component-rating.css?v=179577762467860590411763467722.css') }}"
                                    rel="stylesheet" type="text/css" media="all" />
                                <link
                                    href="{{ asset('cdn/shop/t/3/assets/component-volume-pricing.css?v=111870094811454961941763467722.css') }}"
                                    rel="stylesheet" type="text/css" media="all" />

                                <link
                                    href="{{ asset('cdn/shop/t/3/assets/component-price.css?v=47596247576480123001763467722.css') }}"
                                    rel="stylesheet" type="text/css" media="all" />
                                <link
                                    href="{{ asset('cdn/shop/t/3/assets/quick-order-list.css?v=86354568948591544181763467722.css') }}"
                                    rel="stylesheet" type="text/css" media="all" />
                                <link
                                    href="{{ asset('cdn/shop/t/3/assets/quantity-popover.css?v=160630540099520878331763467722.css') }}"
                                    rel="stylesheet" type="text/css" media="all" />
                                <div class="card-wrapper product-card-wrapper underline-links-hover">
                                    <div class=" card card--standard card--media  " style="--ratio-percent: 100.0%;">
                                        <div class="card__inner color-scheme-2 gradient ratio"
                                            style="--ratio-percent: 100.0%;">
                                            <div class="card__media">
                                                <div class="media media--transparent media--hover-effect">

                                                    <img srcset="{{ asset('cdn/shop/files/Untitleddesign_1.png?v=1757535467&width=165') }} 165w,{{ asset('cdn/shop/files/Untitleddesign_1.png?v=1757535467&width=360') }} 360w,{{ asset('cdn/shop/files/Untitleddesign_1.png?v=1757535467') }} 500w"
                                                        src="{{ asset('cdn/shop/files/Untitleddesign_1.png?v=1757535467&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati - Natural Joint Relief Tablet"
                                                        class="motion-reduce" width="500" height="500">

                                                    <img srcset="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=165') }} 165w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=360') }} 360w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }} 533w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=720') }} 720w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=940') }} 940w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=1066') }} 1066w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547') }} 1080w"
                                                        src="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati - Natural Joint Relief Tablet"
                                                        class="motion-reduce" loading="lazy" width="1080"
                                                        height="1080">
                                                </div>
                                            </div>
                                            <div class="card__content">
                                                <div class="card__information">
                                                    <h3 class="card__heading">
                                                        <a href="products/vatahari-vati-natural-joint-relief-tablet.html"
                                                            id="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071948951874"
                                                            class="full-unstyled-link"
                                                            aria-labelledby="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071948951874 NoMediaStandardBadge-template--25919691653442__featured_collection-10071948951874">
                                                            Vatahari Vati - Natural Joint Relief Tablet
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="card__badge bottom left"><span
                                                        id="NoMediaStandardBadge-template--25919691653442__featured_collection-10071948951874"
                                                        class="badge badge--bottom-left color-scheme-4">Sale</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card__content">
                                            <div class="card__information">
                                                <h3 class="card__heading h5"
                                                    id="title-template--25919691653442__featured_collection-10071948951874">
                                                    <a href="products/vatahari-vati-natural-joint-relief-tablet.html"
                                                        id="CardLink-template--25919691653442__featured_collection-10071948951874"
                                                        class="full-unstyled-link"
                                                        aria-labelledby="CardLink-template--25919691653442__featured_collection-10071948951874 Badge-template--25919691653442__featured_collection-10071948951874">
                                                        Vatahari Vati - Natural Joint Relief Tablet
                                                    </a>
                                                </h3>
                                                <div class="card-information"><span
                                                        class="caption-large light"></span>
                                                    <div class="price  price--on-sale">
                                                        <div class="price__container">
                                                            <div class="price__regular"><span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span class="price-item price-item--regular">
                                                                    Rs. 630.00
                                                                </span>
                                                            </div>
                                                            <div class="price__sale">
                                                                <span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span>
                                                                    <s class="price-item price-item--regular">
                                                                        Rs. 699.00
                                                                    </s>
                                                                </span><span
                                                                    class="visually-hidden visually-hidden--inline">Sale
                                                                    price</span>
                                                                <span
                                                                    class="price-item price-item--sale price-item--last">
                                                                    Rs. 630.00
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card__badge bottom left"><span
                                                    id="Badge-template--25919691653442__featured_collection-10071948951874"
                                                    class="badge badge--bottom-left color-scheme-4">Sale</span></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="Slide-template--25919691653442__featured_collection-2"
                                class="grid__item scroll-trigger animate--slide-in" data-cascade
                                style="--animation-order: 2;">

                                <div class="card-wrapper product-card-wrapper underline-links-hover">
                                    <div class=" card card--standard card--media" style="--ratio-percent: 100.0%;">
                                        <div class="card__inner color-scheme-2 gradient ratio"
                                            style="--ratio-percent: 100.0%;">
                                            <div class="card__media">
                                                <div class="media media--transparent media--hover-effect">

                                                    <img srcset="{{ asset('cdn/shop/files/Untitleddesign_4_9b8ab6f6-03e2-4c83-ab4c-fd3b3f776161.png?v=1757537720&width=165') }} 165w,{{ asset('cdn/shop/files/Untitleddesign_4_9b8ab6f6-03e2-4c83-ab4c-fd3b3f776161.png?v=1757537720&width=360') }} 360w,{{ asset('cdn/shop/files/Untitleddesign_4_9b8ab6f6-03e2-4c83-ab4c-fd3b3f776161.png?v=1757537720') }} 500w"
                                                        src="{{ asset('cdn/shop/files/Untitleddesign_4_9b8ab6f6-03e2-4c83-ab4c-fd3b3f776161.png?v=1757537720&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati - Pack of 2" class="motion-reduce"
                                                        width="500" height="500">

                                                    <img srcset="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=165') }} 165w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=360') }} 360w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }} 533w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=720') }} 720w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=940') }} 940w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=1066') }} 1066w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547') }} 1080w"
                                                        src="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati - Pack of 2" class="motion-reduce"
                                                        loading="lazy" width="1080" height="1080">
                                                </div>
                                            </div>
                                            <div class="card__content">
                                                <div class="card__information">
                                                    <h3 class="card__heading">
                                                        <a href="products/vatahari-vati-pack-of-2.html"
                                                            id="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071959601474"
                                                            class="full-unstyled-link"
                                                            aria-labelledby="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071959601474 NoMediaStandardBadge-template--25919691653442__featured_collection-10071959601474">
                                                            Vatahari Vati - Pack of 2
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="card__badge bottom left">
                                                    <span
                                                        id="NoMediaStandardBadge-template--25919691653442__featured_collection-10071959601474"
                                                        class="badge badge--bottom-left color-scheme-4">
                                                        Sale
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card__content">
                                            <div class="card__information">
                                                <h3 class="card__heading h5"
                                                    id="title-template--25919691653442__featured_collection-10071959601474">
                                                    <a href="products/vatahari-vati-pack-of-2.html"
                                                        id="CardLink-template--25919691653442__featured_collection-10071959601474"
                                                        class="full-unstyled-link"
                                                        aria-labelledby="CardLink-template--25919691653442__featured_collection-10071959601474 Badge-template--25919691653442__featured_collection-10071959601474">
                                                        Vatahari Vati - Pack of 2
                                                    </a>
                                                </h3>
                                                <div class="card-information"><span
                                                        class="caption-large light"></span>
                                                    <div class="
      price  price--on-sale">
                                                        <div class="price__container">
                                                            <div class="price__regular"><span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span class="price-item price-item--regular">
                                                                    Rs. 1,200.00
                                                                </span>
                                                            </div>
                                                            <div class="price__sale">
                                                                <span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span>
                                                                    <s class="price-item price-item--regular">

                                                                        Rs. 1,398.00

                                                                    </s>
                                                                </span><span
                                                                    class="visually-hidden visually-hidden--inline">Sale
                                                                    price</span>
                                                                <span
                                                                    class="price-item price-item--sale price-item--last">
                                                                    Rs. 1,200.00
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                            <div class="card__badge bottom left"><span
                                                    id="Badge-template--25919691653442__featured_collection-10071959601474"
                                                    class="badge badge--bottom-left color-scheme-4">Sale</span></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="Slide-template--25919691653442__featured_collection-3"
                                class="grid__item scroll-trigger animate--slide-in" data-cascade
                                style="--animation-order: 3;">

                                <div class="card-wrapper product-card-wrapper underline-links-hover">
                                    <div class="
        card card--standard
         card--media





      "
                                        style="--ratio-percent: 100.0%;">
                                        <div class="card__inner color-scheme-2 gradient ratio"
                                            style="--ratio-percent: 100.0%;">
                                            <div class="card__media">
                                                <div class="media media--transparent media--hover-effect">

                                                    <img srcset="{{ asset('cdn/shop/files/Untitleddesign_3.png?v=1757537510&width=165') }} 165w,{{ asset('cdn/shop/files/Untitleddesign_3.png?v=1757537510&width=360') }} 360w,{{ asset('cdn/shop/files/Untitleddesign_3.png?v=1757537510') }} 500w"
                                                        src="{{ asset('cdn/shop/files/Untitleddesign_3.png?v=1757537510&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati Pack of 5" class="motion-reduce"
                                                        width="500" height="500">

                                                    <img srcset="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=165') }} 165w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=360') }} 360w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }} 533w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=720') }} 720w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=940') }} 940w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=1066') }} 1066w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547') }} 1080w"
                                                        src="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati Pack of 5" class="motion-reduce"
                                                        loading="lazy" width="1080" height="1080">
                                                </div>
                                            </div>
                                            <div class="card__content">
                                                <div class="card__information">
                                                    <h3 class="card__heading">
                                                        <a href="products/vatahari-vati-pack-of-5.html"
                                                            id="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071959109954"
                                                            class="full-unstyled-link"
                                                            aria-labelledby="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071959109954 NoMediaStandardBadge-template--25919691653442__featured_collection-10071959109954">
                                                            Vatahari Vati Pack of 5
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="card__badge bottom left"><span
                                                        id="NoMediaStandardBadge-template--25919691653442__featured_collection-10071959109954"
                                                        class="badge badge--bottom-left color-scheme-4">Sale</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card__content">
                                            <div class="card__information">
                                                <h3 class="card__heading h5"
                                                    id="title-template--25919691653442__featured_collection-10071959109954">
                                                    <a href="products/vatahari-vati-pack-of-5.html"
                                                        id="CardLink-template--25919691653442__featured_collection-10071959109954"
                                                        class="full-unstyled-link"
                                                        aria-labelledby="CardLink-template--25919691653442__featured_collection-10071959109954 Badge-template--25919691653442__featured_collection-10071959109954">
                                                        Vatahari Vati Pack of 5
                                                    </a>
                                                </h3>
                                                <div class="card-information"><span
                                                        class="caption-large light"></span>
                                                    <div class="
      price  price--on-sale">
                                                        <div class="price__container">
                                                            <div class="price__regular"><span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span class="price-item price-item--regular">
                                                                    Rs. 2,500.00
                                                                </span>
                                                            </div>
                                                            <div class="price__sale">
                                                                <span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span>
                                                                    <s class="price-item price-item--regular">

                                                                        Rs. 3,495.00

                                                                    </s>
                                                                </span><span
                                                                    class="visually-hidden visually-hidden--inline">Sale
                                                                    price</span>
                                                                <span
                                                                    class="price-item price-item--sale price-item--last">
                                                                    Rs. 2,500.00
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>


                                            <div class="card__badge bottom left"><span
                                                    id="Badge-template--25919691653442__featured_collection-10071959109954"
                                                    class="badge badge--bottom-left color-scheme-4">Sale</span></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li id="Slide-template--25919691653442__featured_collection-4"
                                class="grid__item scroll-trigger animate--slide-in" data-cascade
                                style="--animation-order: 4;">

                                <div class="card-wrapper product-card-wrapper underline-links-hover">
                                    <div class="
        card card--standard
         card--media





      "
                                        style="--ratio-percent: 100.0%;">
                                        <div class="card__inner color-scheme-2 gradient ratio"
                                            style="--ratio-percent: 100.0%;">
                                            <div class="card__media">
                                                <div class="media media--transparent media--hover-effect">

                                                    <img srcset="{{ asset('cdn/shop/files/Untitleddesign_2.png?v=1757537208&width=165') }} 165w,{{ asset('cdn/shop/files/Untitleddesign_2.png?v=1757537208&width=360') }} 360w,{{ asset('cdn/shop/files/Untitleddesign_2.png?v=1757537208') }} 500w"
                                                        src="{{ asset('cdn/shop/files/Untitleddesign_2.png?v=1757537208&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati - Pack of 3" class="motion-reduce"
                                                        width="500" height="500">

                                                    <img srcset="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=165') }} 165w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=360') }} 360w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }} 533w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=720') }} 720w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=940') }} 940w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=1066') }} 1066w,{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547') }} 1080w"
                                                        src="{{ asset('cdn/shop/files/vati_ingredients.png?v=1763314547&width=533') }}"
                                                        sizes="(min-width: 1200px) 267px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                                                        alt="Vatahari Vati - Pack of 3" class="motion-reduce"
                                                        loading="lazy" width="1080" height="1080">
                                                </div>
                                            </div>
                                            <div class="card__content">
                                                <div class="card__information">
                                                    <h3 class="card__heading">
                                                        <a href="products/vatahari-vati-pack-of-3.html"
                                                            id="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071951212866"
                                                            class="full-unstyled-link"
                                                            aria-labelledby="StandardCardNoMediaLink-template--25919691653442__featured_collection-10071951212866 NoMediaStandardBadge-template--25919691653442__featured_collection-10071951212866">
                                                            Vatahari Vati - Pack of 3
                                                        </a>
                                                    </h3>
                                                </div>
                                                <div class="card__badge bottom left"><span
                                                        id="NoMediaStandardBadge-template--25919691653442__featured_collection-10071951212866"
                                                        class="badge badge--bottom-left color-scheme-4">Sale</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card__content">
                                            <div class="card__information">
                                                <h3 class="card__heading h5"
                                                    id="title-template--25919691653442__featured_collection-10071951212866">
                                                    <a href="products/vatahari-vati-pack-of-3.html"
                                                        id="CardLink-template--25919691653442__featured_collection-10071951212866"
                                                        class="full-unstyled-link"
                                                        aria-labelledby="CardLink-template--25919691653442__featured_collection-10071951212866 Badge-template--25919691653442__featured_collection-10071951212866">
                                                        Vatahari Vati - Pack of 3
                                                    </a>
                                                </h3>
                                                <div class="card-information"><span
                                                        class="caption-large light"></span>
                                                    <div class="
      price  price--on-sale">
                                                        <div class="price__container">
                                                            <div class="price__regular"><span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span class="price-item price-item--regular">
                                                                    Rs. 1,650.00
                                                                </span>
                                                            </div>
                                                            <div class="price__sale">
                                                                <span
                                                                    class="visually-hidden visually-hidden--inline">Regular
                                                                    price</span>
                                                                <span>
                                                                    <s class="price-item price-item--regular">

                                                                        Rs. 2,097.00

                                                                    </s>
                                                                </span><span
                                                                    class="visually-hidden visually-hidden--inline">Sale
                                                                    price</span>
                                                                <span
                                                                    class="price-item price-item--sale price-item--last">
                                                                    Rs. 1,650.00
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card__badge bottom left"><span
                                                    id="Badge-template--25919691653442__featured_collection-10071951212866"
                                                    class="badge badge--bottom-left color-scheme-4">Sale</span></div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </slider-component>
                </div>
            </div>


        </section>
        <section id="shopify-section-template--25919691653442__image_banner_eJhDkm" class="shopify-section section">
            <link href="{{ asset('cdn/shop/t/3/assets/section-image-banner.css?v=124819179385751388401763467722.css') }}"
                rel="stylesheet" type="text/css" media="all" />
            <style data-shopify>
                @media screen and (max-width: 749px) {

                    #Banner-template--25919691653442__image_banner_eJhDkm::before,
                    #Banner-template--25919691653442__image_banner_eJhDkm .banner__media::before,
                    #Banner-template--25919691653442__image_banner_eJhDkm:not(.banner--mobile-bottom) .banner__content::before {
                        padding-bottom: 32.87310979618672%;
                        content: '';
                        display: block;
                    }
                }

                @media screen and (min-width: 750px) {

                    #Banner-template--25919691653442__image_banner_eJhDkm::before,
                    #Banner-template--25919691653442__image_banner_eJhDkm .banner__media::before {
                        padding-bottom: 32.87310979618672%;
                        content: '';
                        display: block;
                    }
                }
            </style>
            <style data-shopify>
                #Banner-template--25919691653442__image_banner_eJhDkm::after {
                    opacity: 0.0;
                }
            </style>
            <div id="Banner-template--25919691653442__image_banner_eJhDkm"
                class="banner banner--content-align-center banner--content-align-mobile-center banner--adapt banner--adapt banner--mobile-bottom scroll-trigger animate--fade-in">
                <div class="banner__media media scroll-trigger animate--fade-in"><img
                        src="{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=3840') }}"
                        alt=""
                        srcset="{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=375') }} 375w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=550') }} 550w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=750') }} 750w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=1100') }} 1100w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=1500') }} 1500w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=1780') }} 1780w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=2000') }} 2000w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=3000') }} 3000w,{{ asset('cdn/shop/files/GOODNESS_OF_PURITY_AUTHENCITY_OF_AYURVEDA.png?v=1757537958&width=3840') }} 3840w"
                        width="1521" height="500.0" sizes="100vw" fetchpriority="auto">
                </div>
            </div>


        </section>
    </main>

    <!-- BEGIN sections: footer-group -->
    <div id="shopify-section-sections--25919688802626__footer"
        class="shopify-section shopify-section-group-footer-group">
        <link href="{{ asset('cdn/shop/t/3/assets/section-footer.css?v=60318643098753476351763467722.css') }}" rel="stylesheet"
            type="text/css" media="all" />
        <link href="{{ asset('cdn/shop/t/3/assets/component-newsletter.css?v=4727253280200485261763467722.css') }}"
            rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('cdn/shop/t/3/assets/component-list-menu.css?v=151968516119678728991763467722.css') }}"
            rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('cdn/shop/t/3/assets/component-list-payment.css?v=69253961410771838501763467722.css') }}"
            rel="stylesheet" type="text/css" media="all" />
        <link href="{{ asset('cdn/shop/t/3/assets/component-list-social.css?v=35792976012981934991763467722.css') }}"
            rel="stylesheet" type="text/css" media="all" />
        <style data-shopify>
            .footer {
                margin-top: 0px;
            }

            .section-sections--25919688802626__footer-padding {
                padding-top: 27px;
                padding-bottom: 27px;
            }

            @media screen and (min-width: 750px) {
                .footer {
                    margin-top: 0px;
                }

                .section-sections--25919688802626__footer-padding {
                    padding-top: 36px;
                    padding-bottom: 36px;
                }
            }
        </style>
    </div>
    <!-- END sections: footer-group -->

    <ul hidden>
        <li id="a11y-refresh-page-message">Choosing a selection results in a full page refresh.</li>
        <li id="a11y-new-window-message">Opens in a new window.</li>
    </ul>
</body>

</html>
