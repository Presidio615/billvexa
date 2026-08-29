<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $setting->site_name ?? 'BillVexa' }} - Gift Cards</title>

    <link rel="shortcut icon"
        href="{{ asset('Assets/Image/icon.png') }}"
        type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: #f5f7fb;
            color: #202124;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }

        /* ================================
           SIDEBAR
        ================================= */

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 260px;
            height: 100vh;
            padding: 25px 15px;
            background: linear-gradient(180deg, blueviolet, #4b49f5);
            z-index: 1000;
        }

        .logo {
            color: #fff;
            font-size: 27px;
            font-weight: 800;
            margin-bottom: 38px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 13px;
            color: rgba(255, 255, 255, .82);
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 13px;
            margin-bottom: 8px;
            transition: .25s;
        }

        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255, 255, 255, .16);
            color: #fff;
            transform: translateX(3px);
        }

        /* ================================
           MAIN
        ================================= */

        .main-content {
            margin-left: 260px;
            padding: 28px;
            min-height: 100vh;
        }

        /* ================================
           TOPBAR
        ================================= */

        .topbar {
            background: #fff;
            border-radius: 18px;
            padding: 17px 22px;
            margin-bottom: 25px;
            box-shadow: 0 5px 22px rgba(0, 0, 0, .05);
        }

        /* ================================
           HERO
        ================================= */

        .gift-hero {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
            padding: 42px;
            min-height: 320px;
            color: #fff;
            margin-bottom: 25px;

            background:
                linear-gradient(
                    90deg,
                    rgba(44, 22, 75, .96),
                    rgba(74, 45, 140, .80)
                ),
                url("https://images.unsplash.com/photo-1607082349566-187342175e2f?auto=format&fit=crop&w=1600&q=80")
                center/cover;
        }

        .gift-hero-content {
            position: relative;
            z-index: 2;
            max-width: 650px;
        }

        .gift-hero h1 {
            font-size: clamp(30px, 5vw, 48px);
            font-weight: 800;
            margin-bottom: 12px;
        }

        .gift-hero p {
            opacity: .9;
            font-size: 16px;
            line-height: 1.7;
            max-width: 600px;
        }

        /* ================================
           SEARCH
        ================================= */

        .search-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            margin-top: 25px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .14);
        }

        .search-card .form-control {
            min-height: 48px;
            border-radius: 11px;
            border: 1px solid #e2e2e2;
        }

        .search-card .form-control:focus {
            border-color: blueviolet;
            box-shadow: 0 0 0 .15rem rgba(138, 43, 226, .12);
        }

        .search-btn {
            width: 100%;
            min-height: 48px;
            border: 0;
            border-radius: 11px;
            color: #fff;
            font-weight: 700;
            background: linear-gradient(135deg, blueviolet, #4b49f5);
        }

        /* ================================
           SECTION
        ================================= */

        .section-card {
            background: #fff;
            border-radius: 21px;
            padding: 24px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
        }

        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-title h5 {
            font-weight: 800;
            margin: 0;
        }

        .view-all {
            color: blueviolet;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
        }

        /* ================================
           CATEGORIES
        ================================= */

        .category-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            color: #333;
            background: #faf9ff;
            border: 1px solid #eee8ff;
            border-radius: 17px;
            min-height: 125px;
            padding: 15px;
            transition: .25s;
        }

        .category-card:hover,
        .category-card.active {
            color: blueviolet;
            border-color: rgba(138, 43, 226, .35);
            background: #f5efff;
            transform: translateY(-3px);
        }

        .category-icon {
            width: 53px;
            height: 53px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eee7ff;
            color: blueviolet;
            font-size: 23px;
            margin-bottom: 10px;
        }

        .category-card strong {
            font-size: 13px;
        }

        .category-card small {
            color: #777;
            margin-top: 3px;
            font-size: 10px;
        }

        /* ================================
           GIFT CARD
        ================================= */

        .gift-card {
            position: relative;
            overflow: hidden;
            min-height: 185px;
            border-radius: 18px;
            padding: 20px;
            color: #fff;
            transition: .3s;
        }

        .gift-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, .12);
        }

        .gift-card::after {
            content: "";
            position: absolute;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            right: -45px;
            bottom: -55px;
            background: rgba(255, 255, 255, .12);
        }

        .gift-card::before {
            content: "";
            position: absolute;
            width: 75px;
            height: 75px;
            border-radius: 50%;
            right: 35px;
            top: -35px;
            background: rgba(255, 255, 255, .09);
        }

        .gift-card-content {
            position: relative;
            z-index: 2;
        }

        .gift-brand {
            font-size: 12px;
            font-weight: 700;
            opacity: .85;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .gift-card h5 {
            font-weight: 800;
            margin: 12px 0 6px;
        }

        .gift-card p {
            font-size: 11px;
            opacity: .84;
            margin-bottom: 20px;
        }

        .gift-price {
            font-size: 16px;
            font-weight: 800;
        }

        .gift-buy {
            position: absolute;
            right: 17px;
            bottom: 17px;
            z-index: 5;
            border: 0;
            padding: 8px 13px;
            border-radius: 9px;
            color: blueviolet;
            background: #fff;
            font-size: 11px;
            font-weight: 800;
            text-decoration: none;
        }

        .gift-buy:hover {
            color: #4b49f5;
        }

        /* ================================
           GIFT COLORS
        ================================= */

        .amazon {
            background: linear-gradient(135deg, #232f3e, #53677c);
        }

        .apple {
            background: linear-gradient(135deg, #111, #555);
        }

        .google {
            background: linear-gradient(135deg, #4285f4, #34a853);
        }

        .steam {
            background: linear-gradient(135deg, #173b67, #2466a2);
        }

        .playstation {
            background: linear-gradient(135deg, #003791, #1e73be);
        }

        .xbox {
            background: linear-gradient(135deg, #107c10, #4caf50);
        }

        .netflix {
            background: linear-gradient(135deg, #8b0000, #e50914);
        }

        .spotify {
            background: linear-gradient(135deg, #146b31, #1db954);
        }

        /* ================================
           RECENT PURCHASES
        ================================= */

        .purchase-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .purchase-item:last-child {
            border-bottom: 0;
        }

        .purchase-icon {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #f1ebff;
            color: blueviolet;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .purchase-info {
            flex: 1;
            min-width: 0;
        }

        .purchase-info strong {
            display: block;
            font-size: 13px;
        }

        .purchase-info small {
            display: block;
            color: #777;
            font-size: 10px;
            margin-top: 3px;
        }

        .purchase-amount {
            font-size: 12px;
            font-weight: 800;
        }

        /* ================================
           QUICK ACTIONS
        ================================= */

        .quick-action {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 12px;
            text-decoration: none;
            color: #333;
            border-radius: 12px;
            transition: .2s;
        }

        .quick-action:hover {
            background: #f6f0ff;
            color: blueviolet;
        }

        .quick-icon {
            width: 42px;
            height: 42px;
            border-radius: 11px;
            background: #f4edff;
            color: blueviolet;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        /* ================================
           EMPTY STATE
        ================================= */

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #777;
        }

        .empty-state i {
            font-size: 42px;
            color: #bbb;
        }

        /* ================================
           MOBILE NAV
        ================================= */

        .mobile-nav {
            display: none;
        }

        /* ================================
           RESPONSIVE
        ================================= */

        @media (max-width: 991px) {

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 18px;
                padding-bottom: 95px;
            }

            .gift-hero {
                padding: 28px 22px;
                min-height: 420px;
            }

            .mobile-nav {
                display: flex;
                position: fixed;
                z-index: 2000;
                bottom: 0;
                left: 0;
                right: 0;
                background: #fff;
                padding: 10px 4px;
                box-shadow: 0 -5px 20px rgba(0, 0, 0, .08);
                justify-content: space-around;
            }

            .mobile-nav a {
                text-decoration: none;
                color: #777;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 3px;
                font-size: 11px;
            }

            .mobile-nav a.active {
                color: blueviolet;
            }
        }

        @media (max-width: 575px) {

            .main-content {
                padding: 12px;
                padding-bottom: 90px;
            }

            .section-card {
                padding: 18px;
            }

            .topbar {
                padding: 15px;
            }

            .gift-card {
                min-height: 170px;
            }
        }
    </style>
</head>


<body>

    <!-- =========================================
         SIDEBAR
    ========================================== -->

    <aside class="sidebar">

        <div class="logo">

            @if(isset($setting) && $setting->logo)

                <img
                    src="{{ asset('storage/' . $setting->logo) }}"
                    width="38"
                    height="38"
                    class="rounded me-2"
                    alt="{{ $setting->site_name ?? 'BillVexa' }}"
                >

            @else

                <i class="bi bi-grid-fill me-2"></i>

            @endif

            {{ $setting->site_name ?? 'BillVexa' }}

        </div>


        <a
            href="{{ route('dashboard') }}"
            class="sidebar-link"
        >
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>


        <!-- SERVICES -->

        <a href="{{ route('service') }}"
            class="sidebar-link">

            <i class="bi bi-gear"></i>

            <span>
                Services
            </span>

        </a>


        <a
            href="{{ route('refer') }}"
            class="sidebar-link"
        >
            <i class="bi bi-people"></i>
            Refer & Earn
        </a>


        <a
            href="{{ route('history') }}"
            class="sidebar-link"
        >
            <i class="bi bi-clock-history"></i>
            Transactions
        </a>


        <a
            href="{{ route('profile.edit') }}"
            class="sidebar-link"
        >
            <i class="bi bi-person"></i>
            Profile
        </a>

    </aside>


    <!-- =========================================
         MAIN CONTENT
    ========================================== -->

    <main class="main-content">


        <!-- TOPBAR -->

        <div class="topbar">

            <h4 class="fw-bold mb-1">
                Gift Cards
            </h4>

            <p class="text-muted mb-0 small">
                Buy digital gift cards quickly and conveniently.
            </p>

        </div>


        <!-- =====================================
             HERO
        ====================================== -->

        <section class="gift-hero">

            <div class="gift-hero-content">

                <span class="badge bg-light text-dark rounded-pill px-3 py-2 mb-3">

                    <i class="bi bi-gift-fill me-1"></i>

                    {{ $setting->site_name ?? 'BillVexa' }} Gift Cards

                </span>


                <h1>
                    Give something they'll love.
                </h1>


                <p>
                    Discover digital gift cards for entertainment,
                    gaming, shopping, subscriptions and more.
                </p>


                <!-- SEARCH -->

                <form
                    action="{{ route('gift-card') }}"
                    method="GET"
                    class="search-card"
                >

                    <div class="row g-3">

                        <div class="col-md-9">

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="bi bi-search text-muted"></i>

                                </span>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Search gift cards..."
                                >

                            </div>

                        </div>


                        <div class="col-md-3">

                            <button
                                type="submit"
                                class="search-btn"
                            >

                                <i class="bi bi-search me-1"></i>

                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </section>


        <!-- =====================================
             CATEGORIES
        ====================================== -->

        <section class="section-card mb-4">

            <div class="section-title">

                <h5>
                    Browse Categories
                </h5>

                <a
                    href="{{ route('gift-card') }}"
                    class="view-all"
                >
                    View all
                </a>

            </div>


            <div class="row g-3">

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('gift-card', ['category' => 'shopping']) }}"
                        class="category-card active"
                    >

                        <div class="category-icon">

                            <i class="bi bi-bag-fill"></i>

                        </div>

                        <strong>
                            Shopping
                        </strong>

                        <small>
                            Shop & redeem
                        </small>

                    </a>

                </div>


                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('gift-card', ['category' => 'gaming']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-controller"></i>

                        </div>

                        <strong>
                            Gaming
                        </strong>

                        <small>
                            Games & credits
                        </small>

                    </a>

                </div>


                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('gift-card', ['category' => 'entertainment']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-play-circle-fill"></i>

                        </div>

                        <strong>
                            Entertainment
                        </strong>

                        <small>
                            Movies & music
                        </small>

                    </a>

                </div>


                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('gift-card', ['category' => 'subscriptions']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-credit-card-2-front-fill"></i>

                        </div>

                        <strong>
                            Subscriptions
                        </strong>

                        <small>
                            Digital services
                        </small>

                    </a>

                </div>

            </div>

        </section>


        <!-- =====================================
             POPULAR GIFT CARDS
        ====================================== -->

        <div class="row g-4">


            <!-- GIFT CARD GRID -->

            <div class="col-lg-8">

                <section class="section-card">

                    <div class="section-title">

                        <h5>
                            Popular Gift Cards
                        </h5>

                        <a
                            href="{{ route('gift-card') }}"
                            class="view-all"
                        >
                            View all
                        </a>

                    </div>


                    <div class="row g-3" id="giftCardGrid">


                        @php

                            $defaultGiftCards = [

                                [
                                    'name' => 'Amazon',
                                    'description' => 'Shop millions of products',
                                    'price' => '10,000',
                                    'class' => 'amazon',
                                    'icon' => 'bi-amazon',
                                    'category' => 'shopping'
                                ],

                                [
                                    'name' => 'Apple',
                                    'description' => 'Apps, music & entertainment',
                                    'price' => '10,000',
                                    'class' => 'apple',
                                    'icon' => 'bi-apple',
                                    'category' => 'entertainment'
                                ],

                                [
                                    'name' => 'Google Play',
                                    'description' => 'Apps, games & digital content',
                                    'price' => '10,000',
                                    'class' => 'google',
                                    'icon' => 'bi-google',
                                    'category' => 'gaming'
                                ],

                                [
                                    'name' => 'Steam',
                                    'description' => 'PC games & entertainment',
                                    'price' => '15,000',
                                    'class' => 'steam',
                                    'icon' => 'bi-controller',
                                    'category' => 'gaming'
                                ],

                                [
                                    'name' => 'PlayStation',
                                    'description' => 'Games & PlayStation Store',
                                    'price' => '15,000',
                                    'class' => 'playstation',
                                    'icon' => 'bi-controller',
                                    'category' => 'gaming'
                                ],

                                [
                                    'name' => 'Xbox',
                                    'description' => 'Games & Xbox content',
                                    'price' => '15,000',
                                    'class' => 'xbox',
                                    'icon' => 'bi-controller',
                                    'category' => 'gaming'
                                ],

                                [
                                    'name' => 'Netflix',
                                    'description' => 'Movies & TV shows',
                                    'price' => '12,000',
                                    'class' => 'netflix',
                                    'icon' => 'bi-film',
                                    'category' => 'subscriptions'
                                ],

                                [
                                    'name' => 'Spotify',
                                    'description' => 'Music & podcasts',
                                    'price' => '8,000',
                                    'class' => 'spotify',
                                    'icon' => 'bi-spotify',
                                    'category' => 'subscriptions'
                                ]

                            ];

                            $displayGiftCards =
                                isset($giftCards) && count($giftCards)
                                    ? $giftCards
                                    : $defaultGiftCards;

                        @endphp


                        @foreach($displayGiftCards as $card)

                            @php

                                $cardName =
                                    is_array($card)
                                        ? $card['name']
                                        : $card->name;

                                $cardDescription =
                                    is_array($card)
                                        ? $card['description']
                                        : ($card->description ?? '');

                                $cardPrice =
                                    is_array($card)
                                        ? $card['price']
                                        : ($card->price ?? 0);

                                $cardClass =
                                    is_array($card)
                                        ? $card['class']
                                        : ($card->css_class ?? 'amazon');

                                $cardIcon =
                                    is_array($card)
                                        ? $card['icon']
                                        : ($card->icon ?? 'bi-gift-fill');

                                $cardCategory =
                                    is_array($card)
                                        ? $card['category']
                                        : ($card->category ?? '');

                                $cardId =
                                    is_array($card)
                                        ? null
                                        : $card->id;

                            @endphp


                            <div
                                class="col-md-6 gift-card-item"
                                data-name="{{ strtolower($cardName) }}"
                                data-category="{{ strtolower($cardCategory) }}"
                            >

                                <div class="gift-card {{ $cardClass }}">

                                    <div class="gift-card-content">

                                        <div class="d-flex justify-content-between align-items-center">

                                            <div class="gift-brand">

                                                Digital Gift Card

                                            </div>


                                            <i
                                                class="{{ $cardIcon }}"
                                                style="font-size:28px"
                                            ></i>

                                        </div>


                                        <h5>
                                            {{ $cardName }}
                                        </h5>


                                        <p>
                                            {{ $cardDescription }}
                                        </p>


                                        <div class="gift-price">

                                            From ₦{{ number_format((float) str_replace(',', '', $cardPrice)) }}

                                        </div>

                                    </div>


                                    @if($cardId)

                                        <a
                                            href="{{ route('gift-card.buy', $cardId) }}"
                                            class="gift-buy"
                                        >
                                            Buy Card
                                        </a>

                                    @else

                                        <a
                                            href="{{ route('gift-card') }}"
                                            class="gift-buy"
                                        >
                                            Buy Card
                                        </a>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if(isset($giftCards) && count($giftCards) === 0)

                        <div class="empty-state">

                            <i class="bi bi-gift"></i>

                            <h6 class="fw-bold mt-3">
                                No gift cards found
                            </h6>

                            <p class="small mb-0">
                                Try searching for another gift card.
                            </p>

                        </div>

                    @endif

                </section>

            </div>


            <!-- =================================
                 RIGHT COLUMN
            ================================== -->

            <div class="col-lg-4">


                <!-- RECENT PURCHASES -->

                <section class="section-card mb-4">

                    <div class="section-title">

                        <h5>
                            Recent Purchases
                        </h5>

                        <a
                            href="{{ route('history') }}"
                            class="view-all"
                        >
                            History
                        </a>

                    </div>


                    @if(isset($giftCardPurchases) && count($giftCardPurchases))

                        @foreach($giftCardPurchases->take(4) as $purchase)

                            <div class="purchase-item">

                                <div class="purchase-icon">

                                    <i class="bi bi-gift-fill"></i>

                                </div>


                                <div class="purchase-info">

                                    <strong>
                                        {{ $purchase->gift_card_name ?? 'Gift Card' }}
                                    </strong>

                                    <small>
                                        {{ $purchase->created_at?->format('M d, Y') ?? 'Recent purchase' }}
                                    </small>

                                </div>


                                <div class="purchase-amount">

                                    ₦{{ number_format((float) ($purchase->amount ?? 0)) }}

                                </div>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-state py-4">

                            <i class="bi bi-gift"></i>

                            <h6 class="fw-bold mt-3">
                                No purchases yet
                            </h6>

                            <p class="small mb-0">
                                Your gift card purchases will appear here.
                            </p>

                        </div>

                    @endif

                </section>


                <!-- =================================
                     QUICK ACTIONS
                ================================== -->

                <section class="section-card mb-4">

                    <h5 class="fw-bold mb-3">
                        Quick Actions
                    </h5>


                    <a
                        href="{{ route('gift-card') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-search"></i>

                        </div>

                        <div>

                            <strong>
                                Find Gift Card
                            </strong>

                            <small class="d-block text-muted">
                                Browse available cards
                            </small>

                        </div>

                    </a>


                    <a
                        href="{{ route('history') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-clock-history"></i>

                        </div>

                        <div>

                            <strong>
                                Transaction History
                            </strong>

                            <small class="d-block text-muted">
                                View your payments
                            </small>

                        </div>

                    </a>


                    <a
                        href="{{ route('refer') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-people"></i>

                        </div>

                        <div>

                            <strong>
                                Refer & Earn
                            </strong>

                            <small class="d-block text-muted">
                                Invite friends to {{ $setting->site_name ?? 'BillVexa' }}
                            </small>

                        </div>

                    </a>

                </section>


                <!-- =================================
                     INFO CARD
                ================================== -->

                <section class="section-card">

                    <div class="text-center">

                        <div
                            class="category-icon mx-auto mb-3"
                            style="width:60px;height:60px"
                        >

                            <i class="bi bi-shield-check"></i>

                        </div>


                        <h5 class="fw-bold">
                            Shop with confidence
                        </h5>


                        <p class="text-muted small mb-0">

                            Choose your gift card, select the
                            denomination and complete your purchase
                            through {{ $setting->site_name ?? 'BillVexa' }}.

                        </p>

                    </div>

                </section>

            </div>

        </div>

    </main>


    <!-- =========================================
         MOBILE NAVIGATION
    ========================================== -->

    <nav class="mobile-nav">

        <a href="{{ route('dashboard') }}">

            <i class="bi bi-grid-fill"></i>

            <span>
                Home
            </span>

        </a>


       <a href="{{ route('service') }}">

            <i class="bi bi-gear"></i>

            <small>
                Services
            </small>

        </a>


        <a href="{{ route('refer') }}">

            <i class="bi bi-people"></i>

            <span>
                Refer
            </span>

        </a>


        <a href="{{ route('history') }}">

            <i class="bi bi-clock-history"></i>

            <span>
                History
            </span>

        </a>


        <a href="{{ route('profile.edit') }}">

            <i class="bi bi-person"></i>

            <span>
                Profile
            </span>

        </a>

    </nav>


    <!-- =========================================
         JAVASCRIPT
    ========================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.querySelector('input[name="search"]');

            const giftCards =
                document.querySelectorAll('.gift-card-item');


            /*
            =========================================
            LIVE GIFT CARD SEARCH
            =========================================
            */

            if (searchInput) {

                searchInput.addEventListener('input', function () {

                    const query =
                        this.value.toLowerCase().trim();


                    giftCards.forEach(function (card) {

                        const name =
                            card.dataset.name || '';

                        const category =
                            card.dataset.category || '';


                        if (
                            name.includes(query) ||
                            category.includes(query)
                        ) {

                            card.style.display = '';

                        } else {

                            card.style.display = 'none';

                        }

                    });

                });

            }

        });

    </script>

</body>

</html>
