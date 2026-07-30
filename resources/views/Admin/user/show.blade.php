@extends('layouts.admin')

@section('title', 'User Details')

@section('page-title', 'User Details')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-person-circle"></i>
                {{ $user->name }}
            </h4>

            <a href="{{ route('admin.user') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Back
            </a>
        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-4 text-center">

                    @if($user->profile_photo)
                        <img src="{{ asset('storage/'.$user->profile_photo) }}"
                             class="rounded-circle img-fluid"
                             style="width:150px;height:150px;object-fit:cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D6EFD&color=fff&size=150"
                             class="rounded-circle">
                    @endif

                </div>

                <div class="col-md-8">

                    <table class="table table-bordered">

                        <tr>
                            <th width="35%">Full Name</th>
                            <td>{{ $user->name }}</td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <th>Wallet Balance</th>
                            <td>₦{{ number_format($user->wallet_balance,2) }}</td>
                        </tr>

                        <tr>
                            <th>Account Number</th>
                            <td>{{ $user->account_number }}</td>
                        </tr>

                        <tr>
                            <th>Bank</th>
                            <td>{{ $user->account_bank }}</td>
                        </tr>

                        <tr>
                            <th>Referral Code</th>
                            <td>{{ $user->referral_code }}</td>
                        </tr>

                        <tr>
                            <th>KYC Status</th>
                            <td>
                                @if($user->kyc_verified)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th>Joined</th>
                            <td>{{ $user->created_at->format('d M Y h:i A') }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="card mt-4 shadow-sm">

        <div class="card-header">
            <h5 class="mb-0">Recent Transactions</h5>
        </div>

        <div class="card-body">

            @if($user->transactions->count())

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>
                                <th>Reference</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach($user->transactions as $transaction)

                                <tr>

                                    <td>{{ $transaction->reference }}</td>

                                    <td>{{ $transaction->service }}</td>

                                    <td>₦{{ number_format($transaction->amount,2) }}</td>

                                    <td>{{ ucfirst($transaction->type) }}</td>

                                    <td>
                                        @if($transaction->status == 'Successful')
                                            <span class="badge bg-success">Success</span>
                                        @elseif($transaction->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Failed</span>
                                        @endif
                                    </td>

                                    <td>{{ $transaction->created_at->format('d M Y') }}</td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-info">
                    No transactions found.
                </div>

            @endif

        </div>

    </div>

</div>

@endsection