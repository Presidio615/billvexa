@extends('layouts.admin')

@section('title', 'Deposit Management')

@section('page-title', 'Deposit Management')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">Deposit Management</h3>

        <p class="text-muted mb-0">
            Manage user deposits.
        </p>

    </div>

</div>

<!-- Statistics -->

<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Total Deposits
                </h6>

                <h2>{{ number_format($totalDeposits) }}</h2>

                <small class="text-primary">
                    All Deposits
                </small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Pending
                </h6>

                <h2>{{ number_format($pendingDeposits) }}</h2>

                <small class="text-warning">
                    Awaiting Approval
                </small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Approved
                </h6>

                <h2>{{ number_format($approvedDeposits) }}</h2>

                <small class="text-success">
                    Successful
                </small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">
                    Rejected
                </h6>

                <h2>{{ number_format($rejectedDeposits) }}</h2>

                <small class="text-danger">
                    Declined
                </small>

            </div>

        </div>

    </div>

</div>

<!-- Search -->

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET">

            <div class="row g-3">

                <div class="col-lg-5">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Search user or reference">

                </div>

                <div class="col-lg-3">

                    <select
                        name="status"
                        class="form-select">

                        <option value="">All Status</option>

                        <option value="pending"
                            @selected(request('status')=='pending')>
                            Pending
                        </option>

                        <option value="approved"
                            @selected(request('status')=='approved')>
                            Approved
                        </option>

                        <option value="rejected"
                            @selected(request('status')=='rejected')>
                            Rejected
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <button class="btn btn-primary w-100">
                        Search
                    </button>

                </div>

                <div class="col-lg-2">

                    <a href="{{ route('admin.deposit') }}"
                    class="btn btn-secondary w-100">
                        Reset
                    </a>

                </div>

            </div>

        </form>
    </div>

</div>

<!-- Deposit Table -->

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            User Deposits
        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>User</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($deposits as $deposit)

                        <tr>

                            <td>

                                {{ $deposit->user->name }}

                                <br>

                                <small class="text-muted">
                                    {{ $deposit->user->email }}
                                </small>

                            </td>

                            <td>

                                ₦{{ number_format($deposit->amount,2) }}

                            </td>

                            <td>

                                {{ $deposit->method }}

                            </td>

                            <td>

                                {{ $deposit->reference }}

                            </td>

                            <td>

                                @if($deposit->status=='pending')

                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>

                                @elseif($deposit->status=='approved')

                                    <span class="badge bg-success">
                                        Approved
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>

                                @endif

                            </td>

                            <td class="text-center">

                                @if($deposit->status=='pending')

                                    <form
                                    method="POST"
                                    action="{{ route('admin.deposit.approve',$deposit) }}"
                                    class="d-inline">

                                        @csrf

                                        <button class="btn btn-success btn-sm">
                                            Approve
                                        </button>

                                    </form>

                                    <form
                                    method="POST"
                                    action="{{ route('admin.deposit.reject',$deposit) }}"
                                    class="d-inline">

                                        @csrf

                                        <button class="btn btn-danger btn-sm">
                                            Reject
                                        </button>

                                    </form>

                                @endif

                                @if($deposit->receipt)

                                    <a href="{{ asset('storage/'.$deposit->receipt) }}"
                                    target="_blank"
                                    class="btn btn-primary btn-sm">

                                        Receipt

                                    </a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                No deposits found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        <div class="mt-3">

            {{ $deposits->links() }}

        </div>

    </div>

</div>

@endsection