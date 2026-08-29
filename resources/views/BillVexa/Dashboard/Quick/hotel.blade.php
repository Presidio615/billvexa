<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $setting->site_name ?? 'BillVexa' }} - Hotels</title>

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

        /* SIDEBAR */
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

        /* MAIN */
        .main-content {
            margin-left: 260px;
            padding: 28px;
            min-height: 100vh;
        }

        /* TOP BAR */
        .topbar {
            background: #fff;
            border-radius: 18px;
            padding: 17px 22px;
            margin-bottom: 25px;
            box-shadow: 0 5px 22px rgba(0, 0, 0, .05);
        }

        /* HERO */
        .hotel-hero {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
            padding: 40px;
            min-height: 330px;
            color: #fff;
            margin-bottom: 25px;

            background:
                linear-gradient(
                    90deg,
                    rgba(44, 22, 75, .94),
                    rgba(74, 45, 140, .78)
                ),
                url("https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80")
                center/cover;
        }

        .hotel-hero-content {
            position: relative;
            z-index: 2;
            max-width: 650px;
        }

        .hotel-hero h1 {
            font-size: clamp(30px, 5vw, 48px);
            font-weight: 800;
            margin-bottom: 12px;
        }

        .hotel-hero p {
            opacity: .88;
            font-size: 16px;
            line-height: 1.7;
        }

        /* SEARCH BOX */
        .search-card {
            position: relative;
            z-index: 5;
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            margin-top: 28px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .15);
        }

        .search-card label {
            font-size: 12px;
            font-weight: 700;
            color: #666;
            margin-bottom: 7px;
        }

        .search-card .form-control,
        .search-card .form-select {
            min-height: 48px;
            border-radius: 11px;
            border: 1px solid #e2e2e2;
        }

        .search-card .form-control:focus,
        .search-card .form-select:focus {
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

        /* SECTION CARD */
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

        /* DESTINATIONS */
        .destination-card {
            position: relative;
            overflow: hidden;
            height: 175px;
            border-radius: 17px;
            text-decoration: none;
            display: block;
            background: #ddd;
        }

        .destination-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .35s;
        }

        .destination-card:hover img {
            transform: scale(1.08);
        }

        .destination-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: flex-end;
            padding: 17px;
            color: #fff;
            background: linear-gradient(
                transparent,
                rgba(0, 0, 0, .72)
            );
        }

        .destination-overlay h6 {
            font-weight: 800;
            margin: 0;
        }

        .destination-overlay small {
            opacity: .85;
        }

        /* HOTEL CARD */
        .hotel-card {
            background: #fff;
            border-radius: 18px;
            overflow: hidden;
            border: 1px solid #e9e9e9;
            transition: .3s;
            height: 100%;
        }

        .hotel-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .08);
        }

        .hotel-image {
            position: relative;
            height: 190px;
        }

        .hotel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hotel-badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #fff;
            color: blueviolet;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 800;
        }

        .favorite-btn {
            position: absolute;
            right: 12px;
            top: 12px;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .95);
            color: #555;
        }

        .favorite-btn.saved {
            color: #e63946;
        }

        .hotel-body {
            padding: 17px;
        }

        .hotel-name {
            font-weight: 800;
            font-size: 17px;
            margin-bottom: 5px;
        }

        .hotel-location {
            color: #777;
            font-size: 12px;
            margin-bottom: 10px;
        }

        .hotel-rating {
            color: #f4a300;
            font-size: 12px;
        }

        .rating-number {
            color: #555;
            margin-left: 5px;
        }

        .hotel-bottom {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-top: 15px;
        }

        .hotel-price strong {
            font-size: 19px;
        }

        .hotel-price small {
            color: #777;
        }

        .book-btn {
            text-decoration: none;
            background: linear-gradient(135deg, blueviolet, #4b49f5);
            color: #fff;
            padding: 9px 14px;
            border-radius: 9px;
            font-size: 12px;
            font-weight: 700;
        }

        .book-btn:hover {
            color: #fff;
        }

        /* BOOKINGS */
        .booking-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .booking-item:last-child {
            border-bottom: 0;
        }

        .booking-image {
            width: 62px;
            height: 62px;
            border-radius: 12px;
            object-fit: cover;
        }

        .booking-info {
            flex: 1;
            min-width: 0;
        }

        .booking-info strong {
            display: block;
            font-size: 13px;
        }

        .booking-info small {
            color: #777;
            font-size: 11px;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 800;
        }

        .status.confirmed {
            background: #e9f9ef;
            color: #198754;
        }

        .status.pending {
            background: #fff4dc;
            color: #b77900;
        }

        .status.cancelled {
            background: #ffe9eb;
            color: #dc3545;
        }

        /* QUICK ACTIONS */
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

        /* MOBILE NAV */
        .mobile-nav {
            display: none;
        }

        /* EMPTY STATE */
        .empty-state {
            padding: 45px 20px;
            text-align: center;
            color: #777;
        }

        .empty-state i {
            font-size: 42px;
            color: #bbb;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;
                padding: 18px;
                padding-bottom: 95px;
            }

            .hotel-hero {
                padding: 28px 22px;
            }

            .search-card {
                margin-top: 22px;
            }

            .mobile-nav {
                display: flex;

                justify-content: space-around;

                align-items: center;

                position: fixed;

                bottom: 0;

                left: 0;

                width: 100%;

                background: white;

                padding: 12px 5px;

                box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.08);

                z-index: 2000;
            }

            .mobile-nav a {
                text-decoration: none;

                color: #666;

                font-size: 13px;

                display: flex;

                flex-direction: column;

                align-items: center;

                gap: 4px;
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

            .hotel-hero {
                min-height: 430px;
            }

            .section-card {
                padding: 18px;
            }

            .topbar {
                padding: 15px;
            }

            .destination-card {
                height: 145px;
            }

            .hotel-image {
                height: 175px;
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
         MAIN
    ========================================== -->

    <main class="main-content">


        <!-- TOPBAR -->

        <div class="topbar">

            <h4 class="fw-bold mb-1">
                Hotels
            </h4>

            <p class="text-muted mb-0 small">
                Find your perfect stay with {{ $setting->site_name ?? 'BillVexa' }}.
            </p>

        </div>


        <!-- =====================================
             HERO + SEARCH
        ====================================== -->

        <section class="hotel-hero">

            <div class="hotel-hero-content">

                <div class="mb-3">

                    <span class="badge bg-light text-dark rounded-pill px-3 py-2">

                        <i class="bi bi-stars me-1"></i>

                        {{ $setting->site_name ?? 'BillVexa' }} Hotels

                    </span>

                </div>


                <h1>
                    Find your perfect stay
                </h1>

                <p>
                    Search hotels, compare rooms and discover comfortable
                    places to stay for your next trip.
                </p>


                <!-- SEARCH -->

                <form
                    action="{{ route('hotel') }}"
                    method="GET"
                    class="search-card"
                >

                    <div class="row g-3">

                        <!-- DESTINATION -->

                        <div class="col-lg-4">

                            <label>
                                Destination
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="bi bi-geo-alt text-muted"></i>

                                </span>

                                <input
                                    type="text"
                                    name="location"
                                    value="{{ request('location') }}"
                                    class="form-control"
                                    placeholder="Where are you going?"
                                >

                            </div>

                        </div>


                        <!-- CHECK IN -->

                        <div class="col-md-6 col-lg-2">

                            <label>
                                Check-in
                            </label>

                            <input
                                type="date"
                                name="check_in"
                                value="{{ request('check_in') }}"
                                class="form-control"
                            >

                        </div>


                        <!-- CHECK OUT -->

                        <div class="col-md-6 col-lg-2">

                            <label>
                                Check-out
                            </label>

                            <input
                                type="date"
                                name="check_out"
                                value="{{ request('check_out') }}"
                                class="form-control"
                            >

                        </div>


                        <!-- GUESTS -->

                        <div class="col-md-6 col-lg-2">

                            <label>
                                Guests
                            </label>

                            <select
                                name="guests"
                                class="form-select"
                            >

                                <option value="1">
                                    1 Guest
                                </option>

                                <option value="2" selected>
                                    2 Guests
                                </option>

                                <option value="3">
                                    3 Guests
                                </option>

                                <option value="4">
                                    4 Guests
                                </option>

                                <option value="5">
                                    5+ Guests
                                </option>

                            </select>

                        </div>


                        <!-- SEARCH -->

                        <div class="col-md-6 col-lg-2 d-flex align-items-end">

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
             POPULAR DESTINATIONS
        ====================================== -->

        <section class="section-card mb-4">

            <div class="section-title">

                <h5>
                    Popular Destinations
                </h5>

                <a
                    href="{{ route('hotel') }}"
                    class="view-all"
                >
                    Explore all
                </a>

            </div>


            <div class="row g-3">

                @php

                    $defaultDestinations = [
                        [
                            'name' => 'Lagos',
                            'country' => 'Nigeria',
                            'image' => 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?auto=format&fit=crop&w=800&q=80'
                        ],
                        [
                            'name' => 'Abuja',
                            'country' => 'Nigeria',
                            'image' => 'https://images.unsplash.com/photo-1618828665011-0abd973f7bb8?auto=format&fit=crop&w=800&q=80'
                        ],
                        [
                            'name' => 'London',
                            'country' => 'United Kingdom',
                            'image' => 'https://images.unsplash.com/photo-1513635269975-59663e0ac1ad?auto=format&fit=crop&w=800&q=80'
                        ],
                        [
                            'name' => 'Dubai',
                            'country' => 'United Arab Emirates',
                            'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&w=800&q=80'
                        ]
                    ];

                    $displayDestinations =
                        isset($destinations) && count($destinations)
                            ? $destinations
                            : $defaultDestinations;

                @endphp


                @foreach($displayDestinations as $destination)

                    <div class="col-6 col-md-3">

                        <a
                            href="{{ route('hotel', ['location' => is_array($destination) ? $destination['name'] : $destination->name]) }}"
                            class="destination-card"
                        >

                            <img
                                src="{{ is_array($destination) ? $destination['image'] : asset('storage/' . $destination->image) }}"
                                alt="{{ is_array($destination) ? $destination['name'] : $destination->name }}"
                            >

                            <div class="destination-overlay">

                                <div>

                                    <h6>
                                        {{ is_array($destination) ? $destination['name'] : $destination->name }}
                                    </h6>

                                    <small>
                                        {{ is_array($destination) ? $destination['country'] : ($destination->country ?? '') }}
                                    </small>

                                </div>

                            </div>

                        </a>

                    </div>

                @endforeach

            </div>

        </section>


        <!-- =====================================
             HOTEL GRID + SIDEBAR
        ====================================== -->

        <div class="row g-4">


            <!-- HOTELS -->

            <div class="col-lg-8">

                <section class="section-card">

                    <div class="section-title">

                        <h5>
                            Recommended Hotels
                        </h5>

                        <a
                            href="{{ route('hotel') }}"
                            class="view-all"
                        >
                            View all
                        </a>

                    </div>


                    <div class="row g-3">

                        @php

                            $defaultHotels = [

                                [
                                    'name' => 'Luxury City Hotel',
                                    'location' => 'Victoria Island, Lagos',
                                    'rating' => '4.8',
                                    'reviews' => '128',
                                    'price' => '85,000',
                                    'image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=900&q=80'
                                ],

                                [
                                    'name' => 'Grand Central Hotel',
                                    'location' => 'Central Area, Abuja',
                                    'rating' => '4.7',
                                    'reviews' => '94',
                                    'price' => '72,000',
                                    'image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=900&q=80'
                                ],

                                [
                                    'name' => 'Ocean View Resort',
                                    'location' => 'Lekki, Lagos',
                                    'rating' => '4.6',
                                    'reviews' => '76',
                                    'price' => '98,000',
                                    'image' => 'https://images.unsplash.com/photo-1540541338287-41700207dee6?auto=format&fit=crop&w=900&q=80'
                                ],

                                [
                                    'name' => 'Royal Garden Hotel',
                                    'location' => 'Wuse, Abuja',
                                    'rating' => '4.5',
                                    'reviews' => '63',
                                    'price' => '65,000',
                                    'image' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=900&q=80'
                                ]

                            ];

                            $displayHotels =
                                isset($hotels) && count($hotels)
                                    ? $hotels
                                    : $defaultHotels;

                        @endphp


                        @foreach($displayHotels as $hotel)

                            @php

                                $hotelName =
                                    is_array($hotel)
                                        ? $hotel['name']
                                        : $hotel->name;

                                $hotelLocation =
                                    is_array($hotel)
                                        ? $hotel['location']
                                        : ($hotel->location ?? '');

                                $hotelRating =
                                    is_array($hotel)
                                        ? $hotel['rating']
                                        : ($hotel->rating ?? '0');

                                $hotelReviews =
                                    is_array($hotel)
                                        ? $hotel['reviews']
                                        : ($hotel->reviews ?? '0');

                                $hotelPrice =
                                    is_array($hotel)
                                        ? $hotel['price']
                                        : ($hotel->price ?? '0');

                                $hotelImage =
                                    is_array($hotel)
                                        ? $hotel['image']
                                        : asset('storage/' . $hotel->image);

                                $hotelId =
                                    is_array($hotel)
                                        ? null
                                        : $hotel->id;

                            @endphp


                            <div
                                class="col-md-6 hotel-item"
                                data-name="{{ strtolower($hotelName) }}"
                                data-location="{{ strtolower($hotelLocation) }}"
                            >

                                <div class="hotel-card">

                                    <div class="hotel-image">

                                        <img
                                            src="{{ $hotelImage }}"
                                            alt="{{ $hotelName }}"
                                            loading="lazy"
                                        >


                                        <span class="hotel-badge">

                                            <i class="bi bi-star-fill me-1"></i>

                                            Top Rated

                                        </span>


                                        <button
                                            type="button"
                                            class="favorite-btn"
                                            onclick="toggleFavorite(this)"
                                            aria-label="Save hotel"
                                        >

                                            <i class="bi bi-heart"></i>

                                        </button>

                                    </div>


                                    <div class="hotel-body">

                                        <div class="hotel-name">

                                            {{ $hotelName }}

                                        </div>


                                        <div class="hotel-location">

                                            <i class="bi bi-geo-alt me-1"></i>

                                            {{ $hotelLocation }}

                                        </div>


                                        <div class="hotel-rating">

                                            @for($i = 1; $i <= 5; $i++)

                                                @if($i <= round((float) $hotelRating))

                                                    <i class="bi bi-star-fill"></i>

                                                @else

                                                    <i class="bi bi-star"></i>

                                                @endif

                                            @endfor

                                            <span class="rating-number">

                                                {{ $hotelRating }}
                                                ({{ $hotelReviews }} reviews)

                                            </span>

                                        </div>


                                        <div class="hotel-bottom">

                                            <div class="hotel-price">

                                                <strong>
                                                    ₦{{ number_format((float) str_replace(',', '', $hotelPrice)) }}
                                                </strong>

                                                <small>
                                                    / night
                                                </small>

                                            </div>


                                            @if($hotelId)

                                                <a
                                                    href="{{ route('hotel', $hotelId) }}"
                                                    class="book-btn"
                                                >
                                                    View Hotel
                                                </a>

                                            @else

                                                <a
                                                    href=""
                                                    class="book-btn"
                                                >
                                                    View Hotel
                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if(isset($hotels) && count($hotels) === 0)

                        <div class="empty-state">

                            <i class="bi bi-building-x"></i>

                            <h6 class="fw-bold mt-3">
                                No hotels found
                            </h6>

                            <p class="small mb-0">
                                Try searching another destination.
                            </p>

                        </div>

                    @endif

                </section>

            </div>


            <!-- RIGHT COLUMN -->

            <div class="col-lg-4">


                <!-- MY BOOKINGS -->

                <section class="section-card mb-4">

                    <div class="section-title">

                        <h5>
                            My Bookings
                        </h5>

                        <a
                            href=""
                            class="view-all"
                        >
                            View all
                        </a>

                    </div>


                    @if(isset($bookings) && count($bookings))

                        @foreach($bookings->take(3) as $booking)

                            <div class="booking-item">

                                <img
                                    class="booking-image"
                                    src="{{ $booking->hotel_image
                                        ? asset('storage/' . $booking->hotel_image)
                                        : 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=300&q=80'
                                    }}"
                                    alt="Hotel"
                                >


                                <div class="booking-info">

                                    <strong>
                                        {{ $booking->hotel_name ?? 'Hotel Booking' }}
                                    </strong>

                                    <small>

                                        {{ $booking->check_in ?? '--' }}

                                        -

                                        {{ $booking->check_out ?? '--' }}

                                    </small>

                                </div>


                                <span
                                    class="status {{ strtolower($booking->status ?? 'pending') }}"
                                >
                                    {{ ucfirst($booking->status ?? 'Pending') }}
                                </span>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-state py-4">

                            <i class="bi bi-calendar-x"></i>

                            <h6 class="fw-bold mt-3">
                                No bookings yet
                            </h6>

                            <p class="small mb-3">
                                Your hotel reservations will appear here.
                            </p>

                            <a
                                href="#search"
                                onclick="document.querySelector('.hotel-hero').scrollIntoView({behavior:'smooth'})"
                                class="book-btn"
                            >
                                Find a Hotel
                            </a>

                        </div>

                    @endif

                </section>


                <!-- QUICK ACTIONS -->

                <section class="section-card mb-4">

                    <h5 class="fw-bold mb-3">
                        Quick Actions
                    </h5>


                    <a
                        href="{{ route('hotel') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-search"></i>

                        </div>

                        <div>

                            <strong>
                                Find a Hotel
                            </strong>

                            <small class="d-block text-muted">
                                Search available hotels
                            </small>

                        </div>

                    </a>


                    <a
                        href=""
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-calendar-check"></i>

                        </div>

                        <div>

                            <strong>
                                My Bookings
                            </strong>

                            <small class="d-block text-muted">
                                Manage your reservations
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
                                Payment History
                            </strong>

                            <small class="d-block text-muted">
                                View your transactions
                            </small>

                        </div>

                    </a>

                </section>


                <!-- HOTEL BENEFITS -->

                <section class="section-card">

                    <h5 class="fw-bold mb-3">
                        Why Book With {{ $setting->site_name ?? 'BillVexa' }}?
                    </h5>


                    <div class="booking-item">

                        <div class="quick-icon">

                            <i class="bi bi-shield-check"></i>

                        </div>

                        <div class="booking-info">

                            <strong>
                                Secure Booking
                            </strong>

                            <small>
                                Your reservation information is protected.
                            </small>

                        </div>

                    </div>


                    <div class="booking-item">

                        <div class="quick-icon">

                            <i class="bi bi-building-check"></i>

                        </div>

                        <div class="booking-info">

                            <strong>
                                Quality Stays
                            </strong>

                            <small>
                                Discover comfortable accommodation options.
                            </small>

                        </div>

                    </div>


                    <div class="booking-item">

                        <div class="quick-icon">

                            <i class="bi bi-headset"></i>

                        </div>

                        <div class="booking-info">

                            <strong>
                                Easy Management
                            </strong>

                            <small>
                                Manage your bookings from your dashboard.
                            </small>

                        </div>

                    </div>

                </section>

            </div>

        </div>

    </main>


    <!-- =========================================
         MOBILE NAVIGATION
    ========================================== -->

    <div class="mobile-nav d-flex d-lg-none justify-content-around align-items-center">

