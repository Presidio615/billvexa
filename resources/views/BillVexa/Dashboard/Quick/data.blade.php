<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Data Bundle Dashboard
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
            #2563eb,
            #4f46e5
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

    /* MAIN CONTENT */
    .main-content{

        margin-left:260px;

        padding:30px;
    }

    /* TOPBAR */
    .topbar{

        background:white;

        border-radius:20px;

        padding:18px 25px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);

        margin-bottom:30px;
    }

    /* CUSTOM CARD */
    .custom-card{

        background:white;

        border-radius:22px;

        padding:25px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);
    }

    /* NETWORK CARD */
    .network-card{

        border:1px solid #e5e7eb;

        border-radius:18px;

        padding:18px;

        text-align:center;

        transition:.3s ease;

        cursor:pointer;
    }

    .network-card:hover{

        border-color: #2563eb;

        background: #eff6ff;

        transform:translateY(-5px);
    }

    .network-card.clicked{

        background-color: #eff6ff;

        border-color: #2563eb;

        transform:translateY(-5px);
    }

    /* PLAN CARD */
    .plan-card{

        border:1px solid #e5e7eb;

        border-radius:18px;

        padding:20px;

        transition:.3s ease;

        cursor:pointer;
    }

    .plan-card.clicked{
        background:#eff6ff;
        border-color:#2563eb;
        transform:translateY(-4px);
    }

    .plan-card:hover{

        border-color:#2563eb;

        background:#eff6ff;

        transform:translateY(-4px);
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

        border-color:#2563eb;
    }

    /* BUTTON */
    .buy-btn{

        background:linear-gradient(
            135deg,
            #2563eb,
            #4f46e5
        );

        border:none;

        border-radius:14px;

        padding:15px;

        color:white;

        font-weight:bold;

        transition:.3s ease;
    }

    .buy-btn:hover{

        transform:translateY(-3px);

        opacity:.95;
    }

    /* TRANSACTION */
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

        .data-card h1{
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
            color:#2563eb;
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

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">
                    Data Bundle
                </h4>

                <small class="text-muted">
                    Buy data bundles 
                </small>

            </div>

        </div>

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <!-- BUY DATA -->
                <div class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Buy Data Bundle
                    </h4>

                    <form action="{{ route('data.purchase') }}" method="POST">
                        @csrf

                        <!-- NETWORK -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select Network
                            </label>

                            <div class="row g-3">

                                <div class="col-md-3 col-6">
                                    <label class="network-card w-100">

                                        <input
                                            type="radio"
                                            name="network"
                                            value="MTN"
                                            hidden>

                                            <input type="hidden" name="amount" id="amount">
                                            
                                        <i class="fa-solid fa-signal fs-2 text-warning mb-2"></i>

                                        <h6 class="fw-bold">
                                            MTN
                                        </h6>

                                    </label>

                                </div>

                                <div class="col-md-3 col-6">

                                    <label class="network-card w-100">

                                        <input
                                            type="radio"
                                            name="network"
                                            value="glo"
                                            hidden>

                                            <input type="hidden" name="amount" id="amount">

                                        <i class="fa-solid fa-signal fs-2 text-success mb-2"></i>

                                        <h6 class="fw-bold">
                                            Glo
                                        </h6>

                                    </label>

                                </div>

                                <div class="col-md-3 col-6">

                                    <label class="network-card w-100">

                                        <input
                                            type="radio"
                                            name="network"
                                            value="airtel"
                                            hidden>

                                            <input type="hidden" name="amount" id="amount">

                                        <i class="fa-solid fa-signal fs-2 text-danger mb-2"></i>

                                        <h6 class="fw-bold">
                                            Airtel
                                        </h6>

                                    </label>

                                </div>

                                <div class="col-md-3 col-6">

                                    <label class="network-card w-100">

                                        <input
                                            type="radio"
                                            name="network"
                                            value="9mobile"
                                            hidden>

                                            <input type="hidden" name="amount" id="amount">

                                        <i class="fa-solid fa-signal fs-2 text-primary mb-2"></i>

                                        <h6 class="fw-bold">
                                            9mobile
                                        </h6>

                                    </label>

                                </div>

                            </div>

                        </div>

                        <!-- PHONE -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Phone Number
                            </label>

                            <input
                            type="tel"
                            name="phone"
                            class="form-control"
                            placeholder="Enter phone number"
                            required>

                        </div>

                        <!-- PLAN -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select Data Plan
                            </label>

                            <div class="row g-3">

                                <div class="col-md-4">

                                    <label class="plan-card d-block" data-amount="350">

                                        <input
                                            type="radio"
                                            name="plan"
                                            value="1GB Daily"
                                            hidden>

                                        <h6>1GB Daily</h6>

                                        <small>Valid for 1 day</small>

                                        <h5 class="text-primary mt-3">
                                            ₦350
                                        </h5>

                                    </label>
                                </div>

                                <div class="col-md-4">

                                    <label class="plan-card d-block" data-amount="1500">

                                        <input
                                            type="radio"
                                            name="plan"
                                            value="5GB Weekly"
                                            hidden>

                                        <h6>5GB Weekly</h6>

                                        <small>Valid for 7 days</small>

                                        <h5 class="text-primary mt-3">
                                            ₦1,500
                                        </h5>

                                    </label>

                                </div>

                                <div class="col-md-4">

                                    <label class="plan-card d-block" data-amount="4500">

                                        <input
                                            type="radio"
                                            name="plan"
                                            value="15GB Monthly"
                                            hidden>

                                        <h6>15GB Monthly</h6>

                                        <small>Valid for 30 days</small>

                                        <h5 class="text-primary mt-3">
                                            ₦4,500
                                        </h5>

                                    </label>

                                </div>

                            </div>

                        </div>

                        <!-- BUTTON -->
                        <button type="submit" class="buy-btn w-100">

                            <i class="fa-solid fa-wifi me-2"></i>

                            Buy Data Bundle

                        </button>

                    </form>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <!-- INFO -->
                <div class="custom-card mb-4">

                    <h5 class="fw-bold mb-4">
                        Data Info
                    </h5>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Minimum Purchase
                        </span>

                        <strong>
                            ₦100
                        </strong>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Delivery Time
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
                            Recent Purchases
                        </h5>

                        <a href={{ route('history') }}
                        class="text-decoration-none">
                            View all
                        </a>

                    </div>

                    @forelse($transactions as $transaction)

                        <div class="transaction-item d-flex justify-content-between">

                            <div>

                                <h6 class="mb-1">
                                    {{ $transaction->network }}
                                    {{ $transaction->type }}
                                </h6>

                                <small class="text-muted">
                                    {{ $transaction->created_at->diffForHumans() }}
                                </small>

                            </div>

                            <strong class="text-success">
                                ₦{{ number_format($transaction->amount,2) }}
                            </strong>

                        </div>

                        @empty

                        <p class="text-muted text-center">
                            No purchases yet.
                        </p>

                    @endforelse

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
        const networkCards = document.querySelectorAll(".network-card");

        networkCards.forEach(card => {
            card.addEventListener("click", function () {

                const radio = this.querySelector('input[type="radio"]');

                // If already selected, unselect it
                if (this.classList.contains("clicked")) {
                    this.classList.remove("clicked");
                    radio.checked = false;
                    return;
                }

                // Remove active from all cards
                networkCards.forEach(c => {
                    c.classList.remove("clicked");
                    c.querySelector('input[type="radio"]').checked = false;
                });

                // Activate current card
                this.classList.add("clicked");
                radio.checked = true;
            });
        });



        const planCards = document.querySelectorAll(".plan-card");

        planCards.forEach(card => {

            card.addEventListener("click", function () {

                const radio = this.querySelector('input[type="radio"]');

                if (this.classList.contains("clicked")) {

                    this.classList.remove("clicked");
                    radio.checked = false;
                    document.getElementById("amount").value = "";
                    return;

                }

                planCards.forEach(c => {
                    c.classList.remove("clicked");
                    c.querySelector('input[type="radio"]').checked = false;
                });

                this.classList.add("clicked");
                radio.checked = true;

                document.getElementById("amount").value = this.dataset.amount;

            });

        });
    </script>


</body>
</html>