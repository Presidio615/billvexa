<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Sports
    </title>

    <!-- Favicon -->
    <link
        rel="shortcut icon"
        href="../../../Assets/Image/icon.png"
        type="image/x-icon"
    >

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

    <style>

        /* ========================================
           GLOBAL
        ======================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f7fe;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }


        /* ========================================
           SIDEBAR
        ======================================== */

        .sidebar {
            width: 260px;
            height: 100vh;

            position: fixed;
            top: 0;
            left: 0;

            background:linear-gradient(
                180deg,
                #5b21b6,
                #2563eb
            );
            padding: 25px 15px;

            z-index: 1000;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;

            color: rgba(255, 255, 255, 0.8);

            text-decoration: none;

            padding: 14px 16px;

            border-radius: 14px;

            margin-bottom: 10px;

            transition: 0.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);

            color: white;

            transform: translateX(5px);
        }


        /* ========================================
           MAIN CONTENT
        ======================================== */

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }


        /* ========================================
           TOPBAR
        ======================================== */

        .topbar {
            background: white;

            padding: 18px 25px;

            border-radius: 20px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);

            margin-bottom: 30px;
        }


        /* ========================================
           CARDS
        ======================================== */

        .custom-card {
            background: white;

            border-radius: 22px;

            padding: 25px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }


        /* ========================================
           SPORTS HERO
        ======================================== */

        .sports-hero {
            background: linear-gradient(
                135deg,
                blueviolet,
                #4b49f5
            );

            border-radius: 22px;

            padding: 30px;

            color: white;

            position: relative;

            overflow: hidden;

            margin-bottom: 25px;
        }

        .sports-hero::after {
            content: "";

            position: absolute;

            width: 180px;
            height: 180px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.08);

            right: -50px;
            top: -60px;
        }

        .sports-hero::before {
            content: "";

            position: absolute;

            width: 120px;
            height: 120px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.06);

            right: 100px;
            bottom: -70px;
        }

        .hero-icon {
            width: 65px;
            height: 65px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: rgba(255, 255, 255, 0.15);

            border-radius: 18px;

            font-size: 30px;

            margin-bottom: 18px;
        }


        /* ========================================
           SPORTS CATEGORY
        ======================================== */

        .sport-category {
            background: white;

            border: 1px solid #e8e8e8;

            border-radius: 18px;

            padding: 20px;

            text-align: center;

            cursor: pointer;

            transition: 0.3s ease;

            height: 100%;
        }

        .sport-category:hover,
        .sport-category.active {
            border-color: blueviolet;

            background: #f8f4ff;

            transform: translateY(-4px);
        }

        .sport-category i {
            font-size: 27px;

            color: blueviolet;

            margin-bottom: 10px;
        }

        .sport-category h6 {
            margin: 0;

            font-weight: 700;
        }


        /* ========================================
           MATCH CARD
        ======================================== */

        .match-card {
            background: white;

            border: 1px solid #e7e7e7;

            border-radius: 18px;

            padding: 20px;

            transition: 0.3s ease;
        }

        .match-card:hover {
            border-color: #d4c1f5;

            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);

            transform: translateY(-3px);
        }


        /* ========================================
           LIVE BADGE
        ======================================== */

        .live-badge {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            background: #ffecec;

            color: #dc3545;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }

        .live-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #dc3545;
        }


        /* ========================================
           UPCOMING BADGE
        ======================================== */

        .upcoming-badge {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            background: #f0ebff;

            color: blueviolet;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: bold;
        }


        /* ========================================
           TEAM
        ======================================== */

        .team {
            display: flex;

            align-items: center;

            gap: 10px;

            padding: 8px 0;
        }

        .team-logo {
            width: 38px;
            height: 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #f5f5f5;

            border-radius: 50%;

            color: blueviolet;

            font-size: 16px;
        }

        .team-name {
            font-weight: 600;
        }


        /* ========================================
           SCORE
        ======================================== */

        .score {
            font-size: 22px;

            font-weight: 800;

            text-align: right;
        }


        /* ========================================
           VIEW BUTTON
        ======================================== */

        .match-btn {
            border: 1px solid blueviolet;

            color: blueviolet;

            background: transparent;

            border-radius: 10px;

            padding: 8px 14px;

            text-decoration: none;

            display: inline-block;

            font-size: 13px;

            font-weight: 600;

            transition: 0.3s ease;
        }

        .match-btn:hover {
            background: blueviolet;

            color: white;
        }


        /* ========================================
           SEARCH
        ======================================== */

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;

            left: 15px;

            top: 50%;

            transform: translateY(-50%);

            color: #999;
        }

        .search-box input {
            padding-left: 43px;
        }


        /* ========================================
           QUICK ACTION
        ======================================== */

        .quick-action {
            display: flex;

            align-items: center;

            gap: 14px;

            padding: 13px;

            border-radius: 12px;

            text-decoration: none;

            color: #333;

            transition: 0.2s ease;
        }

        .quick-action:hover {
            background: #f6f1ff;

            color: blueviolet;
        }

        .quick-icon {
            width: 42px;
            height: 42px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: #f5efff;

            color: blueviolet;
        }


        /* ========================================
           EMPTY STATE
        ======================================== */

        .empty-state {
            text-align: center;

            padding: 50px 20px;
        }

        .empty-state i {
            font-size: 45px;

            color: #bbb;
        }


        /* ========================================
           MOBILE NAVIGATION
        ======================================== */

        .mobile-nav {
            display: none;
        }


        /* ========================================
           RESPONSIVE
        ======================================== */

        @media (max-width: 992px) {

            .sidebar {
                display: none;
            }

            .main-content {
                margin-left: 0;

                padding: 20px;

                padding-bottom: 100px;
            }

            .sports-hero {
                padding: 25px;
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

                font-size: 12px;

                display: flex;

                flex-direction: column;

                align-items: center;

                gap: 4px;
            }

            .mobile-nav a.active {
                color: blueviolet;
            }
        }

    </style>

