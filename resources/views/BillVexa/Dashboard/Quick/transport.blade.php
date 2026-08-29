<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Transport
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
           FORM
        ======================================== */

        .form-control,
        .form-select {
            border-radius: 14px;

            padding: 14px;

            border: 1px solid #e5e7eb;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: none;

            border-color: blueviolet;
        }


        /* ========================================
           SEARCH BUTTON
        ======================================== */

        .search-btn {
            background: linear-gradient(
                135deg,
                blueviolet,
                #4b49f5
            );

            border: none;

            border-radius: 14px;

            padding: 14px 20px;

            color: white;

            font-weight: bold;

            transition: 0.3s ease;
        }

        .search-btn:hover {
            transform: translateY(-3px);

            opacity: 0.95;
        }


        /* ========================================
           TRANSPORT SERVICE CARDS
        ======================================== */

        .transport-card {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

            padding: 20px;

            height: 100%;

            transition: 0.3s ease;
        }

        .transport-card:hover {
            border-color: blueviolet;

            transform: translateY(-5px);

            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.06);
        }


        .transport-icon {
            width: 55px;
            height: 55px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #f5efff;

            color: blueviolet;

            border-radius: 15px;

            font-size: 24px;

            margin-bottom: 15px;
        }


        /* ========================================
           TRIP CARD
        ======================================== */

        .trip-card {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 18px;

            padding: 18px;

            transition: 0.3s ease;
        }

        .trip-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);

            transform: translateY(-3px);
        }

        .route-line {
            position: relative;

            padding-left: 25px;
        }

        .route-line::before {
            content: "";

            position: absolute;

            left: 5px;
            top: 8px;

            width: 10px;
            height: 10px;

            background: blueviolet;

            border-radius: 50%;
        }

        .route-line::after {
            content: "";

            position: absolute;

            left: 9px;
            top: 20px;

            width: 2px;
            height: 28px;

            background: #ddd;
        }

        .route-line.destination::before {
            background: #4b49f5;
        }

        .route-line.destination::after {
            display: none;
        }


        /* ========================================
           BOOKING STATUS
        ======================================== */

        .status-success {
            color: #198754;

            background: #e9f8ef;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 600;
        }

        .status-pending {
            color: #f59e0b;

            background: #fff7df;

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: 600;
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
                    Transport
                </h3>

                <p class="text-muted mb-0">
                    Search and book your next trip with {{ $setting->site_name ?? 'BillVexa' }}.
                </p>

            </div>

        </div>



        <!-- ========================================
             SEARCH TRIP
        ======================================== -->

        <div class="custom-card mb-4">

            <div class="d-flex align-items-center mb-4">

                <div class="transport-icon me-3 mb-0">

                    <i class="bi bi-bus-front"></i>

                </div>

                <div>

                    <h4 class="fw-bold mb-1">
                        Find a Trip
                    </h4>

                    <p class="text-muted mb-0">
                        Choose your route and travel date.
                    </p>

                </div>

            </div>


            @if (session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            @if (session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            <form
                action=""
                method="GET"
            >

                <div class="row g-3">


                    <!-- Departure -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            From
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-geo-alt"></i>
                            </span>

                            <input
                                type="text"
                                name="from"
                                class="form-control"
                                placeholder="Departure city"
                                value="{{ request('from') }}"
                                required
                            >

                        </div>

                    </div>


                    <!-- Destination -->

                    <div class="col-lg-3 col-md-6">

                        <label class="form-label fw-semibold">
                            To
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-geo-alt-fill"></i>
                            </span>

                            <input
                                type="text"
                                name="to"
                                class="form-control"
                                placeholder="Destination city"
                                value="{{ request('to') }}"
                                required
                            >

                        </div>

                    </div>


                    <!-- Date -->

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Travel Date
                        </label>

                        <input
                            type="date"
                            name="travel_date"
                            class="form-control"
                            value="{{ request('travel_date', date('Y-m-d')) }}"
                            min="{{ date('Y-m-d') }}"
                            required
                        >

                    </div>


                    <!-- Passengers -->

                    <div class="col-lg-2 col-md-6">

                        <label class="form-label fw-semibold">
                            Passengers
                        </label>

                        <select
                            name="passengers"
                            class="form-select"
                        >

                            @for ($i = 1; $i <= 10; $i++)

                                <option
                                    value="{{ $i }}"
                                    {{ request('passengers', 1) == $i ? 'selected' : '' }}
                                >
                                    {{ $i }}
                                    {{ $i == 1 ? 'Passenger' : 'Passengers' }}
                                </option>

                            @endfor

                        </select>

                    </div>


                    <!-- Search -->

                    <div class="col-lg-2 col-md-12 d-flex align-items-end">

                        <button
                            type="submit"
                            class="search-btn w-100"
                        >

                            <i class="bi bi-search me-2"></i>

                            Search Trips

                        </button>

                    </div>

                </div>

            </form>

        </div>



        <!-- ========================================
             TRANSPORT SERVICES
        ======================================== -->

        <div class="mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="fw-bold mb-0">
                    Transport Services
                </h5>

            </div>


            <div class="row g-3">


                <!-- Interstate -->

                <div class="col-md-4">

                    <div class="transport-card">

                        <div class="transport-icon">

                            <i class="bi bi-bus-front"></i>

                        </div>

                        <h6 class="fw-bold">
                            Interstate Travel
                        </h6>

                        <p class="text-muted small">
                            Book buses for trips between cities and states.
                        </p>

                        <a
                            href="#trip-search"
                            class="text-decoration-none fw-semibold"
                            style="color: blueviolet;"
                        >
                            Book a Trip
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>


                <!-- Local -->

                <div class="col-md-4">

                    <div class="transport-card">

                        <div class="transport-icon">

                            <i class="bi bi-taxi-front"></i>

                        </div>

                        <h6 class="fw-bold">
                            Local Transport
                        </h6>

                        <p class="text-muted small">
                            Find available local transportation services.
                        </p>

                        <a
                            href="#trip-search"
                            class="text-decoration-none fw-semibold"
                            style="color: blueviolet;"
                        >
                            Find Transport
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>


                <!-- Airport -->

                <div class="col-md-4">

                    <div class="transport-card">

                        <div class="transport-icon">

                            <i class="bi bi-airplane"></i>

                        </div>

                        <h6 class="fw-bold">
                            Airport Transfer
                        </h6>

                        <p class="text-muted small">
                            Arrange convenient transportation to or from airports.
                        </p>

                        <a
                            href="#trip-search"
                            class="text-decoration-none fw-semibold"
                            style="color: blueviolet;"
                        >
                            Arrange Transfer
                            <i class="bi bi-arrow-right"></i>
                        </a>

                    </div>

                </div>

            </div>

        </div>



        <!-- ========================================
             SEARCH RESULTS
        ======================================== -->

        @isset($trips)

            <div class="mb-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h5 class="fw-bold mb-0">
                        Available Trips
                    </h5>

                    <span class="text-muted small">
                        {{ count($trips) }} trips found
                    </span>

                </div>


                @forelse ($trips as $trip)

                    <div class="trip-card mb-3">

                        <div class="row align-items-center g-3">


                            <!-- Operator -->

                            <div class="col-lg-2">

                                <div class="d-flex align-items-center gap-2">

                                    <div class="transport-icon mb-0">

                                        <i class="bi bi-bus-front"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $trip->operator ?? 'Transport Company' }}
                                        </strong>

                                        <small class="d-block text-muted">
                                            {{ $trip->bus_type ?? 'Bus' }}
                                        </small>

                                    </div>

                                </div>

                            </div>


                            <!-- Route -->

                            <div class="col-lg-4">

                                <div class="route-line">

                                    <small class="text-muted">
                                        Departure
                                    </small>

                                    <strong class="d-block">
                                        {{ $trip->from ?? 'Departure' }}
                                    </strong>

                                </div>


                                <div class="route-line destination mt-2">

                                    <small class="text-muted">
                                        Destination
                                    </small>

                                    <strong class="d-block">
                                        {{ $trip->to ?? 'Destination' }}
                                    </strong>

                                </div>

                            </div>


                            <!-- Time -->

                            <div class="col-lg-2">

                                <small class="text-muted">
                                    Departure Time
                                </small>

                                <strong class="d-block">
                                    {{ $trip->departure_time ?? '--:--' }}
                                </strong>

                            </div>


                            <!-- Price -->

                            <div class="col-lg-2">

                                <small class="text-muted">
                                    Price
                                </small>

                                <h5 class="fw-bold mb-0">

                                    ₦{{ number_format($trip->price ?? 0, 2) }}

                                </h5>

                            </div>


                            <!-- Book -->

                            <div class="col-lg-2">

                                <a
                                    href=""
                                    class="btn btn-primary w-100 rounded-3"
                                >

                                    Book Now

                                </a>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="custom-card text-center py-5">

                        <i
                            class="bi bi-bus-front text-muted"
                            style="font-size: 45px;"
                        ></i>

                        <h6 class="fw-bold mt-3">
                            No trips found
                        </h6>

                        <p class="text-muted mb-0">
                            Try another route or travel date.
                        </p>

                    </div>

                @endforelse

            </div>

        @endisset



        <!-- ========================================
             BOTTOM CONTENT
        ======================================== -->

        <div class="row g-4">


            <!-- ====================================
                 RECENT BOOKINGS
            ==================================== -->

            <div class="col-lg-8">

                <div class="custom-card">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h5 class="fw-bold mb-0">
                            Recent Bookings
                        </h5>

                        <a
                            href="{{ route('history') }}"
                            class="text-decoration-none"
                        >
                            View All
                        </a>

                    </div>


                    @isset($bookings)

                        @forelse ($bookings as $booking)

                            <div class="border-bottom py-3">

                                <div class="row align-items-center">


                                    <!-- Route -->

                                    <div class="col-md-5">

                                        <div class="d-flex align-items-center">

                                            <div class="transport-icon mb-0 me-3">

                                                <i class="bi bi-bus-front"></i>

                                            </div>

                                            <div>

                                                <strong>

                                                    {{ $booking->from ?? 'Departure' }}

                                                    <i class="bi bi-arrow-right mx-1"></i>

                                                    {{ $booking->to ?? 'Destination' }}

                                                </strong>

                                                <small class="d-block text-muted">

                                                    {{ $booking->travel_date ?? 'N/A' }}

                                                </small>

                                            </div>

                                        </div>

                                    </div>


                                    <!-- Reference -->

                                    <div class="col-md-3 mt-2 mt-md-0">

                                        <small class="text-muted d-block">
                                            Booking Reference
                                        </small>

                                        <strong>
                                            {{ $booking->reference ?? 'N/A' }}
                                        </strong>

                                    </div>


                                    <!-- Amount -->

                                    <div class="col-md-2 mt-2 mt-md-0">

                                        <small class="text-muted d-block">
                                            Amount
                                        </small>

                                        <strong>
                                            ₦{{ number_format($booking->amount ?? 0, 2) }}
                                        </strong>

                                    </div>


                                    <!-- Status -->

                                    <div class="col-md-2 mt-2 mt-md-0">

                                        @if (($booking->status ?? '') === 'successful')

                                            <span class="status-success">
                                                Successful
                                            </span>

                                        @else

                                            <span class="status-pending">
                                                {{ ucfirst($booking->status ?? 'Pending') }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-5">

                                <i
                                    class="bi bi-ticket-perforated text-muted"
                                    style="font-size: 40px;"
                                ></i>

                                <p class="text-muted mt-3 mb-0">
                                    You have no transport bookings yet.
                                </p>

                            </div>

                        @endforelse

                    @else

                        <div class="text-center py-5">

                            <i
                                class="bi bi-ticket-perforated text-muted"
                                style="font-size: 40px;"
                            ></i>

                            <p class="text-muted mt-3 mb-0">
                                You have no transport bookings yet.
                            </p>

                        </div>

                    @endisset

                </div>

            </div>



            <!-- ====================================
                 QUICK ACTIONS
            ==================================== -->

            <div class="col-lg-4">

                <div class="custom-card">

                    <h5 class="fw-bold mb-3">
                        Quick Actions
                    </h5>


                    <!-- Search Trip -->

                    <a
                        href="#trip-search"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-search"></i>

                        </div>

                        <div>

                            <strong>
                                Search Trips
                            </strong>

                            <small class="d-block text-muted">
                                Find available transport
                            </small>

                        </div>

                    </a>


                    <!-- Bookings -->

                    <a
                        href="{{ route('history') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-ticket-perforated"></i>

                        </div>

                        <div>

                            <strong>
                                My Bookings
                            </strong>

                            <small class="d-block text-muted">
                                View your transport bookings
                            </small>

                        </div>

                    </a>


                    <!-- Profile -->

                    <a
                        href="{{ route('profile.edit') }}"
                        class="quick-action"
                    >

                        <div class="quick-icon">

                            <i class="bi bi-person"></i>

                        </div>

                        <div>

                            <strong>
                                Passenger Details
                            </strong>

                            <small class="d-block text-muted">
                                Update your information
                            </small>

                        </div>

                    </a>

                </div>


                <!-- Transport Information -->

                <div class="custom-card mt-3">

                    <h6 class="fw-bold mb-3">

                        <i class="bi bi-info-circle me-2"></i>

                        Transport Information

                    </h6>


                    <div class="d-flex align-items-start mb-3">

                        <i
                            class="bi bi-check-circle-fill text-success me-3 mt-1"
                        ></i>

                        <div>

                            <strong>
                                Easy Booking
                            </strong>

                            <div class="text-muted small">
                                Search and book your preferred trip.
                            </div>

                        </div>

                    </div>


                    <div class="d-flex align-items-start mb-3">

                        <i
                            class="bi bi-shield-check text-primary me-3 mt-1"
                        ></i>

                        <div>

                            <strong>
                                Secure Payments
                            </strong>

                            <div class="text-muted small">
                                Your bookings are processed securely.
                            </div>

                        </div>

                    </div>


                    <div class="d-flex align-items-start">

                        <i
                            class="bi bi-headset text-warning me-3 mt-1"
                        ></i>

                        <div>

                            <strong>
                                Customer Support
                            </strong>

                            <div class="text-muted small">
                                Get help when you need it.
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


</body>

</html>