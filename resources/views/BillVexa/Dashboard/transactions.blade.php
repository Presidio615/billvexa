<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
    {{ $setting->site_name ?? 'BillVexa' }} Transactions Dashboard
    </title>

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

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7fe;
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

            top:0;
            left:0;

            padding:25px 15px;

            z-index:1000;
        }

        .sidebar a{

            display:flex;
            align-items:center;
            gap:12px;

            text-decoration:none;

            color:white;

            padding:14px 16px;

            border-radius:14px;

            margin-bottom:10px;

            transition:.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active{

            background:rgba(255,255,255,.15);
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

        /* MAIN */
        .main-content{
            margin-left:260px;
            padding:30px;
        }

        /* TOPBAR */
        .topbar{

            background:white;

            border-radius:20px;

            padding:20px 25px;

            box-shadow:0 5px 20px rgba(0,0,0,.05);

            margin-bottom:30px;
        }

        /* CARD */
        .dashboard-card{

            background:white;

            border-radius:24px;

            padding:25px;

            box-shadow:0 5px 20px rgba(0,0,0,.05);
        }

        /* TABLE */
        .dashboard-card{
            background:#fff;
            border-radius:20px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,.06);
        }

        .table th{
            font-weight:600;
            white-space:nowrap;
        }

        .table td{
            vertical-align:middle;
        }

        .card{
            transition:.3s;
        }

        .card:hover{
            transform:translateY(-2px);
        }

        .badge{
            font-size:.75rem;
            padding:7px 12px;
            border-radius:30px;
        }

        @media (max-width:767px){

            .dashboard-card{
                padding:18px;
            }

            .card-body{
                padding:1rem;
            }

            h5{
                font-size:1.1rem;
            }

            .btn{
                font-size:.9rem;
            }
        }
        /* BADGES */
        .status{

            padding:8px 14px;

            border-radius:50px;

            font-size:13px;

            font-weight:600;
        }

        .success{
            background:#dcfce7;
            color:#166534;
        }

        .pending{
            background:#fef3c7;
            color:#92400e;
        }

        .failed{
            background:#fee2e2;
            color:#991b1b;
        }

        /* SEARCH */
        .search-box{

            background:#f8f9ff;

            border:none;

            border-radius:14px;

            padding:14px;
        }

        .search-box:focus{

            box-shadow:none;

            border:1px solid blueviolet;
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

            .stats-card h2{
                font-size:1.5rem;
            }
        }

svg{
    display:none;
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

        <a href={{ route('history') }} class="active">
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

        <a href={{ route('service') }}>
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>

        <a href={{ route('refer') }} >
            <i class="bi bi-people"></i>
            <small>Refer & Earn</small>
        </a>

        <a href={{ route('history') }} class="active">
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
                    Transactions
                </h4>

                <small class="text-muted">
                    Track all your transactions
                </small>

            </div>

        </div>

<!-- TRANSACTION HISTORY -->
<div class="dashboard-card">

    <!-- Header -->
    <div class="row align-items-center mb-4 g-3">

        <div class="col-lg-4">
            <h5 class="fw-bold mb-0">
                Transaction History
            </h5>
        </div>

        <div class="col-lg-8">

        <form method="GET" action="{{ route('history') }}" class="row g-2">

            <!-- Search -->
            <div class="col-12 col-lg">

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control rounded-4"
                    placeholder="Search reference, service, type or status">

            </div>

            <!-- From Date -->
            <div class="col-6 col-md-3">

                <input
                    type="date"
                    name="from_date"
                    value="{{ request('from_date') }}"
                    class="form-control rounded-4">

            </div>

            <!-- To Date -->
            <div class="col-6 col-md-3">

                <input
                    type="date"
                    name="to_date"
                    value="{{ request('to_date') }}"
                    class="form-control rounded-4">

            </div>

            <!-- Filter -->
            <div class="col-6 col-md-auto">

                <button class="btn btn-primary rounded-4 w-100">

                    <i class="bi bi-funnel"></i>
                    Filter

                </button>

            </div>

            <!-- Clear -->
            @if(request()->filled('search') || request()->filled('status') || request()->filled('from_date') || request()->filled('to_date'))

                <div class="col-6 col-md-auto">

                    <a href="{{ route('history') }}"
                    class="btn btn-secondary rounded-4 w-100">

                        Clear

                    </a>

                </div>

            @endif

            </form>

        </div>

    </div>


    <!-- ========================= -->
    <!-- Desktop Table -->
    <!-- ========================= -->

    <div class="table-responsive d-none d-md-block">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th>Reference</th>
                    <th>Service</th>
                    <th>Type</th>
                    <th>Recipient</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>

                </tr>

            </thead>

            <tbody>

                @forelse($transactions as $transaction)

                    @php
                        $status = strtolower($transaction->status);
                    @endphp

                    <tr>

                        <td>{{ $transaction->reference }}</td>

                        <td>{{ $transaction->service }}</td>

                        <td>

                            @if($transaction->type == 'credit')

                                <span class="badge bg-success">

                                    Credit

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Debit

                                </span>

                            @endif

                        </td>

                        <td>{{ $transaction->phone ?? '-' }}</td>

                        <td>

                            <strong>

                                ₦₦{{ number_format($transaction->total,2) }}

                            </strong>

                        </td>

                        <td>

                            @if($status == 'success' || $status == 'successful')

                                <span class="badge bg-success">

                                    Successful

                                </span>

                            @elseif($status == 'pending')

                                <span class="badge bg-warning text-dark">

                                    Pending

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Failed

                                </span>

                            @endif

                        </td>

                        <td>

                            {{ $transaction->created_at->format('d M Y') }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7" class="text-center py-5">

                            No transactions found.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    <!-- ========================= -->
    <!-- Mobile Cards -->
    <!-- ========================= -->

    <div class="d-md-none">

        @forelse($transactions as $transaction)

            @php
                $status = strtolower($transaction->status);
            @endphp

            <div class="card shadow-sm border-0 rounded-4 mb-3">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <div>

                            <h6 class="fw-bold mb-1">

                                {{ $transaction->service }}

                            </h6>

                            <small class="text-muted">

                                {{ $transaction->created_at->format('d M Y h:i A') }}

                            </small>

                        </div>

                        <div>

                            @if($status == 'success' || $status == 'successful')

                                <span class="badge bg-success">

                                    Successful

                                </span>

                            @elseif($status == 'pending')

                                <span class="badge bg-warning text-dark">

                                    Pending

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Failed

                                </span>

                            @endif

                        </div>

                    </div>

                    <div class="row g-3">

                        <div class="col-6">

                            <small class="text-muted d-block">

                                Amount

                            </small>

                            <strong>

                                ₦{{ number_format($transaction->amount,2) }}

                            </strong>

                        </div>

                        <div class="col-6">

                            <small class="text-muted d-block">

                                Type

                            </small>

                            @if($transaction->type == 'credit')

                                <span class="badge bg-success">

                                    Credit

                                </span>

                            @else

                                <span class="badge bg-danger">

                                    Debit

                                </span>

                            @endif

                        </div>

                        <div class="col-12">

                            <small class="text-muted d-block">

                                Recipient

                            </small>

                            {{ $transaction->phone ?? '-' }}

                        </div>

                        <div class="col-12">

                            <small class="text-muted d-block">

                                Reference

                            </small>

                            <small>

                                {{ $transaction->reference }}

                            </small>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="alert alert-info text-center">

                No transactions found.

            </div>

        @endforelse

    </div>

    <!-- Pagination -->

    <div class="mt-4">

        {{ $transactions->links() }}

    </div>

</div>

        </div>

    </div>

</body>
</html>