<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $setting->site_name ?? 'BillVexa' }} - @yield('title')</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
            background:#f5f7fb;
        }

        .sidebar-desktop{
            width:260px;
            height:100vh;
            background:#111827;
            position:fixed;
            left:0;
            top:0;
            overflow-y:auto;
            overflow-x:hidden;
            scrollbar-width:thin;
            scrollbar-color:#4f46e5 #111827;
        }

        /* Chrome, Edge & Safari */
        .sidebar-desktop::-webkit-scrollbar{
            width:8px;
        }

        .sidebar-desktop::-webkit-scrollbar-track{
            background:#111827;
        }

        .sidebar-desktop::-webkit-scrollbar-thumb{
            background:#4f46e5;
            border-radius:10px;
        }

        .sidebar-desktop::-webkit-scrollbar-thumb:hover{
            background:#6366f1;
        }
        .sidebar-desktop .nav-link,
        .offcanvas .nav-link{
            color:#fff;
            border-radius:.5rem;
        }

        .sidebar-desktop .nav-link:hover,
        .sidebar-desktop .nav-link.active,
        .offcanvas .nav-link:hover,
        .offcanvas .nav-link.active{
            background:#4f46e5;
        }

        .main{
            margin-left:260px;
        }

        .notification-message{
    white-space: normal;
    word-wrap: break-word;
    overflow-wrap: break-word;
    line-height: 1.5;
}

        .input-group-text{
            background:#f8f9fa;
        }

        .form-control{
            box-shadow:none !important;
        }

        .form-control:focus{
            border-color:#4f46e5;
        }

        .dropdown-menu{
            min-width:280px;
        }

        .navbar{
            border-radius:18px;
        }

        @media(max-width:991.98px){

            .main{
                margin-left:0;
            }

            .sidebar-desktop{
                display:none;
            }

        }

        .card{
            border:0;
            border-radius:1rem;
            box-shadow:0 .25rem 1rem rgba(0,0,0,.08);
        }

        .offcanvas-body{
            overflow-y:auto;
        }

        .offcanvas-body::-webkit-scrollbar{
            width:8px;
        }

        .offcanvas-body::-webkit-scrollbar-thumb{
            background:#4f46e5;
            border-radius:10px;
        }
    </style>

    @stack('styles')

</head>

