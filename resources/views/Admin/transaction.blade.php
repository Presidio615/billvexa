@extends('layouts.admin')

@section('title', 'Transactions')

@section('page-title', 'Transaction Management')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Transaction Management</h3>
        <p class="text-muted mb-0">
            Manage all platform transactions.
        </p>
    </div>

    <a href="{{ route('admin.transaction.export') }}" class="btn btn-success">
        <i class="bi bi-download me-2"></i>
        Export Transactions
    </a>

</div>

<!-- Statistics -->

<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">Total Transactions</h6>

                <h2>{{ number_format($totalTransactions) }}</h2>

                <small class="text-primary">All Records</small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">Successful</h6>

                <h2>{{ number_format($successfulTransactions) }}</h2>

                <small class="text-success">Completed</small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">Pending</h6>

                <h2>{{ number_format($pendingTransactions) }}</h2>

                <small class="text-warning">Awaiting</small>

            </div>

        </div>

    </div>

    <div class="col-md-6 col-xl-3">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <h6 class="text-muted">Failed / Refunded</h6>

                <h2>{{ number_format($failedTransactions) }}</h2>

                <small class="text-danger">Attention Required</small>

            </div>

        </div>

    </div>

</div>

<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        <ul class="nav nav-pills">

            <li class="nav-item">
                <a href="{{ route('admin.transaction') }}"
                   class="nav-link {{ request('status') == null ? 'active' : '' }}">
                    All
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.transaction', ['status' => 'successful']) }}"
                   class="nav-link {{ request('status') == 'successful' ? 'active' : '' }}">
                    Successful
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.transaction', ['status' => 'pending']) }}"
                   class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}">
                    Pending
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.transaction', ['status' => 'failed']) }}"
                   class="nav-link {{ request('status') == 'failed' ? 'active' : '' }}">
                    Failed
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.transaction', ['status' => 'refunded']) }}"
                   class="nav-link {{ request('status') == 'refunded' ? 'active' : '' }}">
                    Refunded
                </a>
            </li>

        </ul>

    </div>
</div>
<!-- Search -->

<div class="card shadow-sm border-0 mb-4">
<div class="card-body">

    <form action="{{ route('admin.transaction') }}" method="GET">

        <div class="row g-3">

            <div class="col-lg-4">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Search Transaction ID..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-lg-3">
                <input type="date"
                       name="date"
                       class="form-control"
                       value="{{ request('date') }}">
            </div>

            <div class="col-lg-3">
                <select name="service" class="form-select">

                    <option value="">All Services</option>

                    <option value="Airtime"
                        {{ request('service') == 'Airtime' ? 'selected' : '' }}>
                        Airtime
                    </option>

                    <option value="Data"
                        {{ request('service') == 'Data' ? 'selected' : '' }}>
                        Data
                    </option>

                    <option value="Electricity"
                        {{ request('service') == 'Electricity' ? 'selected' : '' }}>
                        Electricity
                    </option>

                    <option value="Cable TV"
                        {{ request('service') == 'Cable TV' ? 'selected' : '' }}>
                        Cable TV
                    </option>

                </select>
            </div>

            <div class="col-lg-2">
    <div class="d-flex gap-2">

        <button type="submit" class="btn btn-primary flex-fill">
            <i class="bi bi-search me-1"></i> Search
        </button>

        <a href="{{ route('admin.transaction') }}" class="btn btn-secondary flex-fill">
            <i class="bi bi-arrow-clockwise me-1"></i> Clear
        </a>

    </div>
</div>
        </div>

    </form>

</div>
</div>

<!-- Transactions Table -->

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">
            Platform Transactions
        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">
            <h5>Total on this page: {{ $transactions->count() }}</h5>
            <h5>Total in database: {{ $transactions->total() }}</h5>

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>Transaction ID</th>
                        <th>User</th>
                        <th>Service</th>
                        <th>Amount</th>
                        <th>Profit</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th class="text-center">Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($transactions as $transaction)

                    <tr>

                        <td>{{ $transaction->reference }}</td>

                        <td>{{ $transaction->user->name }}</td>

                        <td>{{ $transaction->service }}</td>

                        <td>₦{{ number_format($transaction->total, 2) }}</td>

                        <td>₦{{ number_format($transaction->profit,2) }}</td>

                        <td>
                            <span class="badge
                                @if($transaction->status == 'successful')
                                    bg-success
                                @elseif($transaction->status == 'reversed')
                                    bg-warning
                                @elseif($transaction->status == 'refunded')
                                    bg-danger text-white
                                @else
                                    bg-primary
                                @endif">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>

                        <td>{{ $transaction->created_at->format('d M Y') }}</td>

                        <td>

                            <a href="{{ route('admin.transaction.show', $transaction) }}"
                                class="btn btn-primary btn-sm">
                                View
                            </a>

                            @if($transaction->status == 'pending')

                            <form action="{{ route('admin.transaction.approve', $transaction) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Approve
                                </button>

                            </form>

                            @else

                            <button class="btn btn-success btn-sm" disabled>
                                <i class="bi bi-check-circle-fill"></i> Approved
                            </button>

                            @endif

                            @if($transaction->status == 'successful')

                            <form action="{{ route('admin.transaction.reverse', $transaction) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button type="submit"
                                        class="btn btn-warning btn-sm"
                                        onclick="return confirm('Are you sure you want to reverse this transaction? The transaction amount will be credited back to the user wallet.')">

                                    <i class="bi bi-arrow-counterclockwise me-1"></i>

                                    Reverse

                                </button>

                            </form>

                            @else

                            <button class="btn btn-warning btn-sm" disabled>
                                <i class="bi bi-arrow-counterclockwise me-1"></i>
                                Reverse
                            </button>

                            @endif

                            @if($transaction->status == 'successful')

                            <form action="{{ route('admin.transaction.refund', $transaction) }}"
                                method="POST"
                                class="d-inline">

                                @csrf

                                <button type="submit"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Refund this transaction? The money will be returned to the customer wallet.')">

                                    <i class="bi bi-cash-coin me-1"></i>

                                    Refund

                                </button>

                            </form>

                            @else

                            <button class="btn btn-danger btn-sm" disabled>
                                <i class="bi bi-cash-coin me-1"></i>
                                Refund
                            </button>

                            @endif

                        </td>

                    </tr>

                    @endforeach



                </tbody>
            </table>

            <div class="mt-3">
                {{ $transactions->links() }}
            </div>

        </div>



    </div>

</div>

@endsection