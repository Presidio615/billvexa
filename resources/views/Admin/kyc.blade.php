@extends('layouts.admin')

@section('title', 'NIN KYC')

@section('page-title', 'NIN KYC Verification')

@section('content')

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">NIN KYC Verification</h3>
        <p class="text-muted mb-0">
            Verify user identities and manage KYC requests.
        </p>
    </div>

    <button class="btn btn-primary">
        <i class="bi bi-download me-2"></i>
        Export Records
    </button>

</div>

<!-- Statistics -->
<div class="row g-4 mb-4">

    <div class="col-md-4">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>
                        <small class="text-muted">Pending</small>
                        <h2 class="fw-bold">{{ $pending }}</h2>
                    </div>

                    <i class="bi bi-hourglass-split fs-1 text-warning"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>
                        <small class="text-muted">Approved</small>
                        <h2 class="fw-bold">
                            {{ $approved }}
                        </h2>
                    </div>

                    <i class="bi bi-patch-check-fill fs-1 text-success"></i>

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow-sm border-0">

            <div class="card-body">

                <div class="d-flex justify-content-between">

                    <div>
                        <small class="text-muted">Rejected</small>
                        <h2 class="fw-bold">{{ $rejected }}</h2>
                    </div>

                    <i class="bi bi-x-circle-fill fs-1 text-danger"></i>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Search -->
<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" action="{{ route('admin.kyc') }}">
            <div class="row g-3">

                <div class="col-lg-5">

                    <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    class="form-control"
                    maxlength="100"
                    placeholder="Search by User, NIN or Phone">

                </div>

                <div class="col-lg-3">

                    <select name="status" class="form-select">

                    <option value="">All Status</option>

                        <option value="pending"
                            {{ request('status')=='pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved"
                            {{ request('status')=='approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected"
                            {{ request('status')=='rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>

                </div>

                <div class="col-lg-2">

                    <button class="btn btn-primary w-100">

                        <i class="bi bi-search me-2"></i>

                        Search

                    </button>

                </div>

                <div class="col-lg-2">

                    <button class="btn btn-secondary w-100">

                        Reset

                    </button>

                </div>

            </div>
        
        </form>

    </div>

</div>

<!-- KYC Table -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            NIN Verification Requests

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>User</th>
                        <th>NIN</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($users as $user)

                        <tr>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->nin }}</td>

                            <td>{{ $user->name }}</td>

                            <td>{{ $user->phone }}</td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>

                            <td>

                                @if($user->nin_status == 'approved')

                                    <span class="badge bg-success">Approved</span>

                                @elseif($user->nin_status == 'rejected')

                                    <span class="badge bg-danger">Rejected</span>

                                @else

                                    <span class="badge bg-warning text-dark">Pending</span>

                                @endif

                            </td>

                            <td>

                                <a href="{{ route('admin.kyc.show',$user) }}"
                                    class="btn btn-primary btn-sm">

                                    <i class="bi bi-eye"></i>

                                </a>

                                @if($user->nin_status == 'pending')

                                <form action="{{ route('admin.kyc.approve',$user) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    <button class="btn btn-success btn-sm">

                                        <i class="bi bi-check-lg"></i>

                                    </button>

                                </form>

                                <form action="{{ route('admin.kyc.reject',$user) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf

                                    <input type="hidden"
                                        name="reason"
                                        value="Rejected by admin">

                                    <button class="btn btn-danger btn-sm">

                                        <i class="bi bi-x-lg"></i>

                                    </button>

                                </form>

                                @endif

                                <a href="{{ route('admin.kyc.download',$user) }}"
                                    class="btn btn-dark btn-sm">

                                    <i class="bi bi-download"></i>

                                </a>

                            </td>

                        </tr>

                        @empty

                        <tr>

                        <td colspan="7" class="text-center">

                        No KYC requests found.

                        </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        

        <div class="mt-4">

            {{ $users->withQueryString()->links() }}

        </div>

    </div>

</div>

@endsection