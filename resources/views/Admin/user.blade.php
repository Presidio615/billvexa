@extends('layouts.admin')

@section('title', 'Users')

@section('page-title', 'User Management')

@section('content')

<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            <i class="bi bi-people-fill text-primary"></i>
            User Management
        </h3>

        <p class="text-muted mb-0">
            Manage every registered user on {{ $setting->site_name ?? 'BillVexa' }}.
        </p>
    </div>

    <div>

        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus"></i> Add User
        </a>

    </div>

</div>

<!-- Statistics -->

<div class="row g-4 mb-4">

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Total Users</small>
                <h2>{{ number_format($stats['total']) }}</h2>
                <small class="text-success">
                    +152 this week
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Verified Users</small>
                <h2>{{ number_format($stats['verified']) }}</h2>
                <small class="text-success">
                    87%
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Suspended Users</small>
                <h2>{{ number_format($stats['suspended']) }}</h2>
                <small class="text-danger">
                    Restricted
                </small>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <small class="text-muted">Pending KYC</small>
                <h2>{{ number_format($stats['pending']) }}</h2>
                <small class="text-warning">
                    Awaiting Review
                </small>
            </div>
        </div>
    </div>

</div>

<!-- Search -->

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('admin.user') }}">

            <div class="row g-3">

                <div class="col-lg-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Search name, email or phone">
                </div>

                <div class="col-lg-2">

                    <select name="status" class="form-select">

                        <option value="">All Users</option>

                        <option value="verified" {{ request('status')=='verified'?'selected':'' }}>
                            Verified
                        </option>

                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>
                            Pending
                        </option>

                        <option value="suspended" {{ request('status')=='suspended'?'selected':'' }}>
                            Suspended
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <select name="wallet" class="form-select">

                        <option value="">All Wallets</option>

                        <option value="high" {{ request('wallet')=='high'?'selected':'' }}>
                            Above ₦100,000
                        </option>

                        <option value="low" {{ request('wallet')=='low'?'selected':'' }}>
                            Below ₦10,000
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">
                    <button class="btn btn-primary w-100">
                        Search
                    </button>
                </div>

                <div class="col-lg-2">
                    <a href="{{ route('admin.user') }}"
                        class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>

            </div>

        </form>

    </div>

</div>

<!-- Users -->

<div class="card border-0 shadow-sm">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            Registered Users
        </h5>

        <span class="badge bg-primary">
            {{ number_format($users->total()) }} Users
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr>

                    <th>User</th>
                    <th>Wallet</th>
                    <th>KYC</th>
                    <th>Status</th>
                    <th>Transactions</th>
                    <th>Last Login</th>
                    <th width="420">Actions</th>

                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>

                            @php
                                $nameParts = preg_split('/\s+/', trim($user->name));
                                $initials = '';

                                foreach (array_slice($nameParts, 0, 2) as $part) {
                                    $initials .= strtoupper(substr($part, 0, 1));
                                }
                            @endphp

                            @if($user->profile_photo)

                                <img
                                    src="{{ asset('storage/' . $user->profile_photo) }}"
                                    alt="{{ $user->name }}"
                                    width="40"
                                    height="40"
                                    class="rounded-circle me-2"
                                    style="object-fit: cover;"
                                >

                            @else

                                <span
                                    class="rounded-circle bg-primary text-white fw-bold d-inline-flex align-items-center justify-content-center me-2"
                                    style="width:40px; height:40px; font-size:14px;"
                                >
                                    {{ $initials }}
                                </span>

                            @endif

                            <strong>{{ $user->name }}</strong>

                            <br>

                            <small class="text-muted">
                                {{ $user->email }}
                            </small>

                        </td>

                        <td>

                            ₦{{ number_format($user->wallet_balance,2) }}

                        </td>

                        <td>

                            @if($user->kyc_verified)

                                <span class="badge bg-success">

                                    Verified

                                </span>

                            @else

                                <span class="badge bg-warning">

                                    Pending

                                </span>

                            @endif

                        </td>

                        <td>

                        <span class="badge bg-success">
                            Active
                        </span>

                        </td>

                        <td>

                            {{ $user->transactions()->count() }}

                        </td>

                        <td>

                            {{ $user->updated_at->diffForHumans() }}

                        </td>

                        <td>

                            <div class="btn-group btn-group-sm">

                                <!-- View -->
                                <a href="{{ route('admin.user.show', $user->id) }}"
                                    class="btn btn-primary"
                                    title="View User">

                                    <i class="bi bi-eye"></i>

                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                    class="btn btn-warning"
                                    title="Edit User">

                                    <i class="bi bi-pencil"></i>

                                </a>

                                <!-- Credit Wallet -->
                                <button
                                    class="btn btn-success"
                                    data-bs-toggle="modal"
                                    data-bs-target="#creditModal{{ $user->id }}"
                                    title="Credit Wallet">

                                    <i class="bi bi-plus-circle"></i>

                                </button>

                                <!-- Debit Wallet -->
                                <button
                                    class="btn btn-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#debitModal{{ $user->id }}"
                                    title="Debit Wallet">

                                    <i class="bi bi-dash-circle"></i>

                                </button>

                                <!-- Delete -->
                                <form action="{{ route('admin.user.delete',$user->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this user?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-secondary">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </div>

                    
                        </td>
                        
                    </tr>

                    <div class="modal fade" id="creditModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ route('admin.user.credit', $user) }}" method="POST">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">Credit Wallet</h5>

                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <p>
                                            Credit
                                            <strong>{{ $user->name }}</strong>
                                        </p>

                                        <input
                                            type="number"
                                            name="amount"
                                            class="form-control"
                                            placeholder="Enter Amount"
                                            min="1"
                                            required>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button class="btn btn-success">
                                            Credit Wallet
                                        </button>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="debitModal{{ $user->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="{{ route('admin.user.debit', $user) }}" method="POST">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">Debit Wallet</h5>

                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal">
                                        </button>
                                    </div>

                                    <div class="modal-body">

                                        <p>
                                            Debit
                                            <strong>{{ $user->name }}</strong>
                                        </p>

                                        <input
                                            type="number"
                                            name="amount"
                                            class="form-control"
                                            placeholder="Enter Amount"
                                            min="1"
                                            required>

                                    </div>

                                    <div class="modal-footer">

                                        <button type="button"
                                                class="btn btn-secondary"
                                                data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button class="btn btn-danger">
                                            Debit Wallet
                                        </button>

                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                @empty

                <tr>

                    <td colspan="7" class="text-center">

                        No users found.

                    </td>

                </tr>

            @endforelse

        </tbody>
    </table>

</div>

<div class="card-footer bg-white">

{{ $users->links() }}

</div>

@endsection