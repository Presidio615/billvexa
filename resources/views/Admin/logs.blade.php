@extends('layouts.admin')

@section('title', 'Audit Logs')

@section('page-title', 'Audit Logs')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Audit Logs</h3>
        <p class="text-muted mb-0">
            Track every administrative action performed on the {{ $setting->site_name ?? 'BillVexa' }} platform.
        </p>
    </div>

</div>

<!-- Statistics -->
<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Total Logs
                </h6>

                <h2>{{ number_format($totalLogs) }}</h2>

                <small class="text-primary">
                    All Activities
                </small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Today's Activities
                </h6>

                <h2>{{ number_format($todayActivities) }}</h2>

                <small class="text-success">
                    Live Updates
                </small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Admin Logins
                </h6>

                <h2>{{ number_format($adminLogins) }}</h2>

                <small class="text-info">
                    Today
                </small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Settings Changes
                </h6>

                <h2>{{ number_format($settingsChanges) }}</h2>

                <small class="text-warning">
                    Recent
                </small>

            </div>

        </div>

    </div>

</div>

<!-- Search -->
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('admin.audit-logs.index') }}">

            <div class="row g-3">

                <div class="col-lg-4">

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search logs..."
                    >

                </div>

                <div class="col-lg-3">

                    <select
                        name="activity"
                        class="form-select"
                    >

                        <option value="">
                            All Activities
                        </option>

                        <option
                            value="Login"
                            @selected(request('activity') === 'Login')
                        >
                            Login
                        </option>

                        <option
                            value="Logout"
                            @selected(request('activity') === 'Logout')
                        >
                            Logout
                        </option>

                        <option
                            value="User Updated"
                            @selected(request('activity') === 'User Updated')
                        >
                            User Updated
                        </option>

                        <option
                            value="Wallet Credited"
                            @selected(request('activity') === 'Wallet Credited')
                        >
                            Wallet Credited
                        </option>

                        <option
                            value="Withdrawal Approved"
                            @selected(request('activity') === 'Withdrawal Approved')
                        >
                            Withdrawal Approved
                        </option>

                        <option
                            value="Deposit Approved"
                            @selected(request('activity') === 'Deposit Approved')
                        >
                            Deposit Approved
                        </option>

                        <option
                            value="Settings Changed"
                            @selected(request('activity') === 'Settings Changed')
                        >
                            Settings Changed
                        </option>

                    </select>

                </div>

                <div class="col-lg-3">

                    <input
                        type="date"
                        name="date"
                        value="{{ request('date') }}"
                        class="form-control"
                    >

                </div>

                <div class="col-lg-2">

                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Search
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- Audit Logs Table -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            Audit Logs

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>#</th>
                        <th>Admin</th>
                        <th>Activity</th>
                        <th>Description</th>
                        <th>IP Address</th>
                        <th>Date & Time</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($logs as $log)

                        <tr>

                            <td>
                                {{ $logs->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $log->admin?->name ?? 'System' }}
                            </td>

                            <td>

                                @php
                                    $badge = match($log->activity) {
                                        'Login' => 'primary',
                                        'Logout' => 'secondary',
                                        'User Updated' => 'warning',
                                        'Wallet Credited' => 'success',
                                        'Withdrawal Approved' => 'info',
                                        'Deposit Approved' => 'dark',
                                        'Settings Changed' => 'danger',
                                        default => 'primary',
                                    };
                                @endphp

                                <span class="badge bg-{{ $badge }} 
                                    @if($badge === 'warning') text-dark @endif">

                                    {{ $log->activity }}

                                </span>

                            </td>

                            <td>
                                {{ $log->description ?? 'No description' }}
                            </td>

                            <td>
                                {{ $log->ip_address ?? 'N/A' }}
                            </td>

                            <td>
                                {{ $log->created_at->format('d M Y h:i A') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center py-4">

                                <i class="bi bi-inbox fs-2 text-muted"></i>

                                <p class="text-muted mb-0">
                                    No audit logs found.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-3">

            {{ $logs->links() }}

        </div>
    </div>

</div>

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

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@endsection