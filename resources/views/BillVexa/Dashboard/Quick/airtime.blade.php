<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Airtime Dashboard
    </title>

    <!-- Favicon -->
    <link
        rel="shortcut icon"
        href="../../../Assets/Image/icon.png"
        type="image/x-icon"
    >

    <!-- Bootstrap / Vite -->
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
           CUSTOM CARD
        ======================================== */

        .custom-card {
            background: white;

            border-radius: 22px;

            padding: 25px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }


        /* ========================================
           FORM INPUTS
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
           BUY BUTTON
        ======================================== */

        .buy-btn {
            background: linear-gradient(
                135deg,
                blueviolet,
                #4b49f5
            );

            border: none;

            border-radius: 14px;

            padding: 15px;

            color: white;

            font-weight: bold;

            transition: 0.3s ease;
        }

        .buy-btn:hover {
            transform: translateY(-3px);

            opacity: 0.95;
        }


        /* ========================================
           NETWORK CARDS
        ======================================== */

        .network-card {
            border: 1px solid #e5e7eb;

            border-radius: 18px;

            padding: 20px;

            text-align: center;

            cursor: pointer;

            transition: 0.3s ease;
        }

        .network-card:hover {
            border-color: blueviolet;

            background: #f7f2ff;

            transform: translateY(-5px);
        }

        .network-card.clicked {
            background-color: #f7f2ff;

            border-color: blueviolet;

            transform: translateY(-5px);
        }


        /* ========================================
           TRANSACTIONS
        ======================================== */

        .transaction-item {
            padding: 16px 0;

            border-bottom: 1px solid #f1f1f1;
        }

        .transaction-item:last-child {
            border-bottom: none;
        }


        /* ========================================
           MOBILE NAVIGATION
        ======================================== */

        .mobile-nav {
            display: none;
        }


        /* ========================================
           MOBILE RESPONSIVE
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

            .airtime-card h1 {
                font-size: 2rem;
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

            <span>
                Dashboard
            </span>

        </a>


        <!-- Services -->
        <a href="{{ route('service') }}">

            <i class="bi bi-gear"></i>

            <span>
                Services
            </span>

        </a>


        <!-- Refer & Earn -->
        <a href="{{ route('refer') }}">

            <i class="bi bi-people"></i>

            <span>
                Refer & Earn
            </span>

        </a>


        <!-- Transactions -->
        <a href="{{ route('history') }}">

            <i class="bi bi-clock-history"></i>

            <span>
                Transactions
            </span>

        </a>


        <!-- Profile -->
        <a href="{{ route('profile.edit') }}">

            <i class="bi bi-person-lines-fill"></i>

            <span>
                Profile
            </span>

        </a>

    </div>


    <!-- ========================================
         MAIN CONTENT
    ======================================== -->

    <div class="main-content">


        <!-- ====================================
             TOPBAR
        ==================================== -->

        <div class="topbar d-flex justify-content-between align-items-center">

            <div>

                <h3 class="fw-bold mb-1">
                    Airtime Purchase
                </h3>

                <p class="text-muted mb-0">
                    Purchase airtime instantly with automatic discounts.
                </p>

            </div>


            {{-- Discount Badge --}}
            {{--

            <div class="text-end">

                <span class="badge bg-success fs-6 px-3 py-2">
                    {{ $setting->airtime_discount }}% Discount
                </span>

            </div>

            --}}

        </div>


        <!-- ====================================
             CONTENT ROW
        ==================================== -->

        <div class="row g-4">


            <!-- ==================================
                 LEFT COLUMN
            ================================== -->

            <div class="col-lg-8">


                <!-- ==================================
                     BUY AIRTIME CARD
                ================================== -->

                <div class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Buy Airtime
                    </h4>


                    <!-- Success Message -->
                    @if (session('success'))

                        <div class="alert alert-success">

                            {{ session('success') }}

                        </div>

                    @endif


                    <!-- Error Message -->
                    @if (session('error'))

                        <div class="alert alert-danger">

                            {{ session('error') }}

                        </div>

                    @endif


                    <!-- ==================================
                         AIRTIME FORM
                    ================================== -->

                    <form
                        action="{{ route('airtime.purchase') }}"
                        method="POST"
                    >

                        @csrf


                        <!-- ==================================
                             NETWORK
                        ================================== -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select Network
                            </label>


                            <div class="row g-3">


                                <!-- MTN -->
                                <div class="col-md-3 col-6">

                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="network"
                                        id="mtn"
                                        value="MTN"
                                        {{ old('network') == 'MTN' ? 'checked' : '' }}
                                        autocomplete="off"
                                    >

                                    <label
                                        class="network-card w-100"
                                        for="mtn"
                                    >

                                        <i class="fa-solid fa-signal fs-2 text-warning mb-2"></i>

                                        <h6 class="mb-0">
                                            MTN
                                        </h6>

                                    </label>

                                </div>


                                <!-- GLO -->
                                <div class="col-md-3 col-6">

                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="network"
                                        id="glo"
                                        value="Glo"
                                        {{ old('network') == 'Glo' ? 'checked' : '' }}
                                        autocomplete="off"
                                    >

                                    <label
                                        class="network-card w-100"
                                        for="glo"
                                    >

                                        <i class="fa-solid fa-signal fs-2 text-success mb-2"></i>

                                        <h6 class="mb-0">
                                            Glo
                                        </h6>

                                    </label>

                                </div>


                                <!-- AIRTEL -->
                                <div class="col-md-3 col-6">

                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="network"
                                        id="airtel"
                                        value="Airtel"
                                        {{ old('network') == 'Airtel' ? 'checked' : '' }}
                                        autocomplete="off"
                                    >

                                    <label
                                        class="network-card w-100"
                                        for="airtel"
                                    >

                                        <i class="fa-solid fa-signal fs-2 text-danger mb-2"></i>

                                        <h6 class="mb-0">
                                            Airtel
                                        </h6>

                                    </label>

                                </div>


                                <!-- 9MOBILE -->
                                <div class="col-md-3 col-6">

                                    <input
                                        type="radio"
                                        class="btn-check"
                                        name="network"
                                        id="nine_mobile"
                                        value="9mobile"
                                        {{ old('network') == '9mobile' ? 'checked' : '' }}
                                        autocomplete="off"
                                    >

                                    <label
                                        class="network-card w-100"
                                        for="nine_mobile"
                                    >

                                        <i class="fa-solid fa-signal fs-2 text-info mb-2"></i>

                                        <h6 class="mb-0">
                                            9mobile
                                        </h6>

                                    </label>

                                </div>

                            </div>


                            <!-- Network Validation -->
                            @error('network')

                                <small class="text-danger d-block mt-2">
                                    {{ $message }}
                                </small>

                            @enderror

                        </div>


                        <!-- ==================================
                             PHONE NUMBER
                        ================================== -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Phone Number
                            </label>

                            <input
                                type="tel"
                                name="phone"
                                class="form-control"
                                placeholder="Enter phone number"
                                value="{{ old('phone') }}"
                            >

                            @error('phone')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <!-- ==================================
                             AMOUNT
                        ================================== -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Amount
                            </label>


                            <div class="input-group">

                                <span class="input-group-text">
                                    ₦
                                </span>

                                <input
                                    type="number"
                                    name="amount"
                                    class="form-control"
                                    placeholder="Enter amount"
                                    value="{{ old('amount') }}"
                                    min="1"
                                    step="0.01"
                                >

                            </div>


                            @error('amount')

                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>

                            @enderror


                            <!-- ==================================
                                 PURCHASE SUMMARY
                            ================================== -->

                            <div class="card border-0 shadow-sm rounded-4 mt-4">

                                <div class="card-header bg-transparent border-0 pb-0">

                                    <h6 class="fw-bold">

                                        <i class="bi bi-receipt me-2"></i>

                                        Purchase Summary

                                    </h6>

                                </div>


                                <div class="card-body">


                                    <!-- Airtime Amount -->
                                    <div class="d-flex justify-content-between py-2">

                                        <span class="text-muted">
                                            Airtime Amount
                                        </span>

                                        <strong id="amountText">
                                            ₦0.00
                                        </strong>

                                    </div>


                                    <!-- Discount -->
                                    <div class="d-flex justify-content-between py-2">

                                        <span class="text-success">

                                            Discount
                                            ({{ $setting->airtime_discount ?? 0 }}%)

                                        </span>

                                        <strong
                                            class="text-success"
                                            id="discountText"
                                        >
                                            -₦0.00
                                        </strong>

                                    </div>


                                    <hr>


                                    <!-- Total -->
                                    <div class="d-flex justify-content-between">

                                        <h6 class="fw-bold">
                                            Amount to Pay
                                        </h6>

                                        <h5
                                            class="fw-bold text-primary"
                                            id="totalText"
                                        >
                                            ₦0.00
                                        </h5>

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- ==================================
                             BUY BUTTON
                        ================================== -->

                        <button
                            type="submit"
                            class="buy-btn w-100"
                        >

                            <i class="fa-solid fa-paper-plane me-2"></i>

                            Buy Airtime

                        </button>

                    </form>

                </div>

            </div>


            <!-- ==================================
                 RIGHT COLUMN
            ================================== -->

            <div class="col-lg-4">


                <!-- ==================================
                     QUICK INFORMATION
                ================================== -->

                <div class="custom-card">

                    <h5 class="fw-bold mb-4">

                        <i class="bi bi-info-circle me-2"></i>

                        Airtime Information

                    </h5>


                    <!-- Instant Delivery -->
                    <div class="d-flex align-items-center mb-3">

                        <i
                            class="bi bi-check-circle-fill text-success me-3 fs-5"
                        ></i>

                        <div>

                            <strong>
                                Instant Delivery
                            </strong>

                            <div class="text-muted small">
                                Airtime is delivered immediately.
                            </div>

                        </div>

                    </div>


                    {{-- Discount Information --}}
                    {{--
                    <div class="d-flex align-items-center mb-3">

                        <i
                            class="bi bi-percent text-primary me-3 fs-5"
                        ></i>

                        <div>

                            <strong>
                                {{ $setting->airtime_discount }}% Discount
                            </strong>

                            <div class="text-muted small">
                                Save money on every airtime purchase.
                            </div>

                        </div>

                    </div>
                    --}}


                    <!-- Minimum Recharge -->
                    <div class="d-flex align-items-center mb-3">

                        <i
                            class="bi bi-wallet2 text-warning me-3 fs-5"
                        ></i>

                        <div>

                            <strong>
                                Minimum Recharge
                            </strong>

                            <div class="text-muted small">

                                ₦{{ number_format($setting->minimum_deposit ?? 0) }}

                            </div>

                        </div>

                    </div>


                    <!-- 24/7 Service -->
                    <div class="d-flex align-items-center">

                        <i
                            class="bi bi-clock-history text-info me-3 fs-5"
                        ></i>

                        <div>

                            <strong>
                                24/7 Service
                            </strong>

                            <div class="text-muted small">
                                Available every day of the week.
                            </div>

                        </div>

                    </div>

                </div>


                <!-- ==================================
                     RECENT AIRTIME
                ================================== -->

                <div class="custom-card mt-3">

                    <div class="d-flex justify-content-between mb-4">

                        <h5 class="fw-bold mb-0">
                            Recent Airtime
                        </h5>

                        <a
                            href="{{ route('history') }}"
                            class="text-decoration-none"
                        >
                            View all
                        </a>

                    </div>


                    <div class="list-group list-group-flush">

                        @forelse ($transactions as $transaction)

                            <div class="list-group-item border-0 px-0">

                                <div class="d-flex justify-content-between">

                                    <div class="row small w-100">


                                        <!-- Airtime Amount -->
                                        <div class="col-6 text-muted">
                                            Airtime Amount
                                        </div>

                                        <div class="col-6 text-end fw-bold">
                                            ₦{{ number_format($transaction->amount, 2) }}
                                        </div>


                                        <!-- Discount -->
                                        <div class="col-6 text-success">
                                            Discount
                                        </div>

                                        <div class="col-6 text-end text-success fw-bold">

                                            -₦{{ number_format($transaction->discount ?? 0, 2) }}

                                        </div>


                                        <!-- Amount Paid -->
                                        <div class="col-6 fw-bold">
                                            Amount Paid
                                        </div>

                                        <div class="col-6 text-end fw-bold text-primary">

                                            ₦{{ number_format($transaction->total ?? $transaction->amount, 2) }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-4">

                                <i
                                    class="bi bi-receipt text-muted"
                                    style="font-size: 35px;"
                                ></i>

                                <p class="text-muted mt-2 mb-0">
                                    No recent airtime transactions.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- ========================================
         MOBILE BOTTOM NAVIGATION
    ======================================== -->

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


    <!-- ========================================
         JAVASCRIPT
    ======================================== -->

    <script>

        /* ========================================
           NETWORK CARD SELECTION
        ======================================== */

        const networkCards =
            document.querySelectorAll('.network-card');

        networkCards.forEach(card => {

            card.addEventListener('click', function () {

                networkCards.forEach(item => {

                    item.classList.remove('clicked');

                });

                this.classList.add('clicked');

            });

        });


        /* ========================================
           AMOUNT + DISCOUNT CALCULATION
        ======================================== */

        const amountInput =
            document.querySelector('input[name="amount"]');

        const discount =
            {{ $setting->airtime_discount ?? 0 }};


        function calculate() {

            if (!amountInput) {
                return;
            }


            const amount =
                parseFloat(amountInput.value) || 0;


            const discountAmount =
                amount * (discount / 100);


            const total =
                amount - discountAmount;


            /* Airtime Amount */

            document.getElementById('amountText').innerHTML =
                '₦' +
                amount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });


            /* Discount */

            document.getElementById('discountText').innerHTML =
                '-₦' +
                discountAmount.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });


            /* Total */

            document.getElementById('totalText').innerHTML =
                '₦' +
                total.toLocaleString(undefined, {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

        }


        /* ========================================
           LISTEN FOR AMOUNT CHANGES
        ======================================== */

        if (amountInput) {

            amountInput.addEventListener(
                'input',
                calculate
            );

            calculate();

        }

    </script>


</body>

</html>