<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>{{ $setting->site_name ?? 'BillVexa' }} Dashboard</title>

    <!-- icon image -->
    <link rel="shortcut icon" href="../../Assets/Image/icon.png" type="image/x-icon">

    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>

        body{
            background:#f4f7ff;
            overflow-x:hidden;
            font-family: Arial, Helvetica, sans-serif;
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
        .logout{
            display:flex;
            /* align-items:center; */
            /* gap:10px; */

            color:white;
            text-decoration:none;

            padding:14px 16px;
            border-radius:12px;

            top:auto;
            bottom:0;

            transition:.3s ease;
            
        }
        .logout:hover{
            background:rgba(255,255,255,.15);

            transform:translateX(5px);
        }

        .sidebar a:hover,
        .sidebar a.active{

            background:rgba(255,255,255,.15);

            transform:translateX(5px);
        }

        .notification-message{
            white-space: normal;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.5;
        }

        /* MAIN CONTENT */
        .main-content{

            margin-left:260px;
            padding:25px;
        }

        /* TOPBAR */
        .topbar{

            border-radius: 20px;

            padding:18px 25px;

            border-radius:20px;

            box-shadow:0 10px 30px rgba(0,0,0,.05);

            margin-bottom:30px;
        }

        /* WALLET CARD */
        .wallet-card{

            background:linear-gradient(
                135deg,
                #5b21b6,
                #2563eb
            );

            border-radius:30px;

            padding:35px;

            color:white;

            position:relative;

            overflow:hidden;

            box-shadow:0 15px 40px rgba(0,0,0,.12);
        }

        .wallet-card::before{

            content:"";

            position:absolute;

            width:250px;
            height:250px;

            background:rgba(255,255,255,.08);

            border-radius:50%;

            top:-100px;
            right:-80px;
        }

        .wallet-card::after{

            content:"";

            position:absolute;

            width:180px;
            height:180px;

            background:rgba(255,255,255,.08);

            border-radius:50%;

            bottom:-80px;
            left:-50px;
        }

        .wallet-card > *{
            position:relative;
            z-index:2;
        }

        .wallet-balance{

            font-size:42px;
            font-weight:bold;
        }

        .wallet-btn{

            border:none;

            padding:12px 25px;

            border-radius:50px;

            font-weight:600;

            transition:.3s ease;
        }

        .wallet-btn:hover{
            transform:translateY(-3px);
        }

        /* TRANSACTION TABLE */
        .table-card{

            background:white;
            border-radius:20px;

            padding:20px;

            box-shadow:0 10px 30px rgba(0,0,0,.05);
        }

        .badge-success{
            background:#dcfce7;
            color:#166534;
            padding:8px 12px;
            border-radius:50px;
        }

        .badge-pending{
            background:#fef3c7;
            color:#92400e;
            padding:8px 12px;
            border-radius:50px;
        }

        /* Quick services */
        .card{
            transition:.3s ease;
        }

        .card:hover{
            transform:translateY(-5px);
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

        .modal-content{
            border-radius:20px;
        }

        .account-box{
            background:#f8fafc;
            border:1px solid #dee2e6;
            border-radius:20px;
            padding:20px;
        }

        .account-box h4,
        .account-box h5{
            margin-bottom:0;
        }

        .modal-content{
            border-radius:20px;
        }

        .modal-header{
            border-bottom:none;
        }

        .modal-footer{
            border-top:none;
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
            .sidebar{
                width:100%;
                min-height:auto;
                position:relative;
            }
            /* MODAL */
            .account-box{
                background:#f8f9fa;
                border:1px solid #e9ecef;
            }

            .modal-content{
                border-radius:20px;
            }

            .modal-dialog{
                margin:10px;
            }

            .modal-content{
                border-radius:15px;
            }

            .modal-body{
                padding:15px;
            }

            .modal-title{
                font-size:18px;
            }

            .form-control,
            .form-select{
                font-size:15px;
            }

            #accountName{
                font-size:14px;
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

        <!-- <div class="logo mb-5 text-white fs-2 fw-bold">
            {{ $setting->site_name ?? 'BillVexa' }}
        </div> -->

        <a href="{{ route('dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a href="{{ route('service') }}" >
            <i class="bi bi-gear"></i>
            Services
        </a>

        <a href="{{ route('refer') }}" >
            <i class="bi bi-people"></i>
            Refer & Earn
        </a>

        <a href="{{ route('history') }}" >
            <i class="bi bi-clock-history"></i>
            Transactions
        </a>

        <a href="{{ route('profile.edit') }}" >
            <i class="bi bi-person-lines-fill"></i>
            Profile
        </a>

    </div>


    <!-- MOBILE BOTTOM NAV -->
    <div class="mobile-nav d-flex d-lg-none justify-content-around align-items-center">

        <a href="{{ route('dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>

        <a href="{{ route('service') }}" >
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>

        <a href="{{ route('refer') }}" >
            <i class="bi bi-people"></i>
            <small>Refer & Earn</small>
        </a>

        <a href="{{ route('history') }}" >
            <i class="bi bi-clock-history"></i>
            <small>History</small>
        </a>

        <a href="{{ route('profile.edit') }}" >
            <i class="bi bi-person-lines-fill"></i>
            <small>Profile</small>
        </a>

    </div>

    <!-- MAIN -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center bg-white">

            <div>
                <h3 class="fw-bold mb-0">
                    <span id="greeting"></span>, {{ Auth::user()->name }}
                </h3>
                <p>Email: {{ Auth::user()->email }}</p>

                <small class="text-muted">
                    Manage your bills easily with {{ $setting->site_name ?? 'BillVexa' }}
                </small>
            </div>

            <div class="d-flex align-items-center gap-3">

               <a href="{{ route('notification') }}" class="btn btn-light position-relative" >
                    <i class="fa-solid fa-bell"></i>
                    @if ($unreadNotifications > 0) 
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unreadNotifications }}
                        </span>
                    
                    @endif
               </a>
               @php
                    $nameParts = preg_split('/\s+/', trim(auth()->user()->name));
                    $initials = '';

                    foreach (array_slice($nameParts, 0, 2) as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                    }
                @endphp

                @if(auth()->user()->profile_photo)

                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                        alt="{{ auth()->user()->name }}"
                        class="rounded-circle border border-2 border-primary"
                        width="45"
                        height="45"
                        style="object-fit:cover;"
                    >

                @else

                    <div
                        class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center"
                        style="width:45px; height:45px;"
                    >
                        {{ $initials }}
                    </div>

                @endif
                

            </div>

        </div>

        <div class="wallet-card mb-4 px-4">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                <!-- LEFT SIDE -->
                <div class="mb-3 mb-md-0">

                    <small class="text-light d-block">
                        Total Wallet Balance
                    </small>
                    <h1 class="wallet-balance mt-2 mb-0 d-flex align-items-center gap-3">

                        ₦<span id="walletAmount">
                            {{ number_format(auth()->user()->wallet_balance, 2) }}
                        </span>
                        

                       
                        <!-- DEFAULT: HIDDEN -->
                        <i id="toggleWallet"
                        class="bi bi-eye-slash-fill text-light"
                        style="cursor:pointer; font-size:20px;">
                        </i>

                    </h1>

                </div>

                <!-- RIGHT SIDE -->
                <div class="text-md-end text-start">

                <a href="{{ route('history') }}" class="nav-link lead mb-2">
                        Transaction History
                    </a>
                    <button class="wallet-btn btn-light"
                        data-bs-toggle="modal"
                        data-bs-target="#addMoneyModal">
                        <i class="bi bi-plus-circle me-2"></i>
                        Add Money
                    </button>
                    

                </div>

            </div>

        </div>

        <!-- QUICK ACTIONS -->
        <div class="mt-4 g-4 ">

            <div class="col-lg-12 mb-4">

                <div class="table-card">

                    <div class="d-flex justify-content-between mb-4">

                        <h5 class="fw-bold">
                            Recent Transactions
                        </h5>

                        <button class="btn btn-primary rounded-pill">
                            <a href={{ route('history') }} class="nav-link">View All</a>
                        </button>

                    </div>

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>
                                <tr>
                                    <th>Service</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($transactions ?? [] as $transaction)

                                <tr>

                                    <td>{{ $transaction->service }}</td>

                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>

                                    <td>₦{{ number_format($transaction->amount,2) }}</td>

                                    <td>

                                        @php
                                            $status = strtolower($transaction->status);
                                        @endphp

                                        <span class="badge
                                            @if($status === 'success' || $status === 'successful')
                                                bg-success
                                            @elseif($status === 'pending')
                                                bg-warning text-dark
                                            @else
                                                bg-danger
                                            @endif
                                        ">
                                            @if(in_array($status, ['success', 'successful']))
                                                Successful
                                            @else
                                                {{ ucfirst($transaction->status) }}
                                            @endif
                                        </span>
                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="4" class="text-center">
                                    No transactions yet.
                                    </td>

                                </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <!-- QUICK SERVICES -->
            <div class="col-lg-12 ">

                <div class="table-card">

                    <div class="d-flex justify-content-between">
                        <h5 class="fw-bold mb-4">
                            Quick Services
                        </h5>
                        <a href={{ route('service') }} class="nav-link text-primary">
                            See more...
                        </a>
                    </div>

                    <div class="row g-4">

                        <!-- Airtime -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href={{ route('airtime') }}
                            class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 text-center p-4">

                                    <i class="fas fa-phone-alt text-primary fs-1 mb-3"></i>

                                    <h6 class="fw-bold">
                                        Airtime
                                    </h6>

                                    <small class="text-muted">
                                        Buy Airtime
                                    </small>

                                </div>

                            </a>
                        </div>

                        <!-- Data -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href={{ route('data') }}
                            class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 text-center p-4">

                                    <i class="fas fa-wifi text-success fs-1 mb-3"></i>

                                    <h6 class="fw-bold">
                                        Data
                                    </h6>

                                    <small class="text-muted">
                                        Buy Data Bundle
                                    </small>

                                </div>

                            </a>
                        </div>

                        <!-- Electricity -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href={{ route('electricity') }}
                            class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 text-center p-4">

                                    <i class="fas fa-bolt text-warning fs-1 mb-3"></i>

                                    <h6 class="fw-bold">
                                        Electricity
                                    </h6>

                                    <small class="text-muted">
                                        Pay Bills
                                    </small>

                                </div>

                            </a>
                        </div>

                        <!-- Cable TV -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href={{ route('cable.tv') }}
                            class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 text-center p-4">

                                    <i class="fas fa-tv text-danger fs-1 mb-3"></i>

                                    <h6 class="fw-bold">
                                        Cable TV
                                    </h6>

                                    <small class="text-muted">
                                        Subscribe TV
                                    </small>

                                </div>

                            </a>
                        </div>

                        <!-- Betting -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href={{ route('bet') }}
                            class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 text-center p-4">

                                    <i class="fas fa-futbol text-info fs-1 mb-3"></i>

                                    <h6 class="fw-bold">
                                        Betting
                                    </h6>

                                    <small class="text-muted">
                                        Fund Betting
                                    </small>

                                </div>

                            </a>
                        </div>

                        <!-- Education -->
                        <div class="col-6 col-md-4 col-lg-3">
                            <a href="{{ Route('education') }}"
                            class="text-decoration-none">

                                <div class="card border-0 shadow-sm h-100 text-center p-4">

                                    <i class="fas fa-graduation-cap text-primary fs-1 mb-3"></i>

                                    <h6 class="fw-bold">
                                        Education
                                    </h6>

                                    <small class="text-muted">
                                        Pay School Fees
                                    </small>

                                </div>

                            </a>
                        </div>



                    </div>    
                </div>

            </div>
        </div>

    </div>

    <!-- ADD MONEY MODAL -->
    
    <div class="modal fade" id="addMoneyModal" tabindex="-1" aria-labelledby="addMoneyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header">
                    <h5 class="modal-title" id="addMoneyModalLabel">
                        <i class="bi bi-wallet2 me-2"></i>
                        Fund Wallet
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close">
                    </button>
                </div>

                <div class="modal-body">

   

                    <div class="account-box">

                        <div class="mb-3">
                            <small class="text-muted">Bank Name</small>

                            <h5 class="fw-bold text-primary">
                            {{ auth()->user()->account_bank ?? 'Not Assigned' }}
                            </h5>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted d-block mb-2">
                                Account Number
                            </small>

                            @if(auth()->user()->account_number)

                                <div class="d-flex align-items-center justify-content-between
                                            bg-white border rounded-3 p-3">

                                    <div>
                                        <div
                                            id="accountNumber"
                                            class="fw-bold text-dark"
                                            style="font-size: 20px; letter-spacing: 1px;"
                                        >
                                            {{ auth()->user()->account_number }}
                                        </div>

                                        <small class="text-muted">
                                            Use this account number to fund your wallet
                                        </small>
                                    </div>

                                    <button
                                        type="button"
                                        class="btn btn-outline-primary btn-sm"
                                        onclick="copyAccount()"
                                        title="Copy account number"
                                    >
                                        <i class="bi bi-copy"></i>
                                        Copy
                                    </button>

                                </div>

                            @else

                                <div class="alert alert-warning mb-0">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Your virtual account has not been assigned yet.
                                </div>

                            @endif
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">
                                Account Name
                            </small>

                            <h5 class="fw-bold mb-0">
                                {{ strtoupper(auth()->user()->name) }}
                            </h5>
                        </div>

                        <div class="alert alert-info mt-3 mb-0">

                            <h6 class="fw-bold mb-2">
                                Deposit Information
                            </h6>

                            <p class="mb-1">
                                Minimum Deposit:
                                <strong>
                                    {{ $setting->currency }}{{ number_format($setting->minimum_deposit,2) }}
                                </strong>
                            </p> <hr>
                            <i class="bi bi-info-circle-fill me-2"></i>
                            Transfer money to the account above. Your wallet will be credited automatically after payment confirmation.
                        </div>

                    </div>
                    

                </div>

                <div class="modal-footer">
                    <button
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
   



    <script>

        // GREETINGS 
        function updateGreeting(){
            const hour = new Date().getHours();
            let greeting;

            if(hour < 12){ 
                //from 12pm down
                        greeting = "Good Morning";
            } else if(hour < 16){ 
                //from 4pm up
                greeting = "Good Afternoon";
            } else{
                greeting = "Good Evening";
            }

            document.getElementById("greeting").innerHTML = greeting; 
        }

        updateGreeting();

        // TO COPY ACCOUNT NUMBER
        function copyAccount() {
            const account = document
                .getElementById('accountNumber')
                .innerText
                .trim();

            navigator.clipboard.writeText(account)
                .then(() => {
                    alert('Account Number Copied Successfully!');
                })
                .catch(() => {
                    alert('Unable to copy account number.');
                });
        }

        // ===============================
        // WALLET BALANCE TOGGLE
        // ===============================

        const walletAmount = document.getElementById("walletAmount");
        const toggleWallet = document.getElementById("toggleWallet");

        const realWalletValue = "{{ number_format(auth()->user()->wallet_balance, 2) }}";

        // Hide balance by default
        let walletHidden = true;

        // Set the initial hidden state
        walletAmount.textContent = "******";

        toggleWallet.classList.remove("bi-eye-fill");
        toggleWallet.classList.add("bi-eye-slash-fill");

        toggleWallet.addEventListener("click", () => {

            walletHidden = !walletHidden;

            if (walletHidden) {

                // Hide balance
                walletAmount.textContent = "******";

                toggleWallet.classList.remove("bi-eye-fill");
                toggleWallet.classList.add("bi-eye-slash-fill");

            } else {

                // Show balance
                walletAmount.textContent = realWalletValue;

                toggleWallet.classList.remove("bi-eye-slash-fill");
                toggleWallet.classList.add("bi-eye-fill");

            }

        });

        document.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('notificationDropdown');

            const dropdown = new bootstrap.Dropdown(trigger);

            trigger.addEventListener('click', function (e) {
                e.preventDefault();
                dropdown.toggle();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        

</body>
</html>