<!-- Home -->
<a href="{{ route('dashboard') }}">

    <i class="bi bi-grid-fill"></i>

    <small>
        Home
    </small>

</a>


<!-- Services -->
<a href="{{ route('service') }}">

    <i class="bi bi-gear"></i>

    <small>
        Services
    </small>

</a>


<!-- Refer -->
<a href="{{ route('refer') }}">

    <i class="bi bi-people"></i>

    <small>
        Refer & Earn
    </small>

</a>


<!-- History -->
<a href="{{ route('history') }}">

    <i class="bi bi-clock-history"></i>

    <small>
        History
    </small>

</a>


<!-- Profile -->
<a href="{{ route('profile.edit') }}">

    <i class="bi bi-person-lines-fill"></i>

    <small>
        Profile
    </small>

</a>

</div>


    <!-- =========================================
         JAVASCRIPT
    ========================================== -->

    <script>

        /* =====================================
           FAVORITE HOTEL
        ====================================== */

        function toggleFavorite(button) {

            button.classList.toggle('saved');

            const icon =
                button.querySelector('i');

            if (button.classList.contains('saved')) {

                icon.classList.remove('bi-heart');

                icon.classList.add('bi-heart-fill');

            } else {

                icon.classList.remove('bi-heart-fill');

                icon.classList.add('bi-heart');

            }

        }


        /* =====================================
           PREVENT INVALID DATES
        ====================================== */

        const checkIn =
            document.querySelector('input[name="check_in"]');

        const checkOut =
            document.querySelector('input[name="check_out"]');


        if (checkIn && checkOut) {

            const today =
                new Date().toISOString().split('T')[0];

            checkIn.min = today;

            checkOut.min = today;


            checkIn.addEventListener('change', function () {

                checkOut.min = this.value;

                if (
                    checkOut.value &&
                    checkOut.value <= this.value
                ) {

                    checkOut.value = '';

                }

            });

        }


        /* =====================================
           SEARCH FILTER
        ====================================== */

        const hotelSearch =
            document.querySelector('input[name="location"]');

        const hotelItems =
            document.querySelectorAll('.hotel-item');


        if (hotelSearch) {

            hotelSearch.addEventListener(
                'input',
                function () {

                    const query =
                        this.value.toLowerCase().trim();


                    hotelItems.forEach(item => {

                        const name =
                            item.dataset.name || '';

                        const location =
                            item.dataset.location || '';


                        if (
                            name.includes(query) ||
                            location.includes(query)
                        ) {

                            item.style.display = '';

                        } else {

                            item.style.display = 'none';

                        }

                    });

                }
            );

        }

    </script>

</body>

</html>

