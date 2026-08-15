<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $setting->site_name ?? 'BillVexa' }} - Refer & Earn</title>

    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        /* TABLE */
        .table thead th{

            border:none;

            color:#777;

            font-weight:600;
        }

        .table tbody td{

            vertical-align:middle;

            border-color:#f1f1f1;
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

        

        .referral-card{
            background:linear-gradient(
                135deg,
                #5b21b6,
                #2563eb
            );
            color:white;
            border-radius:25px;
            padding:30px;
            box-shadow:0 15px 40px rgba(0,0,0,.12);
        }

        .stats-card{
            background:white;
            border-radius:20px;
            padding:20px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }

        .referral-link-box{
            background:#f8f9fa;
            border:1px dashed #ccc;
            border-radius:15px;
            padding:15px;
            word-break:break-all;
        }

        .earn-step{
            background:white;
            border-radius:20px;
            padding:20px;
            text-align:center;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
            height:100%;
        }

        .step-icon{
            width:70px;
            height:70px;
            border-radius:50%;
            margin:auto;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            color:white;
            background:#5b21b6;
            margin-bottom:15px;
        }

        .history-card{
            background:white;
            border-radius:20px;
            padding:20px;
            box-shadow:0 10px 25px rgba(0,0,0,.05);
        }

        @media(max-width:576px){

            .referral-card{
                padding:20px;
            }

            .step-icon{
                width:60px;
                height:60px;
                font-size:24px;
            }

        }

        /* MAIN CONTENT */
        .main-content{
            margin-left:260px;
            padding:25px;
        }

        /* MOBILE */
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

        <a href={{ route('service') }}>
            <i class="bi bi-gear"></i>
            Services
        </a>

        <a href={{ route('refer') }} class="active">
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

        <a href={{ route('service') }} >
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>

        <a href={{ route('refer') }} class="active">
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

    <div class="main-content">  

        <div class="container-fluid py-2">
            <!-- HEADER -->

            <div class="referral-card mb-4">

                <h2 class="fw-bold">
                    <i class="bi bi-people-fill me-2"></i>
                    Refer & Earn
                </h2>

                <p class="mb-3">
                    Invite your friends to {{ $setting->site_name ?? 'BillVexa' }} and earn rewards whenever they sign up and make transactions.
                </p>

                <h4 class="fw-bold">
                    Earn ₦500 Per Referral
                </h4>

            </div>

            <!-- REFERRAL STATS -->

            <div class="row g-4 mb-4">

                <div class="col-md-4">

                    <div class="stats-card">

                        <small class="text-muted">
                            Total Referrals
                        </small>

                        <h3 class="fw-bold mt-2">

                            {{ $totalReferrals }}

                        </h3>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="stats-card">

                        <small class="text-muted">
                            Successful Referrals
                        </small>

                        <h3 class="fw-bold mt-2 text-success">

                            {{ $successfulReferrals }}

                        </h3>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="stats-card">

                        <small class="text-muted">
                            Total Earnings
                        </small>

                        <h3 class="fw-bold mt-2 text-primary">
                            ₦{{ number_format($earnings) }}

                        </h3>

                    </div>

                </div>

            </div>

            <!-- REFERRAL LINK -->

            <div class="history-card mb-4">

                <h5 class="fw-bold mb-3">
                    Your Referral Link
                </h5>

                <div class="referral-link-box mb-3">

                    <span id="refLink">
                        {{ url('/signin?ref=' . auth()->user()->referral_code) }}
                    </span>

                </div>

                <button
                    class="btn btn-primary"
                    onclick="copyReferralLink()">

                    <i class="bi bi-copy me-2"></i>
                    Copy Link

                </button>

            </div>

            <div class="history-card mt-4 table-responsive">

                <h5 class="fw-bold mb-3">
                    Referral History
                </h5>

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Joined</th>
                        </tr>
                    </thead>

                    <tbody>

                    @forelse($user->referrals as $referral)

                        <tr>
                            <td>{{ $referral->name }}</td>
                            <td>{{ $referral->email }}</td>
                            <td>{{ $referral->created_at->format('d M Y') }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="3">
                                No referrals yet.
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <!-- HOW IT WORKS -->

            <h4 class="fw-bold mb-3">
                How It Works
            </h4>

            <div class="row g-4 mb-4">

                <div class="col-md-4">

                    <div class="earn-step">

                        <div class="step-icon">
                            <i class="bi bi-share-fill"></i>
                        </div>

                        <h6 class="fw-bold">
                            Share Link
                        </h6>

                        <p class="text-muted mb-0">
                            Share your referral link with friends.
                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="earn-step">

                        <div class="step-icon">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>

                        <h6 class="fw-bold">
                            Friend Registers
                        </h6>

                        <p class="text-muted mb-0">
                            They sign up using your referral link.
                        </p>

                    </div>

                </div>

                <div class="col-md-4">

                    <div class="earn-step">

                        <div class="step-icon">
                            <i class="bi bi-cash-coin"></i>
                        </div>

                        <h6 class="fw-bold">
                            Earn Reward
                        </h6>

                        <p class="text-muted mb-0">
                            You receive your referral bonus automatically.
                        </p>

                    </div>

                </div>

            </div>

        </div>
    </div>



    <script>

    function copyReferralLink(){

        let link =
        document.getElementById("refLink").innerText;

        navigator.clipboard.writeText(link);

        alert("Referral Link Copied Successfully!");

    }

    </script>

    <script src="../../Assets/libs/js/bootstrap.bundle.js"></script>

</body>
</html>