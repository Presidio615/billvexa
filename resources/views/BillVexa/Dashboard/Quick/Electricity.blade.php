<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Electricity Dashboard
    </title>

    <!-- icon image -->
    <link rel="shortcut icon"
    href="../../../Assets/Image/icon.png" type="image/x-icon">

    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7ff;
            font-family:Arial, Helvetica, sans-serif;
            overflow-x:hidden;
        }

        /* SIDEBAR */
        .sidebar{

            width:260px;
            min-height:100vh;

            background:linear-gradient(
                180deg,
                #5b21b6,
                #2563eb
            );

            position:fixed;
            left:0;
            top:0;

            padding:25px 15px;

            z-index:1000;
        }

        .logo{
            color:white;
            font-size:28px;
            font-weight:bold;
            margin-bottom:40px;
        }

        .sidebar a{

            display:flex;
            align-items:center;
            gap:12px;

            color:white;
            text-decoration:none;

            padding:14px 16px;
            border-radius:12px;

            margin-bottom:10px;

            transition:.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active{

            background:rgba(255,255,255,.15);

            transform:translateX(5px);
        }

        /* MAIN CONTENT */
        .main-content{
            margin-left:260px;
            padding:30px;
        }

        /* TOPBAR */
        .topbar{

            background:white;

            padding:18px 25px;

            border-radius:18px;

            box-shadow:0 2px 10px rgba(0,0,0,.05);

            margin-bottom:30px;
        }

        /* CARD */
        .custom-card{

            background:white;

            border-radius:24px;

            padding:30px;

            box-shadow:0 5px 20px rgba(0,0,0,.05);
        }

        /* HERO CARD */
        .electricity-card{

            background:linear-gradient(
                135deg,
                #ffb300,
                #ff7b00
            );

            color:white;

            border-radius:25px;

            padding:35px;

            position:relative;

            overflow:hidden;
        }

        .electricity-card::before{

            content:"";

            position:absolute;

            width:220px;
            height:220px;

            border-radius:50%;

            background:rgba(255,255,255,.1);

            top:-80px;
            right:-80px;
        }

        .electricity-card h1{
            font-size:3rem;
            font-weight:bold;
        }

        /* BUTTON */
        .pay-btn{

            background:linear-gradient(
                135deg,
                blueviolet,
                #4b49f5
            );

            border:none;

            padding:14px;

            border-radius:14px;

            color:white;

            font-weight:bold;

            transition:.3s ease;
        }

        .pay-btn:hover{

            transform:translateY(-2px);

            opacity:.95;
        }

        /* INFO BOX */
        .info-box{

            background:#f8f9ff;

            border-radius:16px;

            padding:18px;
        }

        /* HISTORY */
        .history-item{

            padding:15px 0;

            border-bottom:1px solid #eee;
        }

        .history-item:last-child{
            border-bottom:none;
        }

        /* MOBILE */
        @media(max-width:992px){

            .sidebar{
                width:100%;
                height:auto;
                position:relative;
            }

            .main-content{
                margin-left:0;
                padding:20px;
            }

            .electricity-card h1{
                font-size:2.2rem;
            }

        }

        /* MOBILE BOTTOM NAV */
        .mobile-nav{

            position:fixed;

            bottom:0;
            left:0;

            width:100%;

            background:white;

            padding:10px 0;

            box-shadow:0 -5px 20px rgba(0,0,0,.08);

            z-index:2000;
        }

        .mobile-nav a{

            display:flex;
            flex-direction:column;

            align-items:center;
            justify-content:center;

            text-decoration:none;

            color:#777;

            font-size:12px;

            gap:4px;
        }

        .mobile-nav a i{
            font-size:20px;
        }

        .mobile-nav a.active{
            color:blueviolet;
        }

        /* MOBILE */
        @media(max-width:991px){

            body{
                padding-bottom:80px;
            }

            .main-content{
                margin-left:0;
                padding:20px;
            }
        }

    </style>

</head>
<body>

<!-- DESKTOP SIDEBAR -->
    <div class="sidebar d-none d-lg-flex flex-column">

        <div class="logo mb-5 text-white fs-2 fw-bold">
            {{ $setting->site_name ?? 'BillVexa' }}
        </div>

        <a href={{ route('dashboard') }}>
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a href={{ route('service') }} >
            <i class="bi bi-gear"></i>
            Services
        </a>

        <a href={{ route('refer') }} >
            <i class="bi bi-people"></i>
            Refer & Earn
        </a>

        <a href={{ route('history') }} >
            <i class="bi bi-clock-history"></i>
            Transactions
        </a>

        <a href={{ route('profile.edit') }} >
            <i class="bi bi-person-lines-fill"></i>
            Profile
        </a>

    </div>
    <!-- MOBILE BOTTOM NAV -->
    <div class="mobile-nav d-flex d-lg-none justify-content-around align-items-center">

        <a href={{ route('dashboard') }}>
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>

        <a href={{ route('service') }} >
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>

        <a href={{ route('refer') }} >
            <i class="bi bi-people"></i>
            <small>Refer & Earn</small>
        </a>

        <a href={{ route('history') }} >
            <i class="bi bi-clock-history"></i>
            <small>History</small>
        </a>

        <a href={{ route('profile.edit') }} >
            <i class="bi bi-person-lines-fill"></i>
            <small>Profile</small>
        </a>

    </div>


    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">
                    Electricity
                </h4>

                <small class="text-muted">
                    Manage and pay electricity bills easily
                </small>

            </div>

        </div>

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <!-- PAYMENT FORM -->
                <div class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Pay Electricity Bill
                    </h4>

                    <form>

                        <!-- PROVIDER -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Electricity Provider
                            </label>

                            <select class="form-select py-3">

                                <option selected disabled>
                                    Select Provider
                                </option>

                                <option>
                                    IKEDC
                                </option>

                                <option>
                                    EKEDC
                                </option>

                                <option>
                                    AEDC
                                </option>

                                <option>
                                    KEDCO
                                </option>

                            </select>

                        </div>

                        <!-- METER TYPE -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Meter Type
                            </label>

                            <select class="form-select py-3">

                                <option>
                                    Prepaid
                                </option>

                                <option>
                                    Postpaid
                                </option>

                            </select>

                        </div>

                        <!-- METER NUMBER -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Meter Number
                            </label>

                            <input type="text"
                            class="form-control py-3"
                            placeholder="Enter meter number">

                        </div>

                        <!-- AMOUNT -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Amount
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    ₦
                                </span>

                                <input type="number"
                                class="form-control py-3"
                                placeholder="Enter amount">

                            </div>

                        </div>

                        <!-- CUSTOMER NAME -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Customer Name
                            </label>

                            <input type="text"
                            class="form-control py-3"
                            placeholder="Customer name"
                            readonly>

                        </div>

                        <!-- BUTTON -->
                        <button class="pay-btn w-100">

                            <i class="fa-solid fa-bolt me-2"></i>
                            Pay Bill

                        </button>

                    </form>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <!-- INFO -->
                <div class="custom-card mb-4">

                    <h5 class="fw-bold mb-4">
                        Payment Info
                    </h5>

                    <div class="info-box mb-3 d-flex justify-content-between">

                        <span>
                            Minimum Payment
                        </span>

                        <strong>
                            ₦500
                        </strong>

                    </div>

                    <div class="info-box mb-3 d-flex justify-content-between">

                        <span>
                            Service Charge
                        </span>

                        <strong>
                            Free
                        </strong>

                    </div>

                    <div class="info-box d-flex justify-content-between">

                        <span>
                            Processing Time
                        </span>

                        <strong>
                            Instant
                        </strong>

                    </div>

                </div>

                <!-- HISTORY -->
                <div class="custom-card">

                    <div class="d-flex justify-content-between mb-4">

                        <h5 class="fw-bold">
                            Recent Payments
                        </h5>

                        <a href={{ route('history') }}
                        class="text-decoration-none">
                            View all
                        </a>

                    </div>

                    <div class="history-item d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1">
                                IKEDC Payment
                            </h6>

                            <small class="text-muted">
                                Today • 10:20 AM
                            </small>

                        </div>

                        <strong class="text-success">
                            ₦15,000
                        </strong>

                    </div>

                    <div class="history-item d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1">
                                EKEDC Payment
                            </h6>

                            <small class="text-muted">
                                Yesterday • 4:00 PM
                            </small>

                        </div>

                        <strong class="text-success">
                            ₦7,500
                        </strong>

                    </div>

                    <div class="history-item d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1">
                                AEDC Payment
                            </h6>

                            <small class="text-muted">
                                29 May • 8:15 AM
                            </small>

                        </div>

                        <strong class="text-success">
                            ₦20,000
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </div>


</body>
</html>