<body>

    <!-- Desktop Sidebar -->

    <div class="sidebar-desktop d-none d-lg-flex flex-column p-3 text-white">

        <h4 class="mb-4 d-flex align-items-center">

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

        <ul class="nav nav-pills flex-column gap-2">

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-house me-2"></i>
                    Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.user') ? 'active' : '' }}"
                   href="{{ route('admin.user') }}">
                    <i class="bi bi-people me-2"></i>
                    Users
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.transaction') ? 'active' : '' }}"
                   href="{{ route('admin.transaction') }}">
                    <i class="bi bi-arrow-left-right me-2"></i>
                    Transactions
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.service') ? 'active' : '' }}"
                   href="{{ route('admin.service') }}">
                    <i class="bi bi-receipt me-2"></i>
                    Services
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.referrals.index') ? 'active' : '' }}"
                   href="{{ route('admin.referrals.index') }}">
                    <i class="bi bi-person-badge me-2"></i>
                    Referrals
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.kyc') ? 'active' : '' }}"
                   href="{{ route('admin.kyc') }}">
                    <i class="bi bi-shield-check me-2"></i>
                    KYC
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.deposit') ? 'active' : '' }}"
                   href="{{ route('admin.deposit') }}">
                    <i class="bi bi-cash-stack me-2"></i>
                    Deposits
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.report') ? 'active' : '' }}"
                   href="{{ route('admin.report') }}">
                    <i class="bi bi-graph-up-arrow me-2"></i>
                    Report
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.setting') ? 'active' : '' }}"
                   href="{{ route('admin.setting') }}">
                    <i class="bi bi-gear me-2"></i>
                    Settings
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.notification') ? 'active' : '' }}"
                   href="{{ route('admin.notification') }}">
                    <i class="bi bi-bell me-2"></i>
                    Notification
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.audit-logs.index') ? 'active' : '' }}"
                   href="{{ route('admin.audit-logs.index') }}">
                    <i class="bi bi-shield-check me-2"></i>
                    Logs
                </a>
            </li>

        </ul>

    </div>

    <!-- Mobile Sidebar -->

    <div class="offcanvas offcanvas-start bg-dark text-white"
         tabindex="-1"
         id="sidebarMenu">

        <div class="offcanvas-header">

            <h5>{{ $setting->site_name }}</h5>

            <button class="btn-close btn-close-white"
                    data-bs-dismiss="offcanvas"></button>

        </div>

        <div class="offcanvas-body">

            <ul class="nav nav-pills flex-column gap-2">

                <li><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li><a class="nav-link" href="{{ route('admin.user') }}">Users</a></li>
                <li><a class="nav-link" href="{{ route('admin.transaction') }}">Transactions</a></li>
                <li><a class="nav-link" href="{{ route('admin.service') }}">Services</a></li>
                <li><a class="nav-link" href="{{ route('admin.referrals.index') }}">Referrals</a></li>
                <li><a class="nav-link" href="{{ route('admin.kyc') }}">KYC</a></li>
                <li><a class="nav-link" href="{{ route('admin.deposit') }}">Deposits</a></li>
                <li><a class="nav-link" href="{{ route('admin.report') }}">Report</a></li>
                <li><a class="nav-link" href="{{ route('admin.setting') }}">Settings</a></li>
                <li><a class="nav-link" href="{{ route('admin.notification') }}">Notification</a></li>
                <li><a class="nav-link" href="{{ route('admin.audit-logs.index') }}">Logs</a></li>

            </ul>

        </div>

    </div>

    <!-- Main Content -->

    <div class="main p-3">

        <nav class="navbar navbar-expand-lg bg-white rounded-4 shadow-sm px-4 py-3 mb-4">

            <div class="d-flex align-items-center">

                <button class="btn d-lg-none me-3"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#sidebarMenu">

                    <i class="bi bi-list fs-2"></i>

                </button>

                <div class="pb-3">

                    <h4 class="fw-bold mb-0">
                        @yield('page-title')
                    </h4>

                    <small class="text-muted">
                        Welcome back,
                        {{ $admin->name }} <br>
                        Current Time:
                        {{ now()->format('d M Y h:i:s A') }}

                        <br>

                        Timezone:
                        {{ config('app.timezone') }}
                    </small>

                </div>

            </div>

            <div class="d-flex align-items-center ms-auto">

                <!-- Search -->

                <div class="d-none d-lg-block me-3">

                    <form action="{{ route('admin.search') }}" method="GET">

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-search"></i>

                            </span>

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Search users or transactions..."
                                value="{{ request('search') }}">

                        </div>

                    </form>

                </div>

                <a href="{{ route('admin.notification.read-all') }}"
                class="btn btn-light position-relative rounded-pill mx-3">

                    <i class="bi bi-bell fs-5"></i>

                    @if($notificationCount > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $notificationCount }}
                        </span>
                    @endif

                </a>
                <!-- Settings -->

                <a href="{{ route('admin.setting') }}"
                    class="btn btn-light rounded-circle">

                    <i class="bi bi-gear"></i>

                </a>
                <!-- Admin Dropdown -->
                <div class="dropdown ms-3">

                    <a href="#"
                    class="d-flex align-items-center text-decoration-none dropdown-toggle"
                    id="adminDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                        @if($admin->profile_photo)

                            <img
                                src="{{ asset('storage/'.$admin->profile_photo) }}"
                                width="48"
                                height="48"
                                class="rounded-circle border border-2 border-primary">

                        @else

                            <img
                                src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=4f46e5&color=fff"
                                width="48"
                                height="48"
                                class="rounded-circle border border-2 border-primary">

                        @endif

                        <div class="ms-3 d-none d-md-block">

                            <h6 class="mb-0 fw-bold text-dark">
                                {{ $admin->name }}
                            </h6>

                            <small class="text-muted">
                                {{ $admin->email }}
                            </small>

                        </div>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-4 mt-3"
                        aria-labelledby="adminDropdown">

                        <li class="text-center p-3">

                            @if($admin->profile_photo)

                                <img
                                    src="{{ asset('storage/'.$admin->profile_photo) }}"
                                    width="70"
                                    height="70"
                                    class="rounded-circle border border-2 border-primary mb-2">

                            @else

                                <img
                                    src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=4f46e5&color=fff&size=128"
                                    width="70"
                                    height="70"
                                    class="rounded-circle border border-2 border-primary mb-2">

                            @endif

                            <h6 class="fw-bold mb-1">
                                {{ $admin->name }}
                            </h6>

                            <small class="text-muted">
                                {{ $admin->email }}
                            </small>

                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                <i class="bi bi-person me-2"></i>
                                My Profile
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.setting') }}" class="dropdown-item">
                                <i class="bi bi-gear me-2"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.notification') }}" class="dropdown-item ">
                                <i class="bi bi-bell me-2"></i>
                                Notifications
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.audit-logs.index') }}" class="dropdown-item">
                                <i class="bi bi-clock-history me-2"></i>
                                Activity Logs
                            </a>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>

                </div>
            </div>

        </nav>


        @if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

        @yield('content')

    </div>



    <!-- {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Automatically hide success and error alerts after 4 seconds
        setTimeout(function () {

            document.querySelectorAll('.alert').forEach(function (alert) {

                let bsAlert = bootstrap.Alert.getOrCreateInstance(alert);

                bsAlert.close();

            });

        }, 4000);
    </script>

    @stack('scripts')

</body>
</html>