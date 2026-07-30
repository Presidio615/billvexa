@extends('layouts.admin')

@section('title', 'Audit Logs')

@section('page-title', 'Audit Logs')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">Audit Logs</h3>
        <p class="text-muted mb-0">
            Track every administrative action performed on the BillVexa platform.
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

                <h2>15,642</h2>

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

                <h2>324</h2>

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

                <h2>48</h2>

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

                <h2>12</h2>

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

        <div class="row g-3">

            <div class="col-lg-4">

                <input
                    type="text"
                    class="form-control"
                    placeholder="Search logs...">

            </div>

            <div class="col-lg-3">

                <select class="form-select">

                    <option selected>
                        All Activities
                    </option>

                    <option>
                        Login
                    </option>

                    <option>
                        Logout
                    </option>

                    <option>
                        User Updated
                    </option>

                    <option>
                        Wallet Credited
                    </option>

                    <option>
                        Withdrawal Approved
                    </option>

                    <option>
                        Deposit Approved
                    </option>

                    <option>
                        Settings Changed
                    </option>

                </select>

            </div>

            <div class="col-lg-3">

                <input
                    type="date"
                    class="form-control">

            </div>

            <div class="col-lg-2">

                <button class="btn btn-primary w-100">
                    Search
                </button>

            </div>

        </div>

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

                    <tr>

                        <td>1</td>

                        <td>Super Admin</td>

                        <td>
                            <span class="badge bg-primary">
                                Login
                            </span>
                        </td>

                        <td>
                            Administrator logged into dashboard
                        </td>

                        <td>
                            192.168.1.1
                        </td>

                        <td>
                            05 Jul 2026 09:10 AM
                        </td>

                    </tr>

                    <tr>

                        <td>2</td>

                        <td>Super Admin</td>

                        <td>
                            <span class="badge bg-secondary">
                                Logout
                            </span>
                        </td>

                        <td>
                            Administrator logged out
                        </td>

                        <td>
                            192.168.1.1
                        </td>

                        <td>
                            05 Jul 2026 10:20 AM
                        </td>

                    </tr>

                    <tr>

                        <td>3</td>

                        <td>Manager</td>

                        <td>
                            <span class="badge bg-warning text-dark">
                                User Updated
                            </span>
                        </td>

                        <td>
                            Updated John David's profile
                        </td>

                        <td>
                            192.168.1.15
                        </td>

                        <td>
                            05 Jul 2026 11:15 AM
                        </td>

                    </tr>

                    <tr>

                        <td>4</td>

                        <td>Finance Admin</td>

                        <td>
                            <span class="badge bg-success">
                                Wallet Credited
                            </span>
                        </td>

                        <td>
                            Credited ₦10,000 to Mary Johnson
                        </td>

                        <td>
                            192.168.1.18
                        </td>

                        <td>
                            05 Jul 2026 11:40 AM
                        </td>

                    </tr>

                    <tr>

                        <td>5</td>

                        <td>Finance Admin</td>

                        <td>
                            <span class="badge bg-info">
                                Withdrawal Approved
                            </span>
                        </td>

                        <td>
                            Approved ₦25,000 withdrawal
                        </td>

                        <td>
                            192.168.1.18
                        </td>

                        <td>
                            05 Jul 2026 12:05 PM
                        </td>

                    </tr>

                    <tr>

                        <td>6</td>

                        <td>Finance Admin</td>

                        <td>
                            <span class="badge bg-dark">
                                Deposit Approved
                            </span>
                        </td>

                        <td>
                            Approved ₦50,000 deposit
                        </td>

                        <td>
                            192.168.1.18
                        </td>

                        <td>
                            05 Jul 2026 12:20 PM
                        </td>

                    </tr>

                    <tr>

                        <td>7</td>

                        <td>Super Admin</td>

                        <td>
                            <span class="badge bg-danger">
                                Settings Changed
                            </span>
                        </td>

                        <td>
                            Updated platform transaction charges
                        </td>

                        <td>
                            192.168.1.1
                        </td>

                        <td>
                            05 Jul 2026 01:00 PM
                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-end mt-3">

            <nav>

                <ul class="pagination mb-0">

                    <li class="page-item disabled">
                        <a class="page-link">
                            Previous
                        </a>
                    </li>

                    <li class="page-item active">
                        <a class="page-link">
                            1
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link">
                            2
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link">
                            3
                        </a>
                    </li>

                    <li class="page-item">
                        <a class="page-link">
                            Next
                        </a>
                    </li>

                </ul>

            </nav>

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