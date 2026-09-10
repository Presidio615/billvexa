<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->site_name ?? 'BillVexa' }}Services Dashboard</title>

    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <style>

        body{
            background:#f4f7ff;
            font-family:Arial, Helvetica, sans-serif;
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

        /* MOBILE NAV */
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

        .services-card{
            background:#fff;
            border-radius:25px;
            padding:25px;
            box-shadow:0 10px 30px rgba(0,0,0,.05);
        }

        .service-item{
            text-decoration:none;
            color:#212529;
            display:block;
            transition:.3s ease;
        }

        .service-item:hover{
            transform:translateY(-5px);
        }

        .icon-box{
            width:65px;
            height:65px;
            border-radius:18px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            font-size:26px;
            margin:auto;
        }

        .purple{
            background:#7c3aed;
        }

        .green{
            background:#16a34a;
        }

        .orange{
            background:#ea580c;
        }

        .blue{
            background:#2563eb;
        }

        .red{
            background:#dc2626;
        }

        .dark{
            background:#111827;
        }

        .service-name{
            margin-top:10px;
            font-size:14px;
            font-weight:600;
        }

        @media(max-width:576px){

            .services-card{
                padding:20px;
            }

            .icon-box{
                width:55px;
                height:55px;
                font-size:22px;
            }

            .service-name{
                font-size:13px;
            }

        }

        .main-content{
            margin-left:260px;
            padding:25px;
        }

        @media(max-width:991px){

            .main-content{
                margin-left:0;
                padding:20px;
            }

            body{
                padding-bottom:80px;
            }
        }

    </style>

</head>
<body>


    <!-- DESKTOP SIDEBAR -->
    <div class="sidebar d-none d-lg-flex flex-column">

        <h4 class="mb-4 d-flex align-items-center logo mb-5 text-white fs-2 fw-bold">

            @if($setting && $setting->logo)

                <img src="{{ asset('storage/'.$setting->logo) }}"
                    width="40"
                    height="40"
                    class="rounded me-2">

            @else

                <i class="bi bi-grid me-2"></i>

            @endif

            {{ $setting->site_name ?? 'BillVexa' }}

        </h4>

        <a href={{ route('dashboard') }}>
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a href={{ route('service') }} class="active">
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

        <a href={{ route('dashboard') }} >
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>

        <a href={{ route('service') }} class="active">
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

    <div class="container-fluid">

        <!-- PAGE HEADER -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h4 class="fw-bold mb-1">
                        Services
                    </h4>

                    <small class="text-muted">
                        Access all {{ $setting->site_name ?? 'BillVexa' }} services in one place
                    </small>
                </div>

            </div>

        </div>

        <!-- SERVICES -->
        <div class="services-card">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h4 class="fw-bold mb-0">
                    Services
                </h4>

                <small class="text-muted">
                    Quick Access
                </small>

            </div>

            <div class="row g-4">

                <!-- Airtime -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href={{ route('airtime') }} class="service-item text-center">
                        <div class="icon-box purple">
                            <i class="bi bi-phone-fill"></i>
                        </div>
                        <div class="service-name">Airtime</div>
                    </a>
                </div>

                <!-- Data -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href={{ route('data') }} class="service-item text-center">
                        <div class="icon-box green">
                            <i class="bi bi-wifi"></i>
                        </div>
                        <div class="service-name">Data</div>
                    </a>
                </div>

                <!-- Cable TV -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href={{ route('cable.tv') }} class="service-item text-center">
                        <div class="icon-box orange">
                            <i class="bi bi-tv-fill"></i>
                        </div>
                        <div class="service-name">Cable TV</div>
                    </a>
                </div>

                <!-- Electricity -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href={{ route('electricity') }} class="service-item text-center">
                        <div class="icon-box blue">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <div class="service-name">Electricity</div>
                    </a>
                </div>

                <!-- Betting -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href={{ route('bet') }} class="service-item text-center">
                        <div class="icon-box red">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div class="service-name">Betting</div>
                    </a>
                </div>

                <!-- Education -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('education') }}" class="service-item text-center">
                        <div class="icon-box dark">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <div class="service-name">Education</div>
                    </a>
                </div>

                <!-- Sport -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('sports') }}" class="service-item text-center">
                        <div class="icon-box green">
                            <i class="fa-solid fa-futbol"></i>
                        </div>
                        <div class="service-name">Sport</div>
                    </a>
                </div>

                <!-- Flight -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('flight') }}" class="service-item text-center">
                        <div class="icon-box orange">
                            <i class="bi bi-airplane-fill"></i>
                        </div>
                        <div class="service-name">Flight</div>
                    </a>
                </div>

                <!-- Hotel -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('hotel') }}" class="service-item text-center">
                        <div class="icon-box blue">
                            <i class="fa-solid fa-hotel"></i>
                        </div>
                        <div class="service-name">Hotel</div>
                    </a>
                </div>

                <!-- Gift Card -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('gift-card') }}" class="service-item text-center">
                        <div class="icon-box red">
                            <i class="bi bi-credit-card-fill"></i>
                        </div>
                        <div class="service-name">Gift Card</div>
                    </a>
                </div>

                <!-- Ticket -->
                <div class="col-4 col-md-3 col-lg-2">
                    <a href="{{ route('ticket') }}" class="service-item text-center">
                        <div class="icon-box dark">
                            <i class="bi bi-ticket-fill"></i>
                        </div>
                        <div class="service-name">Ticket</div>
                    </a>
                </div>

            </div>

        </div>

    </div>

</div>
<!-- END MAIN CONTENT -->
<script src="../../Assets/libs/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/js/all.min.js"></script>

</body>
</html>