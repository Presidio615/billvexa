<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>{{ $setting->site_name ?? 'BillVexa' }} Betting Dashboard</title>

<!-- icon image -->
<link rel="shortcut icon" 
href="../../../Assets/Image/icon.png" type="image/x-icon">

<!-- Bootstrap -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- Fontawsome icon -->
<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Bootstrap icon -->
<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<style>

    body{
        background:#f4f7ff;
        font-family:Arial, Helvetica, sans-serif;
        overflow-x:hidden;
    }

    /* SIDEBAR */
    .sidebar{
        width:260px;
        min-height:100vh;
        position:fixed;
        top:0;
        left:0;
        background:linear-gradient(180deg,#5b21b6,#2563eb);
        padding:25px 15px;
        z-index:1000;
    }

    .sidebar a{
        display:flex;
        align-items:center;
        gap:12px;
        color:#fff;
        text-decoration:none;
        padding:14px 16px;
        border-radius:12px;
        margin-bottom:10px;
        transition:.3s;
    }

    .sidebar a:hover,
    .sidebar a.active{
        background:rgba(255,255,255,.15);
    }

    .main-content{
        margin-left:260px;
        padding:25px;
    }

    /* TOPBAR */
    .topbar{
        background:#fff;
        padding:18px 25px;
        border-radius:20px;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
        margin-bottom:30px;
    }

    /* CUSTOM CARD */
    .custom-card{
        background:#fff;
        padding:25px;
        border-radius:20px;
        box-shadow:0 10px 30px rgba(0,0,0,.05);
    }

    /* TRANSACTION ITEM */
    .transaction-item{
        padding:15px 0;
        border-bottom:1px solid #eee;
    }

    .transaction-item:last-child{
        border-bottom:none;
    }

    /* MOBILE NAV */
    .mobile-nav{
        position:fixed;
        bottom:0;
        left:0;
        width:100%;
        background:#fff;
        box-shadow:0 -5px 20px rgba(0,0,0,.08);
        z-index:2000;
        padding:10px 0;
    }

    .mobile-nav a{
        text-decoration:none;
        color:#777;
        display:flex;
        flex-direction:column;
        align-items:center;
        font-size:12px;
    }

    .mobile-nav a.active{
        color:#5b21b6;
    }

    .mobile-nav i{
        font-size:20px;
    }

    @media(max-width:991px){

        body{
            padding-bottom:80px;
        }

        .main-content{
            margin-left:0;
            padding:20px;
        }
    }
    
    /* PLATFORM CARD */
    .platform-card{
        background:#fff;
        border:1px solid #e9ecef;
        border-radius:18px;
        padding:20px 15px;
        text-align:center;
        cursor:pointer;
        transition:all .3s ease;
        height:100%;
    }

    .platform-card:hover{
        transform:translateY(-5px);
        border-color:#5b21b6;
        box-shadow:0 10px 25px rgba(91,33,182,.15);
    }

    .platform-card i{
        display:block;
        font-size:30px;
        color:#5b21b6;
        margin-bottom:10px;
    }

    .platform-card span{
        font-weight:600;
        font-size:14px;
        color:#333;
    }

    @media(max-width:576px){

        .platform-card{
            padding:15px 10px;
        }

        .platform-card i{
            font-size:24px;
        }

        .platform-card span{
            font-size:13px;
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
                <h4 class="fw-bold mb-1">Betting</h4>
                <small class="text-muted">
                    Pay for betting
                </small>
            </div>

        </div>

        <!-- FORM + PLATFORMS -->
        <div class="row g-4">

            <div class="col-lg-8">

                <div class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Fund Betting Account
                    </h4>

                    <!-- Form Here -->
                    <form>

                        <div class="mb-3">
                            <label class="form-label">
                                Betting Platform
                            </label>

                            <select class="form-select py-3">
                                <option>SportyBet</option>
                                <option>Bet9ja</option>
                                <option>BetKing</option>
                                <option>1xBet</option>
                                <option>BangBet</option>
                                <option>NairaBet</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                User ID / Username
                            </label>

                            <input type="text"
                                class="form-control py-3"
                                placeholder="Enter Username">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Amount
                            </label>

                            <div class="input-group">
                                <span class="input-group-text">₦</span>

                                <input type="number"
                                    class="form-control py-3"
                                    placeholder="Enter Amount">
                            </div>
                        </div>

                        <button class="btn btn-primary w-100 py-3">
                            Fund Account
                        </button>

                    </form>

                </div>

            </div>
            
            <!-- Supported Platform -->
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 p-4">

                    <h5 class="fw-bold mb-4">
                        <i class="fa-solid fa-futbol text-primary me-2"></i>
                        Supported Platforms
                    </h5>

                    <div class="row g-3">

                        <div class="col-6 col-md-4">
                            <div class="platform-card">
                                <i class="fa-solid fa-trophy"></i>
                                <span>SportyBet</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="platform-card">
                                <i class="fa-solid fa-medal"></i>
                                <span>Bet9ja</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="platform-card">
                                <i class="fa-solid fa-crown"></i>
                                <span>BetKing</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="platform-card">
                                <i class="fa-solid fa-dice"></i>
                                <span>1xBet</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="platform-card">
                                <i class="fa-solid fa-star"></i>
                                <span>BangBet</span>
                            </div>
                        </div>

                        <div class="col-6 col-md-4">
                            <div class="platform-card">
                                <i class="fa-solid fa-wallet"></i>
                                <span>NairaBet</span>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>

        <!-- RECENT FUNDING -->
        <div class="custom-card mt-4">

            <h5 class="fw-bold mb-4">
                Recent Funding
            </h5>

            <div class="transaction-item d-flex justify-content-between">
                <div>
                    <h6>SportyBet</h6>
                    <small>Today • 09:15 AM</small>
                </div>
                <strong class="text-success">₦5,000</strong>
            </div>

            <div class="transaction-item d-flex justify-content-between">
                <div>
                    <h6>Bet9ja</h6>
                    <small>Yesterday • 04:10 PM</small>
                </div>
                <strong class="text-success">₦10,000</strong>
            </div>

        </div>

        <!-- Betting Transaction TABLE -->
        <div class="custom-card mt-4">

                <div class="d-flex justify-content-between mb-4">

                    <h5 class="fw-bold">
                        Recent Subscriptions
                    </h5>

                    <a href={{ route('history') }}
                    class="text-decoration-none">
                        View all
                    </a>

                </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Company</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td>#BT1001</td>
                            <td>SportyBet</td>
                            <td>presidio123</td>
                            <td>₦5,000</td>
                            <td>
                                <span class="badge bg-success">
                                    Successful
                                </span>
                            </td>
                            <td>02 Jun 2026</td>
                        </tr>

                        <tr>
                            <td>#BT1002</td>
                            <td>BetKing</td>
                            <td>mentor45</td>
                            <td>₦2,500</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    Pending
                                </span>
                            </td>
                            <td>01 Jun 2026</td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <script src="../../../Assets/libs/js/bootstrap.bundle.min.js"></script>

</body>
</html>