<!DOCTYPE html>
<html lang="en">

<head>
    {{-- =========================================================
        META
    ========================================================== --}}
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- =========================================================
        PAGE TITLE
    ========================================================== --}}
    <title>
        {{ $setting->site_name ?? 'BillVexa' }} | Electricity
    </title>


    {{-- =========================================================
        FAVICON
    ========================================================== --}}
    <link
        rel="shortcut icon"
        href="{{ asset('Assets/Image/icon.png') }}"
        type="image/x-icon"
    >


    {{-- =========================================================
        VITE / BOOTSTRAP
    ========================================================== --}}
    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    {{-- =========================================================
        FONT AWESOME
    ========================================================== --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    {{-- =========================================================
        BOOTSTRAP ICONS
    ========================================================== --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
    >


    {{-- =========================================================
        CUSTOM CSS
    ========================================================== --}}
    <style>

        /* ========================================================
           GLOBAL
        ======================================================== */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f4f7ff;
            font-family: Arial, Helvetica, sans-serif;
            overflow-x: hidden;
        }


        /* ========================================================
           SIDEBAR
        ======================================================== */

        .sidebar {
            width: 260px;
            min-height: 100vh;

            position: fixed;
            top: 0;
            left: 0;

            padding: 25px 15px;

            background: linear-gradient(
                180deg,
                #5b21b6,
                #2563eb
            );

            z-index: 1000;
        }


        /* Logo */

        .logo {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
        }


        .logo img {
            object-fit: cover;
        }


        /* Sidebar Links */

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;

            padding: 14px 16px;
            margin-bottom: 10px;

            color: #ffffff;
            text-decoration: none;

            border-radius: 12px;

            transition: all 0.3s ease;
        }


        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }


        /* ========================================================
           MAIN CONTENT
        ======================================================== */

        .main-content {
            margin-left: 260px;
            padding: 30px;
        }


        /* ========================================================
           TOPBAR
        ======================================================== */

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 18px 25px;
            margin-bottom: 30px;

            background: #ffffff;

            border-radius: 18px;

            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }


        /* ========================================================
           GENERAL CARD
        ======================================================== */

        .custom-card {
            padding: 30px;

            background: #ffffff;

            border-radius: 24px;

            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }


        /* ========================================================
           ELECTRICITY HERO
        ======================================================== */

        .electricity-card {
            position: relative;

            padding: 35px;

            color: #ffffff;

            background: linear-gradient(
                135deg,
                #ffb300,
                #ff7b00
            );

            border-radius: 25px;

            overflow: hidden;
        }


        .electricity-card::before {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            top: -80px;
            right: -80px;

            background: rgba(255, 255, 255, 0.1);

            border-radius: 50%;
        }


        .electricity-card h1 {
            font-size: 3rem;
            font-weight: 700;
        }


        /* ========================================================
           PAYMENT BUTTON
        ======================================================== */

        .pay-btn {
            display: flex;
            align-items: center;
            justify-content: center;

            width: 100%;

            padding: 14px;

            color: #ffffff;

            background: linear-gradient(
                135deg,
                blueviolet,
                #4b49f5
            );

            border: none;
            border-radius: 14px;

            font-weight: 700;

            transition: all 0.3s ease;
        }


        .pay-btn:hover {
            transform: translateY(-2px);
            opacity: 0.95;
        }


        .pay-btn:disabled {
            cursor: not-allowed;
            opacity: 0.6;
            transform: none;
        }


        /* ========================================================
           INFORMATION BOX
        ======================================================== */

        .info-box {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 18px;

            background: #f8f9ff;

            border-radius: 16px;
        }


        /* ========================================================
        TRANSACTION HISTORY
        ======================================================== */

        .history-item {
            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 16px 0;

            border-bottom: 1px solid #eef0f5;

            transition: all 0.25s ease;
        }

        .history-item:last-child {
            border-bottom: none;
        }

        .history-item:hover {
            background: #fafbff;
            padding-left: 8px;
            padding-right: 8px;
            border-radius: 12px;
        }

        .history-item h6 {
            color: #1f2937;
        }

        .history-item strong {
            color: #111827;
            font-size: 15px;
        }
        /* ========================================================
           MOBILE BOTTOM NAVIGATION
        ======================================================== */

        .mobile-nav {
            position: fixed;

            left: 0;
            bottom: 0;

            width: 100%;

            padding: 10px 0;

            background: #ffffff;

            box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.08);

            z-index: 2000;
        }


        .mobile-nav a {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;

            gap: 4px;

            color: #777777;
            text-decoration: none;

            font-size: 12px;

            transition: 0.3s ease;
        }


        .mobile-nav a i {
            font-size: 20px;
        }


        .mobile-nav a:hover,
        .mobile-nav a.active {
            color: blueviolet;
        }


        /* ========================================================
           RESPONSIVE DESIGN
        ======================================================== */

        @media (max-width: 991px) {

            body {
                padding-bottom: 80px;
            }


            .main-content {
                margin-left: 0;
                padding: 20px;
            }


            .electricity-card h1 {
                font-size: 2.2rem;
            }

        }

    </style>

