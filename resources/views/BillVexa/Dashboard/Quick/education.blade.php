<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Education | {{ $setting->site_name ?? 'BillVexa' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background: #f5f7fb;
            font-family: Inter, Arial, sans-serif;
        }

/* SIDEBAR */
.sidebar{

    width:260px;
    height:100vh;

    position:fixed;
    top:0;
    left:0;

    background:linear-gradient(
        180deg,
        #5b21b6,
        #2563eb
    );

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

    color:rgba(255,255,255,.8);

    text-decoration:none;

    padding:14px 16px;

    border-radius:14px;

    margin-bottom:10px;

    transition:.3s ease;
}

.sidebar a:hover,
.sidebar a.active{

    background:rgba(255,255,255,.15);

    color:white;

    transform:translateX(5px);
}

        .brand {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 35px;
            padding-left: 12px;
        }

        .brand span {
            color: #635bff;
        }

        .nav-link {
            color: #667085;
            padding: 13px 15px;
            margin-bottom: 5px;
            border-radius: 10px;
            font-weight: 500;
        }

        .nav-link i {
            margin-right: 12px;
            font-size: 18px;
        }

        .nav-link:hover,
        .nav-link.active {
            background: #635bff;
            color: white;
        }

        .main {
            margin-left: 250px;
            padding: 25px 35px;
        }

    /* TOPBAR */
    .topbar{

        background:white;

        padding:18px 25px;

        border-radius:20px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);

        margin-bottom:30px;
    }

        .notification {
            width: 42px;
            height: 42px;
            background: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
            position: relative;
        }

        .notification span {
            position: absolute;
            top: 2px;
            right: 1px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
        }

        .profile {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: 15px;
        }

        .avatar {
            width: 42px;
            height: 42px;
            background: #635bff;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .btn-light-custom {
            background: white;
            color: #635bff;
            border: none;
            padding: 10px 18px;
            border-radius: 9px;
            font-weight: 600;
        }

        .education-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            height: 100%;
            border: 1px solid #edf0f5;
            transition: .2s;
            cursor: pointer;
        }

        .education-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,.07);
        }

        .service-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: #f0efff;
            color: #635bff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .education-card h6 {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .education-card p {
            font-size: 13px;
            color: #8a94a6;
            margin-bottom: 15px;
        }

        .service-btn {
            color: #635bff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .section-title {
            font-weight: 750;
            margin-bottom: 18px;
        }

        .quick-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #edf0f5;
        }

        .quick-action {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #344054;
            text-decoration: none;
            padding: 12px;
            border-radius: 10px;
        }

        .quick-action:hover {
            background: #f5f3ff;
            color: #635bff;
        }

        .quick-icon {
            width: 40px;
            height: 40px;
            background: #f0efff;
            color: #635bff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .transaction-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #edf0f5;
            overflow: hidden;
        }

        .transaction-row {
            padding: 17px 20px;
            border-bottom: 1px solid #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .transaction-row:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #f0efff;
            color: #635bff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success {
            color: #16a34a;
            font-weight: 600;
        }

        .pending {
            color: #f59e0b;
            font-weight: 600;
        }

        @media(max-width: 991px) {
            .sidebar {
                width: 70px;
                padding: 20px 10px;
            }

            .brand {
                font-size: 18px;
                text-align: center;
                padding: 0;
            }

            .brand-text,
            .nav-link span {
                display: none;
            }

            .nav-link {
                text-align: center;
            }

            .nav-link i {
                margin: 0;
            }

            .main {
                margin-left: 70px;
                padding: 20px;
            }
        }

        @media(max-width: 576px) {
            .main {
                margin-left: 0;
                padding: 15px;
                padding-bottom: 80px;
            }

            .sidebar {
                display: none;
            }

            .topbar {
                margin-bottom: 20px;
            }

            .profile-name {
                display: none;
            }

            .balance {
                font-size: 28px;
            }

            .mobile-nav {
                display: flex !important;
            }
        }

        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            height: 65px;
            z-index: 2000;
            border-top: 1px solid #eee;
            justify-content: space-around;
            align-items: center;
        }

        .mobile-nav a {
            color: #8a94a6;
            text-decoration: none;
            font-size: 11px;
            text-align: center;
        }

        .mobile-nav a i {
            display: block;
            font-size: 20px;
            margin-bottom: 2px;
        }

        .mobile-nav a.active {
            color: #635bff;
        }
    </style>
</head>

<body>

<!-- SIDEBAR -->
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