</head>


<body>


    <!-- ========================================
         DESKTOP SIDEBAR
    ======================================== -->

    <div class="sidebar d-none d-lg-flex flex-column">

        <!-- Logo -->

        <h4 class="d-flex align-items-center logo mb-5 text-white fs-2 fw-bold">

            @if ($setting && $setting->logo)

                <img
                    src="{{ asset('storage/' . $setting->logo) }}"
                    width="40"
                    height="40"
                    class="rounded me-2"
                    alt="{{ $setting->site_name ?? 'BillVexa' }}"
                >

            @else

                <i class="bi bi-grid me-2"></i>

            @endif

            {{ $setting->site_name ?? 'BillVexa' }}

        </h4>


        <!-- Dashboard -->

        <a href="{{ route('dashboard') }}">

            <i class="bi bi-grid-fill"></i>

            Dashboard

        </a>


        <!-- Services -->

        <a href="{{ route('service') }}">

            <i class="bi bi-gear"></i>

            <span>
                Services
            </span>

        </a>


        <!-- Refer -->

        <a href="{{ route('refer') }}">

            <i class="bi bi-people"></i>

            Refer & Earn

        </a>


        <!-- Transactions -->

        <a href="{{ route('history') }}">

            <i class="bi bi-clock-history"></i>

            Transactions

        </a>


        <!-- Profile -->

        <a href="{{ route('profile.edit') }}">

            <i class="bi bi-person-lines-fill"></i>

            Profile

        </a>

    </div>



    <!-- ========================================
         MAIN CONTENT
    ======================================== -->

    <div class="main-content">


        <!-- ========================================
             TOPBAR
        ======================================== -->

        <div class="topbar">

            <div>

                <h3 class="fw-bold mb-1">
                    Sports
                </h3>

                <p class="text-muted mb-0">
                    Follow live matches, scores and upcoming sporting events.
                </p>

            </div>

        </div>



        <!-- ========================================
             HERO
        ======================================== -->

        <div class="sports-hero">

            <div class="hero-icon">

                <i class="bi bi-trophy-fill"></i>

            </div>

            <h2 class="fw-bold">
                Welcome to {{ $setting->site_name ?? 'BillVexa' }} Sports
            </h2>

            <p class="mb-0 opacity-75">
                Stay updated with live scores, upcoming matches and your favourite sports.
            </p>

        </div>



        <!-- ========================================
             SPORTS CATEGORIES
        ======================================== -->

        <div class="mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">
                    Sports
                </h5>

            </div>


            <div class="row g-3">


                <!-- Football -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('sports', ['sport' => 'football']) }}"
                        class="text-decoration-none"
                    >

                        <div class="sport-category active">

                            <i class="fa-solid fa-futbol"></i>

                            <h6>
                                Football
                            </h6>

                            <small class="text-muted">
                                Matches
                            </small>

                        </div>

                    </a>

                </div>


                <!-- Basketball -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('sports', ['sport' => 'basketball']) }}"
                        class="text-decoration-none"
                    >

                        <div class="sport-category">

                            <i class="fa-solid fa-basketball"></i>

                            <h6>
                                Basketball
                            </h6>

                            <small class="text-muted">
                                Matches
                            </small>

                        </div>

                    </a>

                </div>


                <!-- Tennis -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('sports', ['sport' => 'tennis']) }}"
                        class="text-decoration-none"
                    >

                        <div class="sport-category">

                            <i class="fa-solid fa-table-tennis-paddle-ball"></i>

                            <h6>
                                Tennis
                            </h6>

                            <small class="text-muted">
                                Matches
                            </small>

                        </div>

                    </a>

                </div>


                <!-- Other Sports -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('sports', ['sport' => 'other']) }}"
                        class="text-decoration-none"
                    >

                        <div class="sport-category">

                            <i class="bi bi-three-dots"></i>

                            <h6>
                                Other Sports
                            </h6>

                            <small class="text-muted">
                                Explore
                            </small>

                        </div>

                    </a>

                </div>

            </div>

        </div>



        <!-- ========================================
             SEARCH + FILTER
        ======================================== -->

        <div class="custom-card mb-4">

            <div class="row g-3 align-items-end">


                <!-- Search -->

                <div class="col-lg-6">

                    <label class="form-label fw-semibold">
                        Search Matches
                    </label>

                    <div class="search-box">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="matchSearch"
                            class="form-control"
                            placeholder="Search team, league or match..."
                        >

                    </div>

                </div>


                <!-- Sport Filter -->

                <div class="col-lg-3">

                    <label class="form-label fw-semibold">
                        Sport
                    </label>

                    <select
                        id="sportFilter"
                        class="form-select"
                    >

                        <option value="all">
                            All Sports
                        </option>

                        <option value="football">
                            Football
                        </option>

                        <option value="basketball">
                            Basketball
                        </option>

                        <option value="tennis">
                            Tennis
                        </option>

                    </select>

                </div>


                <!-- Status -->

                <div class="col-lg-3">

                    <label class="form-label fw-semibold">
                        Match Status
                    </label>

                    <select
                        id="statusFilter"
                        class="form-select"
                    >

                        <option value="all">
                            All Matches
                        </option>

                        <option value="live">
                            Live
                        </option>

                        <option value="upcoming">
                            Upcoming
                        </option>

                    </select>

                </div>

            </div>

        </div>



        <!-- ========================================
             LIVE MATCHES
        ======================================== -->

        <div class="mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-broadcast-pin text-danger me-2"></i>

                    Live Matches

                </h5>

                <span class="live-badge">

                    <span class="live-dot"></span>

                    LIVE

                </span>

            </div>


            <div
                id="matchesContainer"
                class="row g-3"
            >


                @isset($liveMatches)

                    @forelse ($liveMatches as $match)

                        <div
                            class="col-lg-6 match-item"
                            data-sport="{{ strtolower($match->sport ?? 'football') }}"
                            data-status="live"
                        >

                            <div class="match-card">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <div>

                                        <small class="text-muted">

                                            {{ $match->league ?? 'Sports League' }}

                                        </small>

                                    </div>

                                    <span class="live-badge">

                                        <span class="live-dot"></span>

                                        LIVE

                                    </span>

                                </div>


                                <div class="row align-items-center">

                                    <div class="col-8">


                                        <!-- Home Team -->

                                        <div class="team">

                                            <div class="team-logo">

                                                <i class="bi bi-shield-fill"></i>

                                            </div>

                                            <span class="team-name">

                                                {{ $match->home_team ?? 'Home Team' }}

                                            </span>

                                        </div>


                                        <!-- Away Team -->

                                        <div class="team">

                                            <div class="team-logo">

                                                <i class="bi bi-shield-fill"></i>

                                            </div>

                                            <span class="team-name">

                                                {{ $match->away_team ?? 'Away Team' }}

                                            </span>

                                        </div>

                                    </div>


                                    <!-- Score -->

                                    <div class="col-4">

                                        <div class="score">

                                            {{ $match->home_score ?? 0 }}

                                        </div>

                                        <div class="score">

                                            {{ $match->away_score ?? 0 }}

                                        </div>

                                    </div>

                                </div>


                                <div class="border-top mt-3 pt-3 d-flex justify-content-between align-items-center">

                                    <small class="text-muted">

                                        {{ $match->minute ?? 'Live' }}

                                    </small>

                                    <a
                                        href="{{ route('sports.match', $match->id) }}"
                                        class="match-btn"
                                    >

                                        View Match

                                    </a>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="custom-card empty-state">

                                <i class="bi bi-broadcast"></i>

                                <h6 class="fw-bold mt-3">
                                    No live matches
                                </h6>

                                <p class="text-muted mb-0">
                                    There are currently no live matches available.
                                </p>

                            </div>

                        </div>

                    @endforelse

                @else

                    <!-- Demo Live Match -->

                    <div
                        class="col-lg-6 match-item"
                        data-sport="football"
                        data-status="live"
                    >

                        <div class="match-card">

                            <div class="d-flex justify-content-between align-items-center mb-3">

                                <small class="text-muted">
                                    Football
                                </small>

                                <span class="live-badge">

                                    <span class="live-dot"></span>

                                    LIVE

                                </span>

                            </div>


                            <div class="row align-items-center">

                                <div class="col-8">

                                    <div class="team">

                                        <div class="team-logo">

                                            <i class="bi bi-shield-fill"></i>

                                        </div>

                                        <span class="team-name">
                                            Home Team
                                        </span>

                                    </div>


                                    <div class="team">

                                        <div class="team-logo">

                                            <i class="bi bi-shield-fill"></i>

                                        </div>

                                        <span class="team-name">
                                            Away Team
                                        </span>

                                    </div>

                                </div>


                                <div class="col-4">

                                    <div class="score">
                                        1
                                    </div>

                                    <div class="score">
                                        0
                                    </div>

                                </div>

                            </div>


                            <div class="border-top mt-3 pt-3 d-flex justify-content-between">

                                <small class="text-muted">
                                    67'
                                </small>

                                <a
                                    href="#"
                                    class="match-btn"
                                >
                                    View Match
                                </a>

                            </div>

                        </div>

                    </div>

                @endisset

            </div>

        </div>



        <!-- ========================================
             UPCOMING MATCHES
        ======================================== -->

        <div class="row g-4">


            <!-- ====================================
                 UPCOMING
            ==================================== -->

            <div class="col-lg-8">

                <div class="custom-card">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-calendar-event me-2"></i>

                            Upcoming Matches

                        </h5>

                        <a
                            href="{{ route('sports') }}"
                            class="text-decoration-none"
                        >
                            View All
                        </a>

                    </div>


                    <div id="upcomingMatches">


                        @isset($upcomingMatches)

                            @forelse ($upcomingMatches as $match)

                                <div
                                    class="match-card mb-3 match-item"
                                    data-sport="{{ strtolower($match->sport ?? 'football') }}"
                                    data-status="upcoming"
                                >

                                    <div class="d-flex justify-content-between align-items-center mb-3">

                                        <div>

                                            <small class="text-muted">

                                                {{ $match->league ?? 'Sports League' }}

                                            </small>

                                        </div>

                                        <span class="upcoming-badge">

                                            <i class="bi bi-clock"></i>

                                            Upcoming

                                        </span>

                                    </div>


                                    <div class="row align-items-center">

                                        <div class="col-md-7">

                                            <div class="team">

                                                <div class="team-logo">

                                                    <i class="bi bi-shield-fill"></i>

                                                </div>

                                                <span class="team-name">

                                                    {{ $match->home_team ?? 'Home Team' }}

                                                </span>

                                            </div>


                                            <div class="team">

                                                <div class="team-logo">

                                                    <i class="bi bi-shield-fill"></i>

                                                </div>

                                                <span class="team-name">

                                                    {{ $match->away_team ?? 'Away Team' }}

                                                </span>

                                            </div>

                                        </div>


                                        <div class="col-md-3 text-md-center mt-3 mt-md-0">

                                            <strong>

                                                {{ $match->match_date ?? 'Date' }}

                                            </strong>

                                            <small class="text-muted d-block">

                                                {{ $match->match_time ?? '--:--' }}

                                            </small>

                                        </div>


                                        <div class="col-md-2 text-md-end mt-3 mt-md-0">

                                            <a
                                                href="{{ route('sports.match', $match->id) }}"
                                                class="match-btn"
                                            >

                                                Details

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            @empty

                                <div class="empty-state">

                                    <i class="bi bi-calendar-x"></i>

                                    <h6 class="fw-bold mt-3">
                                        No upcoming matches
                                    </h6>

                                    <p class="text-muted mb-0">
                                        Check back later for upcoming games.
                                    </p>

                                </div>

                            @endforelse

                        @else

                            <!-- Demo Upcoming Match -->

                            <div
                                class="match-card mb-3 match-item"
                                data-sport="football"
                                data-status="upcoming"
                            >

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <small class="text-muted">
                                        Football
                                    </small>

                                    <span class="upcoming-badge">

                                        <i class="bi bi-clock"></i>

                                        Upcoming

                                    </span>

                                </div>


                                <div class="row align-items-center">

                                    <div class="col-md-7">

                                        <div class="team">

                                            <div class="team-logo">

                                                <i class="bi bi-shield-fill"></i>

                                            </div>

                                            <span class="team-name">
                                                Team A
                                            </span>

                                        </div>


                                        <div class="team">

                                            <div class="team-logo">

                                                <i class="bi bi-shield-fill"></i>

                                            </div>

                                            <span class="team-name">
                                                Team B
                                            </span>

                                        </div>

                                    </div>


                                    <div class="col-md-3 text-md-center mt-3 mt-md-0">

                                        <strong>
                                            Today
                                        </strong>

                                        <small class="text-muted d-block">
                                            18:00
                                        </small>

                                    </div>


                                    <div class="col-md-2 text-md-end mt-3 mt-md-0">

                                        <a
                                            href="#"
                                            class="match-btn"
                                        >
                                            Details
                                        </a>

                                    </div>

                                </div>

                            </div>


                            <div
                                class="match-card mb-3 match-item"
                                data-sport="basketball"
                                data-status="upcoming"
                            >

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <small class="text-muted">
                                        Basketball
                                    </small>

                                    <span class="upcoming-badge">

                                        <i class="bi bi-clock"></i>

                                        Upcoming

                                    </span>

                                </div>


                                <div class="row align-items-center">

                                    <div class="col-md-7">

                                        <div class="team">

                                            <div class="team-logo">

                                                <i class="fa-solid fa-basketball"></i>

                                            </div>

                                            <span class="team-name">
                                                Basketball Team A
                                            </span>

                                        </div>


                                        <div class="team">

                                            <div class="team-logo">

                                                <i class="fa-solid fa-basketball"></i>

                                            </div>

                                            <span class="team-name">
                                                Basketball Team B
                                            </span>

                                        </div>

                                    </div>


                                    <div class="col-md-3 text-md-center mt-3 mt-md-0">

                                        <strong>
                                            Tomorrow
                                        </strong>

                                        <small class="text-muted d-block">
                                            20:30
                                        </small>

                                    </div>


                                    <div class="col-md-2 text-md-end mt-3 mt-md-0">

                                        <a
                                            href="#"
                                            class="match-btn"
                                        >
                                            Details
                                        </a>

                                    </div>

                                </div>

                            </div>

                        @endisset

                    </div>

                </div>

            </div>



            <!-- ====================================
                 RIGHT SIDEBAR
            ==================================== -->

            <div class="col-lg-4">


                <!-- Quick Actions -->

                <div class="custom-card mb-3">

                    <h5 class="fw-bold mb-3">
                        Quick Actions
                    </h5>


                    <a
                        href="#live"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-broadcast"></i>

                        </div>

                        <div>

                            <strong>
                                Live Matches
                            </strong>

                            <small class="d-block text-muted">
                                Follow matches happening now
                            </small>

                        </div>

                    </a>


                    <a
                        href="#upcoming"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-calendar-event"></i>

                        </div>

                        <div>

                            <strong>
                                Upcoming
                            </strong>

                            <small class="d-block text-muted">
                                See upcoming matches
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
                                Sports History
                            </strong>

                            <small class="d-block text-muted">
                                View your sports activity
                            </small>

                        </div>

                    </a>

                </div>



                <!-- Sports Information -->

                <div class="custom-card">

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-info-circle me-2"></i>

                        Sports Information

                    </h6>


                    <div class="d-flex align-items-start mb-3">

                        <i
                            class="bi bi-broadcast text-danger me-3 mt-1"
                        ></i>

                        <div>

                            <strong>
                                Live Scores
                            </strong>

                            <div class="text-muted small">
                                Follow live match scores and updates.
                            </div>

                        </div>

                    </div>


                    <div class="d-flex align-items-start mb-3">

                        <i
                            class="bi bi-calendar-check text-primary me-3 mt-1"
                        ></i>

                        <div>

                            <strong>
                                Upcoming Games
                            </strong>

                            <div class="text-muted small">
                                Never miss an upcoming match.
                            </div>

                        </div>

                    </div>


                    <div class="d-flex align-items-start">

                        <i
                            class="bi bi-trophy text-warning me-3 mt-1"
                        ></i>

                        <div>

                            <strong>
                                Multiple Sports
                            </strong>

                            <div class="text-muted small">
                                Explore different sports and competitions.
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- ========================================
         MOBILE BOTTOM NAVIGATION
    ======================================== -->

    <div class="mobile-nav d-flex d-lg-none">


        <!-- Home -->

        <a href="{{ route('dashboard') }}">

            <i class="bi bi-grid-fill"></i>

            <small>
                Home
            </small>

        </a>


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
                Refer
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



    <!-- ========================================
         JAVASCRIPT
    ======================================== -->

    <script>

        /* ========================================
           MATCH SEARCH
        ======================================== */

        const matchSearch =
            document.getElementById('matchSearch');

        const sportFilter =
            document.getElementById('sportFilter');

        const statusFilter =
            document.getElementById('statusFilter');

        const matchItems =
            document.querySelectorAll('.match-item');


        function filterMatches() {

            const search =
                matchSearch.value.toLowerCase().trim();

            const sport =
                sportFilter.value.toLowerCase();

            const status =
                statusFilter.value.toLowerCase();


            matchItems.forEach(match => {

                const text =
                    match.textContent.toLowerCase();

                const matchSport =
                    match.dataset.sport;

                const matchStatus =
                    match.dataset.status;


                const matchesSearch =
                    text.includes(search);


                const matchesSport =
                    sport === 'all' ||
                    matchSport === sport;


                const matchesStatus =
                    status === 'all' ||
                    matchStatus === status;


                if (
                    matchesSearch &&
                    matchesSport &&
                    matchesStatus
                ) {

                    match.style.display = '';

                } else {

                    match.style.display = 'none';

                }

            });

        }


        if (matchSearch) {

            matchSearch.addEventListener(
                'input',
                filterMatches
            );

        }


        if (sportFilter) {

            sportFilter.addEventListener(
                'change',
                filterMatches
            );

        }


        if (statusFilter) {

            statusFilter.addEventListener(
                'change',
                filterMatches
            );

        }

    </script>


</body>

</html>