@extends('layouts.admin')

@section('title','Search')

@section('page-title','Search Results')

@section('content')

<div class="card shadow-sm">

    <div class="card-body">

        <h4>

            Search:
            <strong>{{ $search }}</strong>

        </h4>

    </div>

</div>

<br>

<div class="card shadow-sm">

    <div class="card-header">

        <h5>Users</h5>

    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>

                    <th>Name</th>

                    <th>Email</th>

                    <th>Phone</th>

                    <th>Wallet</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                <tr>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>{{ $user->phone }}</td>

                    <td>₦{{ number_format($user->wallet_balance,2) }}</td>

                </tr>

                @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No user found.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<br>

<div class="card shadow-sm">

    <div class="card-header">

        <h5>Transactions</h5>

    </div>

    <div class="table-responsive">

        <table class="table">

            <thead>

                <tr>

                    <th>Reference</th>

                    <th>User</th>

                    <th>Service</th>

                    <th>Amount</th>

                    <th>Status</th>

                </tr>

            </thead>

            <tbody>

                @forelse($transactions as $transaction)

                <tr>

                    <td>{{ $transaction->reference }}</td>

                    <td>{{ optional($transaction->user)->name }}</td>

                    <td>{{ $transaction->service }}</td>

                    <td>₦{{ number_format($transaction->amount,2) }}</td>

                    <td>

                        @php
                            $status = strtolower($transaction->status);
                        @endphp

                        @if($status == 'successful' || $status == 'success')

                            <span class="badge bg-success">

                                {{ $transaction->status }}

                            </span>

                        @elseif($status == 'pending')

                            <span class="badge bg-warning">

                                {{ $transaction->status }}

                            </span>

                        @else

                            <span class="badge bg-danger">

                                {{ $transaction->status }}

                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5" class="text-center">

                        No transaction found.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection