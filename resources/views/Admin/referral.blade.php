@extends('layouts.admin')

@section('title', 'Referral Management')

@section('page-title', 'Referral Management')

@section('content')

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Referral Management</h3>
        <p class="text-muted mb-0">
            Manage referral rewards, bonuses and payouts.
        </p>
    </div>

</div>

<!-- Success Message -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Error Message -->
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('error') }}
    <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Validation Errors -->
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


<!-- Overview -->
<div class="row g-4 mb-4">

    <!-- Total Referrals -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Total Referrals</small>

                    <h3 class="fw-bold mb-1">
                        {{ number_format($totalReferrals) }}
                    </h3>

                    <span class="text-primary small">
                        All referred users
                    </span>
                </div>

                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Successful Referrals -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Successful Referrals</small>

                    <h3 class="fw-bold mb-1">
                        {{ number_format($successfulReferrals) }}
                    </h3>

                    <span class="text-success small">
                        Bonus credited
                    </span>
                </div>

                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-check-circle-fill fs-3 text-success"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Total Bonus -->
    <div class="col-md-6 col-xl-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Bonus Paid</small>

                    <h3 class="fw-bold mb-1">
                        ₦{{ number_format($totalBonus, 2) }}
                    </h3>

                    <span class="text-warning small">
                        Referral rewards
                    </span>
                </div>

                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-cash-stack fs-3 text-warning"></i>
                </div>

            </div>
        </div>
    </div>

    <!-- Top Referrer -->
    <!-- <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body d-flex justify-content-between align-items-center">

                <div>
                    <small class="text-muted">Top Referrer</small>

                    <h5 class="fw-bold mb-1">
                        {{ $topReferrer?->name ?? 'N/A' }}
                    </h5>

                    <span class="text-info small">
                        {{ $topReferrals }} Referrals
                    </span>
                </div>

                <div class="bg-info bg-opacity-10 rounded-circle p-3">
                    <i class="bi bi-trophy-fill fs-3 text-info"></i>
                </div>

            </div>
        </div>
    </div> -->

</div>


<!-- Search -->
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('admin.referrals.index') }}">

            <div class="row g-3">

                <div class="col-lg-5">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Search Referrer or Referred User"
                        value="{{ request('search') }}">

                </div>

                <div class="col-lg-2">

                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>
                        Search
                    </button>

                </div>

                <div class="col-lg-2">

                    <a href="{{ route('admin.referrals.index') }}"
                       class="btn btn-secondary w-100">
                        Reset
                    </a>

                </div>

            </div>

        </form>

    </div>

</div>

<!-- Referral Table -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            Referral Records

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Referrer</th>

                        <th>Referred User</th>

                        <th>Bonus</th>

                        <th>Status</th>

                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($referrals as $user)

                <tr>

                    <td>
                        {{ optional($user->referrer)->name ?? 'Direct Registration' }}
                    </td>

                    <td>
                        {{ $user->name }}
                        <br>
                        <small class="text-muted">{{ $user->email }}</small>
                    </td>

                    <td>
                        ₦500.00
                    </td>

                    <td>
                        <span class="badge bg-success">
                            Completed
                        </span>
                    </td>

                    <td>
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6" class="text-center py-4">

                        <i class="bi bi-people fs-2 text-muted"></i>

                        <p class="mt-2 mb-0">
                            No referral records found.
                        </p>

                    </td>

                </tr>

                @endforelse

                </tbody>
            </table>

        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $referrals->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection