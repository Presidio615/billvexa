<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Cable TV Dashboard
    </title>

    <!-- icon image -->
    <link rel="shortcut icon" 
    href="../../../Assets/Image/icon.png" type="image/x-icon">

    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        height:100vh;

        position:fixed;
        top:0;
        left:0;

        background:linear-gradient(
            180deg,
            #7c3aed,
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

    /* MAIN */
    .main-content{

        margin-left:260px;

        padding:30px;
    }

    /* TOPBAR */
    .topbar{

        background:white;

        padding:18px 25px;

        border-radius:20px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);

        margin-bottom:30px;
    }

    /* HERO CARD */
    .tv-card{

        background:linear-gradient(
            180deg,
            #5b21b6,
            #2563eb
        );

        color:white;

        border-radius:30px;

        padding:35px;

        position:relative;

        overflow:hidden;

        box-shadow:0 15px 40px rgba(0,0,0,.08);
    }

    .tv-card::before{

        content:"";

        position:absolute;

        width:260px;
        height:260px;

        border-radius:50%;

        background:rgba(255,255,255,.1);

        top:-100px;
        right:-80px;
    }

    .tv-card h1{

        font-size:3rem;
        font-weight:bold;
    }

    /* CUSTOM CARD */
    .custom-card{

        background:white;

        border-radius:22px;

        padding:25px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);
    }

    /* PROVIDER CARD */
    .provider-card{

        border:1px solid #e5e7eb;

        border-radius:18px;

        padding:20px;

        text-align:center;

        transition:.3s ease;

        cursor:pointer;
    }

    .provider-card:hover{

        border-color: #7c3aed;

        background: #f6f0ff;

        transform:translateY(-5px);
    }

    .provider-card.clicked{

        background-color: #f6f0ff;

        border-color: #7c3aed;

        transform:translateY(-5px);
    }  

    /* PLAN CARD */
    .plan-card{

        border:1px solid #e5e7eb;

        border-radius:18px;

        padding:18px;

        transition:.3s ease;

        cursor:pointer;
    }

    .plan-card:hover{

        border-color:#7c3aed;

        background:#f8f5ff;

        transform:translateY(-5px);
    }

    /* FORM */
    .form-control,
    .form-select{

        border-radius:14px;

        padding:14px;

        border:1px solid #dbe1ea;
    }

    .form-control:focus,
    .form-select:focus{

        box-shadow:none;

        border-color:#7c3aed;
    }

    /* BUTTON */
    .subscribe-btn{

        background:linear-gradient(
            135deg,
            #7c3aed,
            #2563eb
        );

        border:none;

        border-radius:14px;

        padding:15px;

        color:white;

        font-weight:bold;

        transition:.3s ease;
    }

    .subscribe-btn:hover{

        transform:translateY(-3px);

        opacity:.95;
    }

    /* TRANSACTIONS */
    .transaction-item{

        padding:16px 0;

        border-bottom:1px solid #f0f0f0;
    }

    .transaction-item:last-child{
        border-bottom:none;
    }

    /* MOBILE NAV */
    .mobile-nav{
        display:none;
    }

    /* MOBILE */
    @media(max-width:992px){

        .sidebar{
            display:none;
        }

        .main-content{

            margin-left:0;

            padding:20px;

            padding-bottom:100px;
        }

        .tv-card h1{
            font-size:2rem;
        }

        .mobile-nav{

            display:flex;

            justify-content:space-around;
            align-items:center;

            position:fixed;

            bottom:0;
            left:0;

            width:100%;

            background:white;

            padding:12px 5px;

            box-shadow:0 -5px 20px rgba(0,0,0,.08);

            z-index:2000;
        }

        .mobile-nav a{

            text-decoration:none;

            color:#666;

            font-size:13px;

            display:flex;
            flex-direction:column;
            align-items:center;

            gap:4px;
        }

        .mobile-nav a.active{
            color:#7c3aed;
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

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">
                    Cable TV 
                </h4>

                <small class="text-muted">
                    Renew and manage your TV subscriptions
                </small>

            </div>

        </div>

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <!-- SUBSCRIBE -->
                <div class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Subscribe Cable TV
                    </h4>

                    <form>

                        <!-- PROVIDER -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select TV Provider
                            </label>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <a href="#" class="nav-link">
                                        <div class="provider-card">
                                            
                                            <i class="fa-solid fa-tv fs-2 text-primary mb-2"></i>

                                            <h6 class="fw-bold">
                                                DStv
                                            </h6> 

                                        </div>
                                    </a>

                                </div>

                                <div class="col-md-4">

                                    <div class="provider-card">

                                        <i class="fa-solid fa-satellite-dish fs-2 text-danger mb-2"></i>

                                        <h6 class="fw-bold">
                                            GOtv
                                        </h6>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="provider-card">

                                        <i class="fa-solid fa-display fs-2 text-success mb-2"></i>

                                        <h6 class="fw-bold">
                                            Startimes
                                        </h6>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- SMART CARD -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Smart Card / IUC Number
                            </label>

                            <input type="text"
                            class="form-control"
                            placeholder="Enter smart card number">

                        </div>

                        <!-- CUSTOMER NAME -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Customer Name
                            </label>

                            <input type="text"
                            class="form-control"
                            placeholder="Customer name"
                            readonly>

                        </div>

                        <!-- PLAN -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select Subscription Plan
                            </label>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <div class="plan-card">

                                        <h6 class="fw-bold">
                                            Compact
                                        </h6>

                                        <small class="text-muted">
                                            30 days access
                                        </small>

                                        <h5 class="fw-bold mt-3 text-primary">
                                            ₦9,000
                                        </h5>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="plan-card">

                                        <h6 class="fw-bold">
                                            Premium
                                        </h6>

                                        <small class="text-muted">
                                            Full package
                                        </small>

                                        <h5 class="fw-bold mt-3 text-primary">
                                            ₦21,000
                                        </h5>

                                    </div>

                                </div>

                                <div class="col-md-4">

                                    <div class="plan-card">

                                        <h6 class="fw-bold">
                                            Smallie
                                        </h6>

                                        <small class="text-muted">
                                            Budget package
                                        </small>

                                        <h5 class="fw-bold mt-3 text-primary">
                                            ₦3,500
                                        </h5>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <button class="subscribe-btn w-100">

                            <i class="fa-solid fa-circle-check me-2"></i>

                            Subscribe Now

                        </button>

                    </form>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <!-- INFO -->
                <div class="custom-card mb-4">

                    <h5 class="fw-bold mb-4">
                        Subscription Info
                    </h5>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Minimum Plan
                        </span>

                        <strong>
                            ₦1,000
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Activation Time
                        </span>

                        <strong>
                            Instant
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="text-muted">
                            Service Charge
                        </span>

                        <strong>
                            Free
                        </strong>

                    </div>

                </div>

                <!-- RECENT -->
                <div class="custom-card">

                    <div class="d-flex justify-content-between mb-4">

                        <h5 class="fw-bold">
                            Recent Subscriptions
                        </h5>

                        <a href={{ route('history') }}
                        class="text-decoration-none">
                            View all
                        </a>

                    </div>

                    <div class="transaction-item d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1">
                                DStv Compact
                            </h6>

                            <small class="text-muted">
                                Today • 10:20 AM
                            </small>

                        </div>

                        <strong class="text-success">
                            ₦9,000
                        </strong>

                    </div>

                    <div class="transaction-item d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1">
                                GOtv Max
                            </h6>

                            <small class="text-muted">
                                Yesterday • 8:00 PM
                            </small>

                        </div>

                        <strong class="text-success">
                            ₦6,200
                        </strong>

                    </div>

                    <div class="transaction-item d-flex justify-content-between">

                        <div>

                            <h6 class="mb-1">
                                Startimes Nova
                            </h6>

                            <small class="text-muted">
                                29 May • 6:15 AM
                            </small>

                        </div>

                        <strong class="text-success">
                            ₦2,500
                        </strong>

                    </div>

                </div>

            </div>

        </div>

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



    <script>
        const cards = document.querySelectorAll('.provider-card');

        cards.forEach(card => {
            card.addEventListener('click', () => {
                const isSelected = card.classList.contains('clicked');

                cards.forEach(c=> c.classList.remove('clicked'));

                if (!isSelected){
                    card.classList.add('clicked');
                }
            });
        });
    </script>



</body>
</html>