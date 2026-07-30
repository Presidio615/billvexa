@extends('layouts.admin')

@section('title', 'Transaction Details')

@section('page-title', 'Transaction Details')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                <i class="bi bi-receipt-cutoff text-primary"></i>
                Transaction Details
            </h3>
            <p class="text-muted mb-0">
                View complete information about this transaction.
            </p>
        </div>

        <a href="{{ route('admin.transaction') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>

    </div>

    <div class="row">

        <!-- Transaction Information -->
        <div class="col-lg-8">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-info-circle"></i>
                        Transaction Information
                    </h5>
                </div>

                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <strong>Reference</strong>
                            <p>{{ $transaction->reference }}</p>
                        </div>

                        <div class="col-md-6">
                            <strong>Service</strong>
                            <p>{{ $transaction->service }}</p>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <strong>Amount</strong>
                            <h4 class="text-primary">
                                ₦{{ number_format($transaction->amount,2) }}
                            </h4>
                        </div>

                        <div class="col-md-6">
                            <strong>Profit</strong>
                            <h4 class="text-success">
                                ₦{{ number_format($transaction->profit,2) }}
                            </h4>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">

                            <strong>Status</strong>

                            <br>

                            @if($transaction->status=='successful')
                                <span class="badge bg-success fs-6">Successful</span>

                            @elseif($transaction->status=='pending')
                                <span class="badge bg-warning text-dark fs-6">Pending</span>

                            @elseif($transaction->status=='failed')
                                <span class="badge bg-danger fs-6">Failed</span>

                            @elseif($transaction->status=='refunded')
                                <span class="badge bg-info fs-6">Refunded</span>

                            @else
                                <span class="badge bg-secondary fs-6">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            @endif

                        </div>

                        <div class="col-md-6">

                            <strong>Date</strong>

                            <p>
                                {{ $transaction->created_at->format('d M Y h:i A') }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- User Information -->
        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        <i class="bi bi-person-circle"></i>
                        Customer
                    </h5>

                </div>

                <div class="card-body text-center">

                <img src="{{ $transaction->user->profile_photo
        ? asset('storage/' . $transaction->user->profile_photo)
        : asset('images/default-avatar.png') }}"
     class="rounded-circle"
     width="90"
     height="90"
     style="object-fit:cover;">

                    <h5>{{ $transaction->user->name }}</h5>

                    <p class="text-muted">
                        {{ $transaction->user->email }}
                    </p>

                    <hr>

                    <p>
                        <strong>Wallet Balance</strong><br>
                        ₦{{ number_format($transaction->user->wallet_balance,2) }}
                    </p>

                </div>

            </div>

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        <i class="bi bi-lightning-charge"></i>
                        Quick Actions
                    </h5>

                </div>

                <div class="card-body">

                    @if($transaction->status=='pending')

                    <form action="{{ route('admin.transaction.approve',$transaction) }}"
                          method="POST">
                        @csrf

                        <button class="btn btn-success w-100 mb-2">
                            <i class="bi bi-check-circle"></i>
                            Approve Transaction
                        </button>

                    </form>

                    @endif

                    @if($transaction->status=='successful')

                    <form action="{{ route('admin.transaction.refund',$transaction) }}"
                          method="POST">
                        @csrf

                        <button class="btn btn-danger w-100 mb-2">
                            <i class="bi bi-cash"></i>
                            Refund
                        </button>

                    </form>

                    <form action="{{ route('admin.transaction.reverse',$transaction) }}"
                          method="POST">
                        @csrf

                        <button class="btn btn-warning w-100">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reverse
                        </button>

                    </form>

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection