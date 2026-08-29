<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $setting->site_name ?? 'BillVexa' }} - Tickets</title>

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

        .ticket-hero {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
            padding: 42px;
            min-height: 325px;
            color: #fff;
            margin-bottom: 25px;

            background:
                linear-gradient(
                    90deg,
                    rgba(40, 18, 73, .96),
                    rgba(78, 47, 146, .78)
                ),
                url("https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=1600&q=80")
                center/cover;
        }

        .ticket-hero-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
        }

        .ticket-hero h1 {
            font-size: clamp(30px, 5vw, 48px);
            font-weight: 800;
            margin-bottom: 12px;
        }

        .ticket-hero p {
            opacity: .9;
            font-size: 16px;
            line-height: 1.7;
            max-width: 620px;
        }

        /* ================================
           SEARCH
        ================================= */

        .search-card {
            background: #fff;
            border-radius: 18px;
            padding: 18px;
            margin-top: 25px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, .15);
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

        /* ================================
           SECTIONS
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
            min-height: 120px;
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
            width: 52px;
            height: 52px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #eee7ff;
            color: blueviolet;
            font-size: 22px;
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
           EVENT CARD
        ================================= */

        .event-card {
            background: #fff;
            border: 1px solid #e9e9e9;
            border-radius: 18px;
            overflow: hidden;
            height: 100%;
            transition: .3s;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 13px 30px rgba(0, 0, 0, .08);
        }

        .event-image {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .35s;
        }

        .event-card:hover .event-image img {
            transform: scale(1.06);
        }

        .event-date {
            position: absolute;
            left: 12px;
            top: 12px;
            width: 54px;
            height: 57px;
            background: #fff;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .15);
        }

        .event-date strong {
            color: blueviolet;
            font-size: 18px;
            line-height: 18px;
        }

        .event-date small {
            color: #777;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .event-favorite {
            position: absolute;
            right: 12px;
            top: 12px;
            width: 36px;
            height: 36px;
            border: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, .94);
            color: #555;
        }

        .event-favorite.saved {
            color: #e63946;
        }

        .event-body {
            padding: 17px;
        }

        .event-type {
            color: blueviolet;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .4px;
            margin-bottom: 6px;
        }

        .event-name {
            font-weight: 800;
            font-size: 17px;
            margin-bottom: 8px;
        }

        .event-info {
            color: #777;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .event-info i {
            width: 16px;
            color: blueviolet;
        }

        .event-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 15px;
            padding-top: 13px;
            border-top: 1px solid #eee;
        }

        .event-price {
            font-size: 15px;
            font-weight: 800;
        }

        .event-price small {
            display: block;
            color: #777;
            font-size: 9px;
            font-weight: 400;
        }

        .ticket-btn {
            text-decoration: none;
            color: #fff;
            background: linear-gradient(135deg, blueviolet, #4b49f5);
            padding: 9px 13px;
            border-radius: 9px;
            font-size: 11px;
            font-weight: 700;
        }

        .ticket-btn:hover {
            color: #fff;
        }

        /* ================================
           UPCOMING TICKETS
        ================================= */

        .ticket-item {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 0;
            border-bottom: 1px solid #eee;
        }

        .ticket-item:last-child {
            border-bottom: 0;
        }

        .ticket-thumb {
            width: 61px;
            height: 61px;
            border-radius: 12px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .ticket-info {
            flex: 1;
            min-width: 0;
        }

        .ticket-info strong {
            display: block;
            font-size: 13px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .ticket-info small {
            display: block;
            color: #777;
            font-size: 10px;
            margin-top: 3px;
        }

        .ticket-status {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 800;
        }

        .ticket-status.confirmed {
            background: #e8f8ee;
            color: #198754;
        }

        .ticket-status.pending {
            background: #fff3d8;
            color: #ad7100;
        }

        .ticket-status.cancelled {
            background: #ffe9eb;
            color: #dc3545;
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

            .ticket-hero {
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

            .event-image {
                height: 165px;
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
                Tickets
            </h4>

            <p class="text-muted mb-0 small">
                Discover events and get your tickets with {{ $setting->site_name ?? 'BillVexa' }}.
            </p>

        </div>


        <!-- =====================================
             HERO
        ====================================== -->

        <section class="ticket-hero">

            <div class="ticket-hero-content">

                <span class="badge bg-light text-dark rounded-pill px-3 py-2 mb-3">

                    <i class="bi bi-ticket-perforated-fill me-1"></i>

                    {{ $setting->site_name ?? 'BillVexa' }} Tickets

                </span>


                <h1>
                    Your next experience starts here.
                </h1>


                <p>
                    Find concerts, movies, sports events, comedy shows,
                    festivals and other exciting experiences.
                </p>


                <!-- SEARCH -->

                <form
                    action="{{ route('ticket') }}"
                    method="GET"
                    class="search-card"
                >

                    <div class="row g-3">

                        <div class="col-md-6 col-lg-5">

                            <div class="input-group">

                                <span class="input-group-text bg-white">

                                    <i class="bi bi-search text-muted"></i>

                                </span>

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control"
                                    placeholder="Search events..."
                                >

                            </div>

                        </div>


                        <div class="col-md-3">

                            <select
                                name="category"
                                class="form-select"
                            >

                                <option value="">
                                    All categories
                                </option>

                                <option
                                    value="concert"
                                    {{ request('category') == 'concert' ? 'selected' : '' }}
                                >
                                    Concerts
                                </option>

                                <option
                                    value="sports"
                                    {{ request('category') == 'sports' ? 'selected' : '' }}
                                >
                                    Sports
                                </option>

                                <option
                                    value="movie"
                                    {{ request('category') == 'movie' ? 'selected' : '' }}
                                >
                                    Movies
                                </option>

                                <option
                                    value="comedy"
                                    {{ request('category') == 'comedy' ? 'selected' : '' }}
                                >
                                    Comedy
                                </option>

                                <option
                                    value="festival"
                                    {{ request('category') == 'festival' ? 'selected' : '' }}
                                >
                                    Festivals
                                </option>

                            </select>

                        </div>


                        <div class="col-md-3 col-lg-4">

                            <button
                                type="submit"
                                class="search-btn"
                            >

                                <i class="bi bi-search me-1"></i>

                                Find Tickets

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
                    Explore Categories
                </h5>

                <a
                    href="{{ route('ticket') }}"
                    class="view-all"
                >
                    View all
                </a>

            </div>


            <div class="row g-3">

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('ticket', ['category' => 'concert']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-music-note-beamed"></i>

                        </div>

                        <strong>
                            Concerts
                        </strong>

                        <small>
                            Live music
                        </small>

                    </a>

                </div>


                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('ticket', ['category' => 'sports']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-trophy-fill"></i>

                        </div>

                        <strong>
                            Sports
                        </strong>

                        <small>
                            Live matches
                        </small>

                    </a>

                </div>


                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('ticket', ['category' => 'movie']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-film"></i>

                        </div>

                        <strong>
                            Movies
                        </strong>

                        <small>
                            Cinema tickets
                        </small>

                    </a>

                </div>


                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('ticket', ['category' => 'comedy']) }}"
                        class="category-card"
                    >

                        <div class="category-icon">

                            <i class="bi bi-emoji-laughing-fill"></i>

                        </div>

                        <strong>
                            Comedy
                        </strong>

                        <small>
                            Comedy shows
                        </small>

                    </a>

                </div>

            </div>

        </section>


        <!-- =====================================
             EVENTS + UPCOMING TICKETS
        ====================================== -->

        <div class="row g-4">


            <!-- EVENTS -->

            <div class="col-lg-8">

                <section class="section-card">

                    <div class="section-title">

                        <h5>
                            Featured Events
                        </h5>

                        <a
                            href="{{ route('ticket') }}"
                            class="view-all"
                        >
                            View all
                        </a>

                    </div>


                    <div class="row g-3" id="eventGrid">

                        @php

                            $defaultEvents = [

                                [
                                    'name' => 'Live Music Festival',
                                    'category' => 'Concert',
                                    'location' => 'Lagos, Nigeria',
                                    'date' => '15',
                                    'month' => 'SEP',
                                    'full_date' => 'September 15, 2026',
                                    'price' => '25,000',
                                    'image' => 'https://images.unsplash.com/photo-1506157786151-b8491531f063?auto=format&fit=crop&w=900&q=80'
                                ],

                                [
                                    'name' => 'Championship Football',
                                    'category' => 'Sports',
                                    'location' => 'Abuja, Nigeria',
                                    'date' => '20',
                                    'month' => 'SEP',
                                    'full_date' => 'September 20, 2026',
                                    'price' => '15,000',
                                    'image' => 'https://images.unsplash.com/photo-1579952363873-27f3bade9f55?auto=format&fit=crop&w=900&q=80'
                                ],

                                [
                                    'name' => 'Comedy Night Live',
                                    'category' => 'Comedy',
                                    'location' => 'Lagos, Nigeria',
                                    'date' => '26',
                                    'month' => 'SEP',
                                    'full_date' => 'September 26, 2026',
                                    'price' => '12,000',
                                    'image' => 'https://images.unsplash.com/photo-1585699324551-f6c309eedeca?auto=format&fit=crop&w=900&q=80'
                                ],

                                [
                                    'name' => 'Movie Premiere',
                                    'category' => 'Movie',
                                    'location' => 'Ikeja, Lagos',
                                    'date' => '30',
                                    'month' => 'SEP',
                                    'full_date' => 'September 30, 2026',
                                    'price' => '8,000',
                                    'image' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?auto=format&fit=crop&w=900&q=80'
                                ]

                            ];


                            $displayEvents =
                                isset($events) && count($events)
                                    ? $events
                                    : $defaultEvents;

                        @endphp


                        @foreach($displayEvents as $event)

                            @php

                                $eventName =
                                    is_array($event)
                                        ? $event['name']
                                        : $event->name;

                                $eventCategory =
                                    is_array($event)
                                        ? $event['category']
                                        : ($event->category ?? 'Event');

                                $eventLocation =
                                    is_array($event)
                                        ? $event['location']
                                        : ($event->location ?? '');

                                $eventDate =
                                    is_array($event)
                                        ? $event['date']
                                        : ($event->date ?? '');

                                $eventMonth =
                                    is_array($event)
                                        ? $event['month']
                                        : ($event->month ?? '');

                                $eventFullDate =
                                    is_array($event)
                                        ? $event['full_date']
                                        : ($event->full_date ?? '');

                                $eventPrice =
                                    is_array($event)
                                        ? $event['price']
                                        : ($event->price ?? 0);

                                $eventImage =
                                    is_array($event)
                                        ? $event['image']
                                        : asset('storage/' . $event->image);

                                $eventId =
                                    is_array($event)
                                        ? null
                                        : $event->id;

                            @endphp


                            <div
                                class="col-md-6 event-item"
                                data-name="{{ strtolower($eventName) }}"
                                data-category="{{ strtolower($eventCategory) }}"
                            >

                                <div class="event-card">

                                    <div class="event-image">

                                        <img
                                            src="{{ $eventImage }}"
                                            alt="{{ $eventName }}"
                                            loading="lazy"
                                        >


                                        <div class="event-date">

                                            <strong>
                                                {{ $eventDate }}
                                            </strong>

                                            <small>
                                                {{ $eventMonth }}
                                            </small>

                                        </div>


                                        <button
                                            type="button"
                                            class="event-favorite"
                                            onclick="toggleFavorite(this)"
                                            aria-label="Save event"
                                        >

                                            <i class="bi bi-heart"></i>

                                        </button>

                                    </div>


                                    <div class="event-body">

                                        <div class="event-type">

                                            {{ $eventCategory }}

                                        </div>


                                        <div class="event-name">

                                            {{ $eventName }}

                                        </div>


                                        <div class="event-info">

                                            <i class="bi bi-calendar-event"></i>

                                            {{ $eventFullDate }}

                                        </div>


                                        <div class="event-info">

                                            <i class="bi bi-geo-alt-fill"></i>

                                            {{ $eventLocation }}

                                        </div>


                                        <div class="event-bottom">

                                            <div class="event-price">

                                                ₦{{ number_format((float) str_replace(',', '', $eventPrice)) }}

                                                <small>
                                                    per ticket
                                                </small>

                                            </div>


                                            @if($eventId)

                                                <a
                                                    href="{{ route('ticket', $eventId) }}"
                                                    class="ticket-btn"
                                                >
                                                    Get Ticket
                                                </a>

                                            @else

                                                <a
                                                    href="{{ route('ticket') }}"
                                                    class="ticket-btn"
                                                >
                                                    Get Ticket
                                                </a>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>


                    @if(isset($events) && count($events) === 0)

                        <div class="empty-state">

                            <i class="bi bi-calendar-x"></i>

                            <h6 class="fw-bold mt-3">
                                No events found
                            </h6>

                            <p class="small mb-0">
                                Try searching for another event.
                            </p>

                        </div>

                    @endif

                </section>

            </div>


            <!-- =================================
                 RIGHT COLUMN
            ================================== -->

            <div class="col-lg-4">


                <!-- UPCOMING TICKETS -->

                <section class="section-card mb-4">

                    <div class="section-title">

                        <h5>
                            My Tickets
                        </h5>

                        <a
                            href="{{ route('ticket') }}"
                            class="view-all"
                        >
                            View all
                        </a>

                    </div>


                    @if(isset($myTickets) && count($myTickets))

                        @foreach($myTickets->take(4) as $ticket)

                            <div class="ticket-item">

                                <img
                                    src="{{ $ticket->event_image
                                        ? asset('storage/' . $ticket->event_image)
                                        : 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=300&q=80'
                                    }}"
                                    class="ticket-thumb"
                                    alt="Event"
                                >


                                <div class="ticket-info">

                                    <strong>
                                        {{ $ticket->event_name ?? 'Event Ticket' }}
                                    </strong>

                                    <small>

                                        {{ $ticket->event_date ?? '--' }}

                                    </small>

                                </div>


                                <span
                                    class="ticket-status {{ strtolower($ticket->status ?? 'pending') }}"
                                >

                                    {{ ucfirst($ticket->status ?? 'Pending') }}

                                </span>

                            </div>

                        @endforeach

                    @else

                        <div class="empty-state py-4">

                            <i class="bi bi-ticket-perforated"></i>

                            <h6 class="fw-bold mt-3">
                                No tickets yet
                            </h6>

                            <p class="small mb-3">
                                Tickets you purchase will appear here.
                            </p>

                            <a
                                href="{{ route('ticket') }}"
                                class="ticket-btn"
                            >
                                Explore Events
                            </a>

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
                        href="{{ route('ticket') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-search"></i>

                        </div>

                        <div>

                            <strong>
                                Find an Event
                            </strong>

                            <small class="d-block text-muted">
                                Browse available events
                            </small>

                        </div>

                    </a>


                    <a
                        href="{{ route('ticket') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-ticket-perforated-fill"></i>

                        </div>

                        <div>

                            <strong>
                                My Tickets
                            </strong>

                            <small class="d-block text-muted">
                                View your purchased tickets
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
                     BENEFITS
                ================================== -->

                <section class="section-card">

                    <div class="text-center">

                        <div
                            class="category-icon mx-auto mb-3"
                            style="width:60px;height:60px"
                        >

                            <i class="bi bi-ticket-detailed-fill"></i>

                        </div>


                        <h5 class="fw-bold">
                            Keep your experiences organized
                        </h5>


                        <p class="text-muted small mb-0">

                            Purchase your tickets through {{ $setting->site_name ?? 'BillVexa' }}
                            and keep your event information accessible
                            from your dashboard.

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

        /*
        =========================================
        FAVORITE EVENT
        =========================================
        */

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


        /*
        =========================================
        LIVE SEARCH
        =========================================
        */

        document.addEventListener('DOMContentLoaded', function () {

            const searchInput =
                document.querySelector('input[name="search"]');

            const eventItems =
                document.querySelectorAll('.event-item');


            if (searchInput) {

                searchInput.addEventListener('input', function () {

                    const query =
                        this.value.toLowerCase().trim();


                    eventItems.forEach(function (event) {

                        const name =
                            event.dataset.name || '';

                        const category =
                            event.dataset.category || '';


                        if (
                            name.includes(query) ||
                            category.includes(query)
                        ) {

                            event.style.display = '';

                        } else {

                            event.style.display = 'none';

                        }

                    });

                });

            }

        });

    </script>

</body>

</html>