</head>


<body>


    {{-- =========================================================
        DESKTOP SIDEBAR
    ========================================================== --}}

    <aside class="sidebar d-none d-lg-flex flex-column">


        {{-- Logo --}}

        <div class="logo d-flex align-items-center mb-5">

            @if ($setting && $setting->logo)

                <img
                    src="{{ asset('storage/' . $setting->logo) }}"
                    width="40"
                    height="40"
                    class="rounded me-2"
                    alt="{{ $setting->site_name ?? 'BillVexa' }} Logo"
                >

            @else

                <i class="bi bi-grid me-2"></i>

            @endif

            <span>
                {{ $setting->site_name ?? 'BillVexa' }}
            </span>

        </div>


        {{-- Navigation --}}

        <nav>

            <a href="{{ route('dashboard') }}">
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>


            <a href="{{ route('service') }}">
                <i class="bi bi-gear"></i>
                <span>Services</span>
            </a>


            <a href="{{ route('refer') }}">
                <i class="bi bi-people"></i>
                <span>Refer & Earn</span>
            </a>


            <a href="{{ route('history') }}">
                <i class="bi bi-clock-history"></i>
                <span>Transactions</span>
            </a>


            <a href="{{ route('profile.edit') }}">
                <i class="bi bi-person-lines-fill"></i>
                <span>Profile</span>
            </a>

        </nav>

    </aside>



    {{-- =========================================================
        MOBILE BOTTOM NAVIGATION
    ========================================================== --}}

    <nav
        class="mobile-nav d-flex d-lg-none justify-content-around align-items-center"
    >

        <a href="{{ route('dashboard') }}">
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>


        <a href="{{ route('service') }}">
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>


        <a href="{{ route('refer') }}">
            <i class="bi bi-people"></i>
            <small>Refer & Earn</small>
        </a>


        <a href="{{ route('history') }}">
            <i class="bi bi-clock-history"></i>
            <small>History</small>
        </a>


        <a href="{{ route('profile.edit') }}">
            <i class="bi bi-person-lines-fill"></i>
            <small>Profile</small>
        </a>

    </nav>



    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}

    <main class="main-content">


        {{-- =====================================================
            TOPBAR
        ====================================================== --}}

        <header class="topbar">

            <div>

                <h4 class="fw-bold mb-1">
                    Electricity
                </h4>

                <small class="text-muted">
                    Manage and pay your electricity bills easily.
                </small>

            </div>

        </header>



        {{-- =====================================================
            PAGE GRID
        ====================================================== --}}

        <div class="row g-4">


            {{-- =================================================
                LEFT COLUMN
            ================================================== --}}

            <div class="col-lg-8">


                {{-- =============================================
                    PAYMENT CARD
                ============================================== --}}

                <section class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Pay Electricity Bill
                    </h4>


                    <form
                        id="electricityForm"
                        method="POST"
                        action="{{ route('electricity.purchase') }}"
                    >

                        @csrf


                        {{-- =====================================
                            ELECTRICITY PROVIDER
                        ====================================== --}}

                        <div class="mb-4">

                            <label
                                for="provider"
                                class="form-label fw-semibold"
                            >
                                Electricity Provider
                            </label>


                            <select
                                name="provider"
                                id="provider"
                                class="form-select py-3"
                                required
                            >

                                <option value="">Select Electricity Provider</option>

                                <option value="IKEDC">
                                    Ikeja Electric (IKEDC)
                                </option>

                                <option value="EKEDC">
                                    Eko Electric (EKEDC)
                                </option>

                                <option value="AEDC">
                                    Abuja Electric (AEDC)
                                </option>

                                <option value="KEDCO">
                                    Kano Electric (KEDCO)
                                </option>

                                <option value="PHEDC">
                                    Port Harcourt Electric (PHEDC)
                                </option>

                                <option value="JEDC">
                                    Jos Electric (JEDC)
                                </option>

                                <option value="KAEDCO">
                                    Kaduna Electric (KAEDCO)
                                </option>

                                <option value="EEDC">
                                    Enugu Electric (EEDC)
                                </option>

                                <option value="IBEDC">
                                    Ibadan Electric (IBEDC)
                                </option>

                                <option value="BEDC">
                                    Benin Electric (BEDC)
                                </option>

                                <option value="YEDC">
                                    Yola Electric (YEDC)
                                </option>

                            </select>

                        </div>



                        {{-- =====================================
                            METER TYPE
                        ====================================== --}}

                        <div class="mb-4">

                            <label
                                for="meter_type"
                                class="form-label fw-semibold"
                            >
                                Meter Type
                            </label>


                            <select
                                name="meter_type"
                                id="meter_type"
                                class="form-select py-3"
                                required
                            >

                                <option value="prepaid">
                                    Prepaid
                                </option>

                                <option value="postpaid">
                                    Postpaid
                                </option>

                            </select>

                        </div>



                        {{-- =====================================
                            METER NUMBER
                        ====================================== --}}

                        <div class="mb-4">

                            <label
                                for="meter_number"
                                class="form-label fw-semibold"
                            >
                                Meter Number
                            </label>


                            <input
                                type="text"
                                name="meter_number"
                                id="meter_number"
                                class="form-control py-3"
                                placeholder="Enter meter number"
                                autocomplete="off"
                                required
                            >

                        </div>



                        {{-- =====================================
                            PHONE NUMBER
                        ====================================== --}}

                        <div class="mb-4">

                            <label
                                for="phone"
                                class="form-label fw-semibold"
                            >
                                Phone Number
                            </label>


                            <input
                                type="tel"
                                name="phone"
                                id="phone"
                                class="form-control py-3"
                                placeholder="Enter phone number"
                                maxlength="15"
                                autocomplete="tel"
                                required
                            >

                        </div>



                        {{-- =====================================
                            AMOUNT
                        ====================================== --}}

                        <div class="mb-4">

                            <label
                                for="amount"
                                class="form-label fw-semibold"
                            >
                                Amount
                            </label>


                            <div class="input-group">

                                <span class="input-group-text">
                                    ₦
                                </span>


                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    class="form-control py-3"
                                    placeholder="Enter amount"
                                    min="500"
                                    step="1"
                                    required
                                >

                            </div>

                        </div>



                        {{-- =====================================
                            CUSTOMER NAME
                        ====================================== --}}

                        <div class="mb-4">

                            <label
                                for="customer_name"
                                class="form-label fw-semibold"
                            >
                                Customer Name
                            </label>


                            <input
                                type="text"
                                name="customer_name"
                                id="customer_name"
                                class="form-control py-3"
                                placeholder="Customer name will appear here"
                                readonly
                            >

                        </div>



                        {{-- =====================================
                            PAYMENT BUTTON
                        ====================================== --}}

                        <button
                            type="submit"
                            id="payButton"
                            class="pay-btn"
                        >

                            <i class="fa-solid fa-bolt me-2"></i>

                            Pay Bill

                        </button>

                    </form>

                </section>

            </div>



            {{-- =================================================
                RIGHT COLUMN
            ================================================== --}}

            <div class="col-lg-4">


                {{-- =============================================
                    PAYMENT INFORMATION
                ============================================== --}}

                <section class="custom-card mb-4">

                    <h5 class="fw-bold mb-4">
                        Payment Information
                    </h5>


                    {{-- Minimum Payment --}}

                    <div class="info-box mb-3">

                        <span>
                            Minimum Payment
                        </span>

                        <strong>
                            ₦500
                        </strong>

                    </div>


                    {{-- Service Charge --}}

                    <div class="info-box mb-3">

                        <span>
                            Service Charge
                        </span>

                        <strong>
                            Free
                        </strong>

                    </div>


                    {{-- Processing Time --}}

                    <div class="info-box">

                        <span>
                            Processing Time
                        </span>

                        <strong>
                            Instant
                        </strong>

                    </div>

                </section>



                {{-- =============================================================
                    RECENT ELECTRICITY PAYMENTS
                ============================================================== --}}

                <section class="custom-card">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>
                            <h5 class="fw-bold mb-1">
                                Recent Payments
                            </h5>

                            <small class="text-muted">
                                Your latest electricity transactions
                            </small>
                        </div>

                        <a
                            href="{{ route('history') }}"
                            class="text-decoration-none fw-semibold"
                        >
                            View All
                        </a>

                    </div>


                    {{-- =========================================================
                        TRANSACTIONS
                    ========================================================== --}}

                    @forelse ($transactions as $transaction)

                        <div class="history-item">

                            <div class="d-flex align-items-center gap-3">

                                {{-- Provider Icon --}}

                                <div
                                    class="rounded-circle d-flex align-items-center justify-content-center"
                                    style="
                                        width: 42px;
                                        height: 42px;
                                        background: #fff4e5;
                                        color: #f59e0b;
                                    "
                                >

                                    <i class="bi bi-lightning-charge-fill"></i>

                                </div>


                                {{-- Transaction Details --}}

                                <div>

                                    <h6 class="mb-1 fw-semibold">

                                        {{ $transaction->provider }}

                                        Electricity

                                    </h6>


                                    <small class="text-muted">

                                        {{ ucfirst($transaction->meter_type) }}

                                        •
                                        
                                        {{ $transaction->created_at->format('d M Y, h:i A') }}

                                    </small>

                                </div>

                            </div>


                            {{-- Amount + Status --}}

                            <div class="text-end">

                                <strong class="d-block">

                                    ₦{{ number_format($transaction->total, 2) }}

                                </strong>


                                @if ($transaction->status === 'successful')

                                    <small class="text-success fw-semibold">

                                        <i class="bi bi-check-circle-fill me-1"></i>
                                        Successful

                                    </small>

                                @elseif ($transaction->status === 'pending')

                                    <small class="text-warning fw-semibold">

                                        <i class="bi bi-clock-fill me-1"></i>
                                        Pending

                                    </small>

                                @elseif ($transaction->status === 'failed')

                                    <small class="text-danger fw-semibold">

                                        <i class="bi bi-x-circle-fill me-1"></i>
                                        Failed

                                    </small>

                                @else

                                    <small class="text-muted fw-semibold">

                                        {{ ucfirst($transaction->status) }}

                                    </small>

                                @endif

                            </div>

                        </div>


                    @empty

                        {{-- =====================================================
                            EMPTY STATE
                        ====================================================== --}}

                        <div class="text-center py-5">

                            <div
                                class="mx-auto mb-3 rounded-circle d-flex align-items-center justify-content-center"
                                style="
                                    width: 60px;
                                    height: 60px;
                                    background: #f4f7ff;
                                    color: #6c63ff;
                                "
                            >

                                <i
                                    class="bi bi-lightning-charge"
                                    style="font-size: 26px;"
                                ></i>

                            </div>


                            <h6 class="fw-semibold mb-1">
                                No Electricity Payments Yet
                            </h6>


                            <p class="text-muted small mb-0">
                                Your electricity payment history will appear here.
                            </p>

                        </div>

                    @endforelse

                </section>
            </div>

        </div>

    </main>



    {{-- =========================================================
        ELECTRICITY METER VERIFICATION
    ========================================================== --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            |--------------------------------------------------------------------------
            | ELEMENTS
            |--------------------------------------------------------------------------
            */

            const provider =
                document.getElementById('provider');

            const meterType =
                document.getElementById('meter_type');

            const meterNumber =
                document.getElementById('meter_number');

            const customerName =
                document.getElementById('customer_name');

            const payButton =
                document.getElementById('payButton');

            const electricityForm =
                document.getElementById('electricityForm');

            const csrfToken =
                document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content');


            /*
            |--------------------------------------------------------------------------
            | STATE
            |--------------------------------------------------------------------------
            */

            let verificationTimer = null;

            let meterVerified = false;


            /*
            |--------------------------------------------------------------------------
            | RESET VERIFICATION
            |--------------------------------------------------------------------------
            */

            function resetVerification() {

                meterVerified = false;

                payButton.disabled = true;

                customerName.value = '';

            }


            /*
            |--------------------------------------------------------------------------
            | VERIFY METER
            |--------------------------------------------------------------------------
            */

            function verifyMeter() {

                const selectedProvider =
                    provider.value;

                const selectedMeterType =
                    meterType.value;

                const selectedMeterNumber =
                    meterNumber.value.trim();


                /*
                | Validate fields before API request
                */

                if (
                    !selectedProvider ||
                    !selectedMeterType ||
                    !selectedMeterNumber
                ) {

                    resetVerification();

                    return;
                }


                /*
                | Reset previous verification
                */

                meterVerified = false;

                payButton.disabled = true;


                /*
                | Show verification status
                */

                customerName.value =
                    'Verifying meter...';


                /*
                | Send request to Laravel
                */

                fetch(
                    "{{ route('electricity.verify') }}",
                    {
                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',

                            'Accept': 'application/json',

                            'X-CSRF-TOKEN': csrfToken
                        },

                        body: JSON.stringify({

                            provider:
                                selectedProvider,

                            meter_type:
                                selectedMeterType,

                            meter_number:
                                selectedMeterNumber

                        })
                    }
                )

                /*
                | Convert response to JSON
                */

                .then(response => {

                    if (!response.ok) {
                        throw new Error(
                            'Verification request failed.'
                        );
                    }

                    return response.json();

                })


                /*
                | Process response
                */

                .then(data => {

                    if (data.success) {

                        customerName.value =
                            data.customer_name
                            || 'Customer verified';


                        meterVerified = true;

                        payButton.disabled = false;

                    } else {

                        customerName.value = '';

                        meterVerified = false;

                        payButton.disabled = true;


                        alert(
                            data.message
                            || 'Unable to verify meter.'
                        );

                    }

                })


                /*
                | Handle errors
                */

                .catch(error => {

                    console.error(
                        'Meter verification error:',
                        error
                    );


                    customerName.value = '';

                    meterVerified = false;

                    payButton.disabled = true;


                    alert(
                        'Unable to verify meter. Please try again.'
                    );

                });

            }


            /*
            |--------------------------------------------------------------------------
            | METER NUMBER INPUT
            |--------------------------------------------------------------------------
            */

            meterNumber.addEventListener(
                'input',
                function () {

                    clearTimeout(
                        verificationTimer
                    );


                    /*
                    | Every time the meter number changes,
                    | previous verification becomes invalid.
                    */

                    resetVerification();


                    /*
                    | Wait before sending API request.
                    | This prevents unnecessary requests while
                    | the user is typing.
                    */

                    verificationTimer =
                        setTimeout(
                            verifyMeter,
                            700
                        );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | PROVIDER CHANGE
            |--------------------------------------------------------------------------
            */

            provider.addEventListener(
                'change',
                function () {

                    resetVerification();

                    verifyMeter();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | METER TYPE CHANGE
            |--------------------------------------------------------------------------
            */

            meterType.addEventListener(
                'change',
                function () {

                    resetVerification();

                    verifyMeter();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | FORM SUBMISSION
            |--------------------------------------------------------------------------
            */

            electricityForm.addEventListener(
                'submit',
                function (event) {

                    /*
                    | Frontend protection only.
                    |
                    | The Laravel controller MUST still verify
                    | the meter/server-side before processing payment.
                    */

                    if (!meterVerified) {

                        event.preventDefault();

                        alert(
                            'Please verify your meter before making payment.'
                        );

                        return;
                    }


                    /*
                    | Prevent accidental double-clicks.
                    */

                    payButton.disabled = true;

                    payButton.innerHTML = `
                        <span
                            class="spinner-border spinner-border-sm me-2"
                            role="status"
                            aria-hidden="true"
                        ></span>

                        Processing Payment...
                    `;

                }
            );

        });

    </script>

</body>

</html>