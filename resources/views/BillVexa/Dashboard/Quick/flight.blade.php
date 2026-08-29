<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Fight
    </title>

    <link
        rel="shortcut icon"
        href="../../../Assets/Image/icon.png"
        type="image/x-icon"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    <style>

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

            background: linear-gradient(
                180deg,
                blueviolet,
                #4b49f5
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

            color: rgba(255, 255, 255, .8);

            text-decoration: none;

            padding: 14px 16px;

            border-radius: 14px;

            margin-bottom: 10px;

            transition: .3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, .15);

            color: white;

            transform: translateX(5px);
        }


        /* ========================================
           MAIN
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

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .05);

            margin-bottom: 25px;
        }


        /* ========================================
           CARD
        ======================================== */

        .custom-card {
            background: white;

            border-radius: 22px;

            padding: 25px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, .05);
        }


        /* ========================================
           HERO
        ======================================== */

        .flight-hero {
            background:linear-gradient(
                180deg,
                #5b21b6,
                #2563eb
            );

            border-radius: 22px;

            padding: 35px;

            color: white;

            position: relative;

            overflow: hidden;

            margin-bottom: 25px;
        }

        .flight-hero::before {
            content: "";

            position: absolute;

            width: 230px;
            height: 230px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, .07);

            right: -70px;
            top: -100px;
        }

        .flight-hero::after {
            content: "";

            position: absolute;

            width: 150px;
            height: 150px;

            border-radius: 50%;

            background:
                rgba(255, 255, 255, .05);

            right: 100px;
            bottom: -100px;
        }

        .hero-icon {
            width: 65px;
            height: 65px;

            display: flex;

            align-items: center;
            justify-content: center;

            background:
                rgba(255, 255, 255, .15);

            border-radius: 18px;

            font-size: 30px;

            margin-bottom: 18px;
        }


        /* ========================================
           FLIGHT TYPES
        ======================================== */

        .flight-type {
            background: white;

            border: 1px solid #e6e6e6;

            border-radius: 18px;

            padding: 20px;

            text-align: center;

            height: 100%;

            text-decoration: none;

            color: #222;

            display: block;

            transition: .3s ease;
        }

        .flight-type:hover,
        .flight-type.active {
            border-color: blueviolet;

            background: #f8f4ff;

            color: blueviolet;

            transform: translateY(-4px);
        }

        .flight-type i {
            font-size: 28px;

            margin-bottom: 10px;
        }

        .flight-type h6 {
            font-weight: 700;

            margin-bottom: 4px;
        }


        /* ========================================
           EVENT CARD
        ======================================== */

        .event-card {
            background: white;

            border-radius: 20px;

            overflow: hidden;

            border: 1px solid #e6e6e6;

            transition: .3s ease;
        }

        .event-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 10px 25px rgba(0, 0, 0, .07);
        }

        .event-header {
            background:
                linear-gradient(
                    135deg,
                    #171321,
                    #30264a
                );

            color: white;

            padding: 22px;

            position: relative;
        }

        .event-header h5 {
            font-weight: 800;
        }

        .event-body {
            padding: 22px;
        }


        /* ========================================
           LIVE BADGE
        ======================================== */

        .live-badge {
            display: inline-flex;

            align-items: center;

            gap: 6px;

            background: #ffe8e8;

            color: #dc3545;

            padding: 6px 11px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 700;
        }

        .live-dot {
            width: 7px;
            height: 7px;

            border-radius: 50%;

            background: #dc3545;
        }


        /* ========================================
           UPCOMING
        ======================================== */

        .upcoming-badge {
            display: inline-flex;

            align-items: center;

            gap: 5px;

            background: #f1ebff;

            color: blueviolet;

            padding: 6px 11px;

            border-radius: 20px;

            font-size: 11px;

            font-weight: 700;
        }


        /* ========================================
           FLIGHTER
        ======================================== */

        .flighter {
            display: flex;

            align-items: center;

            justify-content: space-between;

            padding: 13px 0;
        }

        .flighter-info {
            display: flex;

            align-items: center;

            gap: 12px;
        }

        .flighter-avatar {
            width: 45px;
            height: 45px;

            border-radius: 50%;

            background: #f2edff;

            color: blueviolet;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        .flighter-name {
            font-weight: 700;
        }

        .flighter-record {
            color: #888;

            font-size: 12px;
        }


        /* ========================================
           VS
        ======================================== */

        .vs {
            width: 40px;
            height: 40px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: #f4f4f4;

            border-radius: 50%;

            font-weight: 800;

            font-size: 12px;

            color: #666;
        }


        /* ========================================
           BUTTON
        ======================================== */

        .flight-btn {
            display: inline-block;

            text-decoration: none;

            border: 1px solid blueviolet;

            color: blueviolet;

            background: white;

            border-radius: 10px;

            padding: 9px 15px;

            font-size: 13px;

            font-weight: 700;

            transition: .3s ease;
        }

        .flight-btn:hover {
            background: blueviolet;

            color: white;
        }


        .primary-btn {
            display: inline-block;

            text-decoration: none;

            border: none;

            color: white;

            background:
                linear-gradient(
                    135deg,
                    blueviolet,
                    #4b49f5
                );

            border-radius: 11px;

            padding: 11px 18px;

            font-size: 13px;

            font-weight: 700;

            transition: .3s ease;
        }

        .primary-btn:hover {
            color: white;

            transform: translateY(-2px);
        }


        /* ========================================
           SEARCH
        ======================================== */

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #999;
        }

        .search-wrapper input {
            padding-left: 42px;

            border-radius: 13px;

            border: 1px solid #e2e2e2;

            padding-top: 13px;
            padding-bottom: 13px;
        }

        .search-wrapper input:focus {
            box-shadow: none;

            border-color: blueviolet;
        }


        /* ========================================
           ACTIVITY
        ======================================== */

        .activity {
            display: flex;

            gap: 13px;

            padding: 14px 0;

            border-bottom: 1px solid #eee;
        }

        .activity:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 42px;
            height: 42px;

            flex-shrink: 0;

            background: #f3edff;

            color: blueviolet;

            border-radius: 12px;

            display: flex;

            align-items: center;
            justify-content: center;
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

            transition: .2s ease;
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
           MOBILE NAV
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

                box-shadow:
                    0 -5px 20px rgba(0, 0, 0, .08);

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


        <!-- LOGO -->

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


        <!-- DASHBOARD -->

        <a href="{{ route('dashboard') }}">

            <i class="bi bi-grid-fill"></i>

            Dashboard

        </a>


        <!-- SERVICES -->

        <a href="{{ route('service') }}">

            <i class="bi bi-gear"></i>

            <span>
                Services
            </span>

        </a>


        <!-- REFER -->

        <a href="{{ route('refer') }}">

            <i class="bi bi-people"></i>

            Refer & Earn

        </a>


        <!-- HISTORY -->

        <a href="{{ route('history') }}">

            <i class="bi bi-clock-history"></i>

            Transactions

        </a>


        <!-- PROFILE -->

        <a href="{{ route('profile.edit') }}">

            <i class="bi bi-person-lines-fill"></i>

            Profile

        </a>

    </div>



    <!-- ========================================
         MAIN CONTENT
    ======================================== -->

    <div class="main-content">


        <!-- TOPBAR -->

        <div class="topbar">

            <h3 class="fw-bold mb-1">
                Flight
            </h3>

            <p class="text-muted mb-0">
                Book flights and manage your travel plans.
            </p>

        </div>



        <!-- ========================================
             HERO
        ======================================== -->

        <div class="flight-hero">

            <div class="hero-icon">

                <i class="fa-solid fa-plane"></i>

            </div>

            <h2 class="fw-bold">
                Welcome to {{ $setting->site_name ?? 'BillVexa' }} Flight
            </h2>

            <p class="mb-0 opacity-75">
                Book flights and manage your travel plans.
            </p>

        </div>



        <!-- ========================================
             FLIGHT TYPES
        ======================================== -->

        <div class="mb-4">

            <h5 class="fw-bold mb-3">
                Flight Types
            </h5>

            <div class="row g-3">


                <!-- BOXING -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('flight', ['type' => 'boxing']) }}"
                        class="flight-type active"
                    >

                        <i class="fa-solid fa-plane"></i>

                        <h6>
                            Boxing
                        </h6>

                        <small class="text-muted">
                            Boxing Events
                        </small>

                    </a>

                </div>


                <!-- MMA -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('flight', ['type' => 'mma']) }}"
                        class="flight-type"
                    >

                        <i class="fa-solid fa-people-arrows"></i>

                        <h6>
                            MMA
                        </h6>

                        <small class="text-muted">
                            MMA Events
                        </small>

                    </a>

                </div>


                <!-- KICKBOXING -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('flight', ['type' => 'kickboxing']) }}"
                        class="flight-type"
                    >

                        <i class="fa-solid fa-person-running"></i>

                        <h6>
                            Kickboxing
                        </h6>

                        <small class="text-muted">
                            Flight Events
                        </small>

                    </a>

                </div>


                <!-- OTHER -->

                <div class="col-6 col-md-3">

                    <a
                        href="{{ route('flight', ['type' => 'other']) }}"
                        class="flight-type"
                    >

                        <i class="bi bi-three-dots"></i>

                        <h6>
                            Other
                        </h6>

                        <small class="text-muted">
                            Combat Sports
                        </small>

                    </a>

                </div>

            </div>

        </div>



        <!-- ========================================
             SEARCH
        ======================================== -->

        <div class="custom-card mb-4">

            <div class="row g-3 align-items-end">

                <div class="col-lg-7">

                    <label class="form-label fw-semibold">
                        Search Flight
                    </label>

                    <div class="search-wrapper">

                        <i class="bi bi-search"></i>

                        <input
                            type="text"
                            id="flightSearch"
                            class="form-control"
                            placeholder="Search flighter, event or competition..."
                        >

                    </div>

                </div>


                <div class="col-lg-3">

                    <label class="form-label fw-semibold">
                        Flight Type
                    </label>

                    <select
                        id="flightType"
                        class="form-select"
                    >

                        <option value="all">
                            All
                        </option>

                        <option value="boxing">
                            Boxing
                        </option>

                        <option value="mma">
                            MMA
                        </option>

                        <option value="kickboxing">
                            Kickboxing
                        </option>

                    </select>

                </div>


                <div class="col-lg-2">

                    <button
                        type="button"
                        id="clearFilters"
                        class="btn btn-light w-100 rounded-3 py-2"
                    >

                        <i class="bi bi-arrow-counterclockwise"></i>

                        Reset

                    </button>

                </div>

            </div>

        </div>



        <!-- ========================================
             LIVE FIGHTS
        ======================================== -->

        <div class="mb-4" id="live-flights">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">

                    <i class="bi bi-broadcast-pin text-danger me-2"></i>

                    Live Flights

                </h5>

                <span class="live-badge">

                    <span class="live-dot"></span>

                    LIVE

                </span>

            </div>


            <div class="row g-3">


                @isset($liveFlights)

                    @forelse ($liveFlights as $flight)

                        <div
                            class="col-lg-6 flight-item"
                            data-type="{{ strtolower($flight->type ?? 'boxing') }}"
                        >

                            <div class="event-card">

                                <div class="event-header">

                                    <div class="d-flex justify-content-between">

                                        <div>

                                            <small class="opacity-75">
                                                {{ $flight->competition ?? 'Flight Event' }}
                                            </small>

                                            <h5 class="mb-0 mt-1">
                                                {{ $flight->event_name ?? 'Live Flight' }}
                                            </h5>

                                        </div>

                                        <span class="live-badge">

                                            <span class="live-dot"></span>

                                            LIVE

                                        </span>

                                    </div>

                                </div>


                                <div class="event-body">

                                    <div class="flighter">

                                        <div class="flighter-info">

                                            <div class="flighter-avatar">

                                                <i class="fa-solid fa-user"></i>

                                            </div>

                                            <div>

                                                <div class="flighter-name">

                                                    {{ $flight->fighter_one ?? 'Flighter One' }}

                                                </div>

                                                <div class="flighter-record">

                                                    {{ $flight->fighter_one_record ?? 'Record unavailable' }}

                                                </div>

                                            </div>

                                        </div>

                                        <strong>
                                            {{ $flight->fighter_one_score ?? '-' }}
                                        </strong>

                                    </div>


                                    <div class="text-center">

                                        <span class="vs">
                                            VS
                                        </span>

                                    </div>


                                    <div class="flighter">

                                        <div class="flighter-info">

                                            <div class="flighter-avatar">

                                                <i class="fa-solid fa-user"></i>

                                            </div>

                                            <div>

                                                <div class="flighter-name">

                                                    {{ $flight->flighter_two ?? 'Flighter Two' }}

                                                </div>

                                                <div class="flighter-record">

                                                    {{ $flight->flighter_two_record ?? 'Record unavailable' }}

                                                </div>

                                            </div>

                                        </div>

                                        <strong>
                                            {{ $flight->flighter_two_score ?? '-' }}
                                        </strong>

                                    </div>


                                    <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">

                                        <small class="text-muted">

                                            {{ $flight->round ?? 'Live Round' }}

                                        </small>

                                        <a
                                            href="{{ route('flight.details', $flight->id) }}"
                                            class="flight-btn"
                                        >

                                            View Flight

                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="col-12">

                            <div class="custom-card text-center py-5">

                                <i
                                    class="fa-solid fa-hand-fist text-muted"
                                    style="font-size: 45px;"
                                ></i>

                                <h6 class="fw-bold mt-3">
                                    No live flights
                                </h6>

                                <p class="text-muted mb-0">
                                    There are no live flights at the moment.
                                </p>

                            </div>

                        </div>

                    @endforelse

                @else

                    <!-- DEMO LIVE FIGHT -->

                    <div
                        class="col-lg-6 fight-item"
                        data-type="boxing"
                    >

                        <div class="event-card">

                            <div class="event-header">

                                <div class="d-flex justify-content-between">

                                    <div>

                                        <small class="opacity-75">
                                            Championship Boxing
                                        </small>

                                        <h5 class="mb-0 mt-1">
                                            Main Event
                                        </h5>

                                    </div>

                                    <span class="live-badge">

                                        <span class="live-dot"></span>

                                        LIVE

                                    </span>

                                </div>

                            </div>


                            <div class="event-body">

                                <div class="flighter">

                                    <div class="flighter-info">

                                        <div class="flighter-avatar">

                                            <i class="fa-solid fa-user"></i>

                                        </div>

                                        <div>

                                            <div class="flighter-name">
                                                Flighter One
                                            </div>

                                            <div class="flighter-record">
                                                20 - 2 - 0
                                            </div>

                                        </div>

                                    </div>

                                    <strong>
                                        3
                                    </strong>

                                </div>


                                <div class="text-center">

                                    <span class="vs">
                                        VS
                                    </span>

                                </div>


                                <div class="flighter">

                                    <div class="flighter-info">

                                        <div class="flighter-avatar">

                                            <i class="fa-solid fa-user"></i>

                                        </div>

                                        <div>

                                            <div class="flighter-name">
                                                Flighter Two
                                            </div>

                                            <div class="flighter-record">
                                                18 - 3 - 1
                                            </div>

                                        </div>

                                    </div>

                                    <strong>
                                        2
                                    </strong>

                                </div>


                                <div class="border-top pt-3 mt-3 d-flex justify-content-between">

                                    <small class="text-muted">
                                        Round 3
                                    </small>

                                    <a href="#" class="flight-btn">
                                        View Flight
                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                @endisset

            </div>

        </div>



        <!-- ========================================
             UPCOMING FLIGHTS
        ======================================== -->

        <div class="row g-4">


            <!-- UPCOMING -->

            <div class="col-lg-8">

                <div class="custom-card">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">

                            <i class="bi bi-calendar-event me-2"></i>

                            Upcoming Flights

                        </h5>

                        <a
                            href="{{ route('flight') }}"
                            class="text-decoration-none"
                        >
                            View All
                        </a>

                    </div>


                    @isset($upcomingFlights)

                        @forelse ($upcomingFlights as $flight)

                            <div
                                class="event-card mb-3 flight-item"
                                data-type="{{ strtolower($flight->type ?? 'boxing') }}"
                            >

                                <div class="event-header">

                                    <div class="d-flex justify-content-between align-items-center">

                                        <div>

                                            <small class="opacity-75">

                                                {{ $flight->competition ?? 'Flight Event' }}

                                            </small>

                                            <h5 class="mb-0 mt-1">

                                                {{ $flight->event_name ?? 'Upcoming Flight' }}

                                            </h5>

                                        </div>

                                        <span class="upcoming-badge">

                                            <i class="bi bi-clock"></i>

                                            Upcoming

                                        </span>

                                    </div>

                                </div>


                                <div class="event-body">

                                    <div class="row align-items-center">

                                        <div class="col-md-7">

                                            <div class="flighter">

                                                <div class="flighter-info">

                                                    <div class="flighter-avatar">

                                                        <i class="fa-solid fa-user"></i>

                                                    </div>

                                                    <div>

                                                        <div class="flighter-name">

                                                            {{ $flight->fighter_one ?? 'Flighter One' }}

                                                        </div>

                                                        <div class="flighter-record">

                                                            {{ $flight->flighter_one_record ?? 'Record unavailable' }}

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>


                                            <div class="text-center">

                                                <span class="vs">
                                                    VS
                                                </span>
                                            </div>


                                            <div class="flighter">

                                                <div class="flighter-info">

                                                    <div class="flighter-avatar">

                                                        <i class="fa-solid fa-user"></i>

                                                    </div>

                                                    <div>

                                                        <div class="flighter-name">

                                                            {{ $flight->flighter_two ?? 'Flighter Two' }}

                                                        </div>

                                                        <div class="flighter-record">

                                                            {{ $flight->flighter_two_record ?? 'Record unavailable' }}

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="col-md-5 text-md-end">

                                            <div class="mb-2">

                                                <small class="text-muted d-block">
                                                    Date
                                                </small>

                                                <strong>

                                                    {{ $flight->flight_date ?? 'Coming Soon' }}

                                                </strong>

                                            </div>

                                            <div class="mb-3">

                                                <small class="text-muted d-block">
                                                    Time
                                                </small>

                                                <strong>

                                                    {{ $flight->flight_time ?? '--:--' }}

                                                </strong>

                                            </div>

                                            <a
                                                href="{{ route('flight.details', $flight->id) }}"
                                                class="primary-btn"
                                            >

                                                Flight Details

                                            </a>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-5">

                                <i
                                    class="bi bi-calendar-x text-muted"
                                    style="font-size: 45px;"
                                ></i>

                                <h6 class="fw-bold mt-3">
                                    No upcoming flights
                                </h6>

                                <p class="text-muted mb-0">
                                    Check back later for upcoming flight events.
                                </p>

                            </div>

                        @endforelse

                    @else

                        <!-- DEMO UPCOMING -->

                        <div
                            class="event-card mb-3 flight-item"
                            data-type="boxing"
                        >

                            <div class="event-header">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <small class="opacity-75">
                                            Boxing Championship
                                        </small>

                                        <h5 class="mb-0 mt-1">
                                            Championship Night
                                        </h5>

                                    </div>

                                    <span class="upcoming-badge">

                                        <i class="bi bi-clock"></i>

                                        Upcoming

                                    </span>

                                </div>

                            </div>


                            <div class="event-body">

                                <div class="row align-items-center">

                                    <div class="col-md-7">

                                        <div class="flighter">

                                            <div class="flighter-info">

                                                <div class="flighter-avatar">

                                                    <i class="fa-solid fa-user"></i>

                                                </div>

                                                <div>

                                                    <div class="flighter-name">
                                                        Flighter Alpha
                                                    </div>

                                                    <div class="flighter-record">
                                                        24 - 1 - 0
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="text-center">

                                            <span class="vs">
                                                VS
                                            </span>

                                        </div>


                                        <div class="flighter">

                                            <div class="flighter-info">

                                                <div class="flighter-avatar">

                                                    <i class="fa-solid fa-user"></i>

                                                </div>

                                                <div>

                                                    <div class="flighter-name">
                                                        Flighter Beta
                                                    </div>

                                                    <div class="flighter-record">
                                                        21 - 3 - 0
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-5 text-md-end">

                                        <div class="mb-2">

                                            <small class="text-muted d-block">
                                                Date
                                            </small>

                                            <strong>
                                                Saturday
                                            </strong>

                                        </div>

                                        <div class="mb-3">

                                            <small class="text-muted d-block">
                                                Time
                                            </small>

                                            <strong>
                                                20:00
                                            </strong>

                                        </div>

                                        <a
                                            href="#"
                                            class="primary-btn"
                                        >
                                            Flight Details
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <div
                            class="event-card mb-3 flight-item"
                            data-type="mma"
                        >

                            <div class="event-header">

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <small class="opacity-75">
                                            MMA Championship
                                        </small>

                                        <h5 class="mb-0 mt-1">
                                            Flight Night
                                        </h5>

                                    </div>

                                    <span class="upcoming-badge">

                                        <i class="bi bi-clock"></i>

                                        Upcoming

                                    </span>

                                </div>

                            </div>


                            <div class="event-body">

                                <div class="row align-items-center">

                                    <div class="col-md-7">

                                        <div class="flighter">

                                            <div class="flighter-info">

                                                <div class="flighter-avatar">

                                                    <i class="fa-solid fa-user"></i>

                                                </div>

                                                <div>

                                                    <div class="flighter-name">
                                                        MMA Flighter One
                                                    </div>

                                                    <div class="flighter-record">
                                                        15 - 2 - 0
                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        <div class="text-center">

                                            <span class="vs">
                                                VS
                                            </span>

                                        </div>


                                        <div class="flighter">

                                            <div class="flighter-info">

                                                <div class="flighter-avatar">

                                                    <i class="fa-solid fa-user"></i>

                                                </div>

                                                <div>

                                                    <div class="flighter-name">
                                                        MMA Flighter Two
                                                    </div>

                                                    <div class="flighter-record">
                                                        13 - 1 - 1
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <div class="col-md-5 text-md-end">

                                        <div class="mb-2">

                                            <small class="text-muted d-block">
                                                Date
                                            </small>

                                            <strong>
                                                Sunday
                                            </strong>

                                        </div>

                                        <div class="mb-3">

                                            <small class="text-muted d-block">
                                                Time
                                            </small>

                                            <strong>
                                                21:00
                                            </strong>

                                        </div>

                                        <a
                                            href="#"
                                            class="primary-btn"
                                        >
                                            Flight Details
                                        </a>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endisset

                </div>

            </div>



            <!-- ====================================
                 RIGHT COLUMN
            ==================================== -->

            <div class="col-lg-4">


                <!-- QUICK ACTIONS -->

                <div class="custom-card mb-3">

                    <h5 class="fw-bold mb-3">
                        Quick Actions
                    </h5>


                    <a
                        href="#live-fights"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-broadcast"></i>

                        </div>

                        <div>

                            <strong>
                                Live Flights
                            </strong>

                            <small class="d-block text-muted">
                                Follow flights happening now
                            </small>

                        </div>

                    </a>


                    <a
                        href="#upcoming-fights"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-calendar-event"></i>

                        </div>

                        <div>

                            <strong>
                                Upcoming Flights
                            </strong>

                            <small class="d-block text-muted">
                                See scheduled events
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
                                Flight History
                            </strong>

                            <small class="d-block text-muted">
                                View previous activity
                            </small>

                        </div>

                    </a>

                </div>



                <!-- FLIGHT INFORMATION -->

                <div class="custom-card mb-3">

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-info-circle me-2"></i>

                        Flight Information

                    </h6>


                    <div class="activity">

                        <div class="activity-icon">

                            <i class="bi bi-broadcast"></i>

                        </div>

                        <div>

                            <strong>
                                Live Events
                            </strong>

                            <p class="text-muted small mb-0">
                                Follow live flight events and updates.
                            </p>

                        </div>

                    </div>


                    <div class="activity">

                        <div class="activity-icon">

                            <i class="bi bi-calendar-check"></i>

                        </div>

                        <div>

                            <strong>
                                Upcoming Events
                            </strong>

                            <p class="text-muted small mb-0">
                                Keep track of scheduled flights.
                            </p>

                        </div>

                    </div>


                    <div class="activity">

                        <div class="activity-icon">

                            <i class="bi bi-person"></i>

                        </div>

                        <div>

                            <strong>
                                Flighter Records
                            </strong>

                            <p class="text-muted small mb-0">
                                View flighter records and profiles.
                            </p>

                        </div>

                    </div>

                </div>



                <!-- SAFETY NOTICE -->

                <div class="custom-card">

                    <h6 class="fw-bold">

                        <i class="bi bi-shield-check me-2"></i>

                        Stay Updated

                    </h6>

                    <p class="text-muted small mb-0">

                        Get the latest information about flight events,
                        schedules and results through your {{ $setting->site_name ?? 'BillVexa' }} dashboard.

                    </p>

                </div>

            </div>

        </div>

    </div>



    <!-- ========================================
         MOBILE NAVIGATION
    ======================================== -->

    <div class="mobile-nav d-flex d-lg-none">


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


        <a href="{{ route('refer') }}">

            <i class="bi bi-people"></i>

            <small>
                Refer
            </small>

        </a>


        <a href="{{ route('history') }}">

            <i class="bi bi-clock-history"></i>

            <small>
                History
            </small>

        </a>


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

        const searchInput =
            document.getElementById('fightSearch');

        const typeFilter =
            document.getElementById('flightType');

        const flightItems =
            document.querySelectorAll('.flight-item');

        const clearButton =
            document.getElementById('clearFilters');


        function filterFlights() {

            const search =
                searchInput.value
                    .toLowerCase()
                    .trim();

            const selectedType =
                typeFilter.value
                    .toLowerCase();


            flightItems.forEach(item => {

                const text =
                    item.textContent
                        .toLowerCase();

                const type =
                    item.dataset.type
                        .toLowerCase();


                const searchMatch =
                    text.includes(search);

                const typeMatch =
                    selectedType === 'all' ||
                    selectedType === type;


                if (
                    searchMatch &&
                    typeMatch
                ) {

                    item.style.display = '';

                } else {

                    item.style.display = 'none';

                }

            });

        }


        if (searchInput) {

            searchInput.addEventListener(
                'input',
                filterFlights
            );

        }


        if (typeFilter) {

            typeFilter.addEventListener(
                'change',
                filterFlights
            );

        }


        if (clearButton) {

            clearButton.addEventListener(
                'click',
                function () {

                    searchInput.value = '';

                    typeFilter.value = 'all';

                    filterFlights();

                }
            );

        }

    </script>


</body>

</html>