<!-- MAIN -->
<main class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div>
            <h4>Education</h4>
            <small class="text-muted">
                Access educational services easily
            </small>
        </div>
    </div>


    <!-- BALANCE + QUICK ACTION -->
    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="quick-card h-100">

                <h6 class="fw-bold mb-3">
                    Quick Actions
                </h6>

                <a href="#" class="quick-action">
                    <div class="quick-icon">
                        <i class="bi bi-receipt"></i>
                    </div>

                    <div>
                        <strong>Buy PIN</strong>
                        <small class="d-block text-muted">
                            Get examination PIN
                        </small>
                    </div>
                </a>

                <a href="#" class="quick-action">
                    <div class="quick-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <div>
                        <strong>Check Result</strong>
                        <small class="d-block text-muted">
                            Check examination result
                        </small>
                    </div>
                </a>

            </div>

        </div>

    </div>


    <!-- SERVICES -->
    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center">
            <h5 class="section-title">
                Education Services
            </h5>

            <span class="text-muted small">
                6 Services
            </span>
        </div>


        <div class="row g-3">

            <!-- JAMB -->
            <div class="col-6 col-md-4">

                <div class="education-card"
                     onclick="openEducation('JAMB')">

                    <div class="service-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>

                    <h6>JAMB</h6>

                    <p>
                        Purchase JAMB examination PIN and services.
                    </p>

                    <a href="#" class="service-btn">
                        Continue
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- WAEC -->
            <div class="col-6 col-md-4">

                <div class="education-card"
                     onclick="openEducation('WAEC')">

                    <div class="service-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <h6>WAEC</h6>

                    <p>
                        Check WAEC results and purchase result PINs.
                    </p>

                    <a href="#" class="service-btn">
                        Continue
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- NECO -->
            <div class="col-6 col-md-4">

                <div class="education-card"
                     onclick="openEducation('NECO')">

                    <div class="service-icon">
                        <i class="bi bi-journal-check"></i>
                    </div>

                    <h6>NECO</h6>

                    <p>
                        Access NECO result checking services.
                    </p>

                    <a href="#" class="service-btn">
                        Continue
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- NABTEB -->
            <div class="col-6 col-md-4">

                <div class="education-card"
                     onclick="openEducation('NABTEB')">

                    <div class="service-icon">
                        <i class="bi bi-award"></i>
                    </div>

                    <h6>NABTEB</h6>

                    <p>
                        Check NABTEB examination results.
                    </p>

                    <a href="#" class="service-btn">
                        Continue
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- SCHOOL FEES -->
            <div class="col-6 col-md-4">

                <div class="education-card"
                     onclick="openEducation('School Fees')">

                    <div class="service-icon">
                        <i class="bi bi-building"></i>
                    </div>

                    <h6>School Fees</h6>

                    <p>
                        Pay school fees from your {{ $setting->site_name ?? 'BillVexa' }} wallet.
                    </p>

                    <a href="#" class="service-btn">
                        Continue
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- RESULT CHECKER -->
            <div class="col-6 col-md-4">

                <div class="education-card"
                     onclick="openEducation('Result Checker')">

                    <div class="service-icon">
                        <i class="bi bi-patch-check"></i>
                    </div>

                    <h6>Result Checker</h6>

                    <p>
                        Check supported examination results.
                    </p>

                    <a href="#" class="service-btn">
                        Continue
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </div>


    <!-- RECENT TRANSACTIONS -->
    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="section-title mb-0">
                Recent Education Transactions
            </h5>

            <a href="{{ url('/dashboard/history') }}"
               class="text-decoration-none"
               style="color:#635bff;">
                View All
            </a>

        </div>


        <div class="transaction-card">

            <!-- Transaction 1 -->
            <div class="transaction-row">

                <div class="d-flex align-items-center gap-3">

                    <div class="transaction-icon">
                        <i class="bi bi-mortarboard"></i>
                    </div>

                    <div>
                        <strong>JAMB PIN</strong>
                        <small class="d-block text-muted">
                            Today, 10:24 AM
                        </small>
                    </div>

                </div>

                <div class="text-end">

                    <strong>₦5,000</strong>

                    <small class="d-block success">
                        Successful
                    </small>

                </div>

            </div>


            <!-- Transaction 2 -->
            <div class="transaction-row">

                <div class="d-flex align-items-center gap-3">

                    <div class="transaction-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <div>
                        <strong>WAEC Result Checker</strong>
                        <small class="d-block text-muted">
                            Yesterday, 3:15 PM
                        </small>
                    </div>

                </div>

                <div class="text-end">

                    <strong>₦1,500</strong>

                    <small class="d-block success">
                        Successful
                    </small>

                </div>

            </div>


            <!-- Transaction 3 -->
            <div class="transaction-row">

                <div class="d-flex align-items-center gap-3">

                    <div class="transaction-icon">
                        <i class="bi bi-building"></i>
                    </div>

                    <div>
                        <strong>School Fees</strong>
                        <small class="d-block text-muted">
                            25 Aug, 11:40 AM
                        </small>
                    </div>

                </div>

                <div class="text-end">

                    <strong>₦35,000</strong>

                    <small class="d-block pending">
                        Pending
                    </small>

                </div>

            </div>

        </div>

    </div>

</main>


<!-- MOBILE NAV -->
<div class="mobile-nav">

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


<script>
    function openEducation(service) {

        // Replace this with your Laravel route later
        alert(service + " service selected");

    }
</script>

</body>
</html>

