@extends('layouts.admin')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')

<!-- Statistics -->
<div class="row g-3 mb-4">

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Total Users</small>
                <h3>{{ number_format($totalUsers) }}</h3>
                <span class="badge bg-success">+12%</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Active Users</small>
                <h3>{{ number_format($activeUsers) }}</h3>
                <span class="badge bg-success">Online</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">New Users Today</small>
                <h3>{{ $todayUsers }}</h3>
                <span class="badge bg-primary">Today</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Platform Wallet</small>
                <h3>{{ $setting->currency }}{{ number_format($walletBalance,2) }}</h3>
                <span class="badge bg-info">Available</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Today's Revenue</small>
                <h3>{{ $setting->currency }}{{ number_format($todayRevenue,2) }}</h3>
                <span class="badge bg-success">+8%</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Transactions</small>
                <h3>{{ number_format($transactions) }}</h3>
                <span class="badge bg-primary">Completed</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Pending Withdrawals</small>
                <h3>{{ $pendingWithdrawals }}</h3>
                <span class="badge bg-warning">Pending</span>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <small class="text-muted">Pending KYC</small>
                <h3>{{ $pendingKyc }}</h3>
                <span class="badge bg-danger">Review</span>
            </div>
        </div>
    </div>

</div>

<!-- Charts -->
<div class="row g-3 mb-4">

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Revenue & Transactions</h5>
                <canvas id="lineChart" height="110"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Service Usage</h5>
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>

</div>

<div class="row g-3">

    <!-- Recent Transactions -->
    <div class="col-lg-8">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Transactions</h5>
            </div>

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Service</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($recentTransactions as $transaction)

                        <tr>

                            <td>{{ $transaction->reference }}</td>

                            <td>{{ $transaction->user->name }}</td>

                            <td>{{ ucfirst($transaction->service) }}</td>

                            <td>{{ $setting->currency }}{{ number_format($transaction->amount,2) }}</td>

                            <td>

                            @if(strtolower($transaction->status) == 'successful' || strtolower($transaction->status) == 'success')
                                    <span class="badge bg-success">
                                        Success
                                    </span>

                                @elseif($transaction->status == 'pending')

                                    <span class="badge bg-warning">
                                        Pending
                                    </span>

                                @else

                                    <span class="badge bg-danger">
                                        Failed
                                    </span>

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center">
                            No Transactions Found
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    <!-- Right Side -->
    <div class="col-lg-4">

        <div class="card border-0 shadow-sm mb-3">

            <div class="card-header bg-white">
                <h5 class="mb-0">System Overview</h5>
            </div>

            <ul class="list-group list-group-flush">

                <li class="list-group-item d-flex justify-content-between">
                    Users
                    <strong>{{ number_format($totalUsers) }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    Wallet Balance
                    <strong>{{ $setting->currency }}{{ number_format($walletBalance,2) }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    Transactions
                    <strong>{{ number_format($transactions) }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    Pending Withdrawals
                    <strong>{{ $pendingWithdrawals }}</strong>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    Pending KYC
                    <strong class="text-danger">{{ $pendingKyc }}</strong>
                </li>
            </ul>

        </div>

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white">
                <h5 class="mb-0">Recent Activities</h5>
            </div>

            <div class="card-body">

                @forelse($recentActivities as $activity)

                <p>

                    <strong>{{ $activity->user->name }}</strong>

                    {{ $activity->service }}

                    {{ $setting->currency }}{{ number_format($activity->amount) }}

                </p>

                @empty

                <p>No recent activities.</p>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>

    new Chart(document.getElementById('lineChart'),{

    type:'line',

    data:{

        labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],

        datasets:[{

            label:'Revenue',

            data:@json($revenue),

            fill:true,

            tension:.4

        }]

    }

    });



    new Chart(document.getElementById('pieChart'),{

        type:'doughnut',

        data:{

            labels:@json($serviceUsage->keys()),

            datasets:[{

                data:@json($serviceUsage->values())

            }]

        }

    });

</script>

</script>

@endpush