@extends('layouts.admin')

@section('title', 'Service Management')

@section('page-title', 'Service Management')

@section('content')


    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        {{ session('success') }}

        <button
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif

    @if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

    @endif

    @if(session('error'))

    <div class="alert alert-danger alert-dismissible fade show">

        {{ session('error') }}

        <button
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Service Management</h3>
            <p class="text-muted mb-0">
                Manage all services offered on BillVexa.
            </p>
        </div>

        <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addService">

            <i class="bi bi-plus-circle me-2"></i>

            Add New Service
            

        </button>

    </div>

    <!-- Statistics -->
    <div class="row g-4 mb-4">

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Total Services</h6>
                    <h2>{{ $totalServices }}</h2>
                    <small class="text-success">All Available</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Active</h6>
                    <h2>{{ $activeServices }}</h2>
                    <small class="text-success">Enabled</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Disabled</h6>
                    <h2>{{ $disabledServices }}</h2>
                    <small class="text-danger">Unavailable</small>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h6 class="text-muted">Connected APIs</h6>
                    <h2>{{ $connectedApis }}</h2>
                    <small class="text-primary">Running</small>
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
                            value="{{ request('search') }}"
                            class="form-control"
                            placeholder="Search service...">

                    </div>

                    <div class="col-lg-3">

                        <select name="status" class="form-select">

                            <option value="">All Services</option>

                            <option value="enabled"
                                {{ request('status')=='enabled' ? 'selected' : '' }}>
                                Enabled
                            </option>

                            <option value="disabled"
                                {{ request('status')=='disabled' ? 'selected' : '' }}>
                                Disabled
                            </option>

                        </select>

                    </div>

                    <div class="col-lg-2">

                        <button class="btn btn-primary w-100">
                            Search
                        </button>

                    </div>

                    <div class="col-lg-2">

                        <a href="{{ route('admin.service') }}"
                        class="btn btn-secondary w-100">
                            Reset
                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <!-- Services Table -->

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">
            <h5 class="mb-0">Available Services</h5>
        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                    <tr>

                        <th>#</th>
                        <th>Service</th>
                        <th>Provider</th>
                        <th>Charge</th>
                        <th>Profit</th>
                        <th>Minimum</th>
                        <th>Maximum</th>
                        <th>Status</th>
                        <th>API Status</th>
                        <th class="text-center">Admin Actions</th>

                    </tr>

                    </thead>

                    <tbody>

                        @forelse($services as $service)

                            <tr>

                                <td>{{ $services->firstItem()+$loop->index }}</td>

                                <td>{{ $service->name }}</td>

                                <td>{{ $service->provider }}</td>

                                <td>₦{{ number_format($service->charge,2) }}</td>

                                <td>{{ $service->profit }}%</td>

                                <td>₦{{ number_format($service->minimum,2) }}</td>

                                <td>₦{{ number_format($service->maximum,2) }}</td>

                                <td>

                                    @if($service->status)

                                        <span class="badge bg-success">

                                            Enabled

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Disabled

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($service->api_name)

                                        <span class="badge bg-success">
                                            Connected
                                        </span>

                                    @else

                                        <span class="badge bg-secondary">
                                            Not Connected
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <div class="btn-group">

                                        <button
                                            class="btn btn-success btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#enableModal{{ $service->id }}">
                                            Enable
                                        </button>

                                        <button
                                            class="btn btn-danger btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#disableModal{{ $service->id }}">
                                            Disable
                                        </button>

                                        <button
                                            class="btn btn-warning btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#profitModal{{ $service->id }}">
                                            Profit
                                        </button>

                                        <button
                                            class="btn btn-info btn-sm text-white"
                                            data-bs-toggle="modal"
                                            data-bs-target="#chargeModal{{ $service->id }}">
                                            Charge
                                        </button>

                                        <button
                                            class="btn btn-secondary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#limitModal{{ $service->id }}">
                                            Limit
                                        </button>

                                        <button
                                            class="btn btn-primary btn-sm"
                                            data-bs-toggle="modal"
                                            data-bs-target="#apiModal{{ $service->id }}">
                                            API
                                        </button>

                                    </div>

                                    @include('Admin.modals.service')

                                </td>
                            </tr>

                        @empty

                            <tr>

                                <td colspan="10" class="text-center">

                                    No services found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                    <div class="d-flex justify-content-end mt-3">

                        {{ $services->links() }}

                    </div>
                </table>

            </div>

        </div>

    </div>


    <div class="col-lg-6 mt-2">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h5 class="mb-0">API Management</h5>
            </div>

            <div class="card-body">

                <div class="d-grid gap-2">

                    <button class="btn btn-primary">
                        Configure API
                    </button>
                    
                    @if($services->count())
                    <form
                        method="POST"
                        action="{{ route('admin.service.test', $services->first()) }}">

                        @csrf

                        <button class="btn btn-outline-primary">

                            Test API Connection

                        </button>

                    </form>
                    @endif
                </div>

            </div>

        </div>

    </div>



    <div class="modal fade" id="addService">

        <div class="modal-dialog modal-lg">

            <div class="modal-content">

                <form
                method="POST"
                action="{{ route('admin.service.store') }}">

                    @csrf

                    <div class="modal-header">

                        <h5>Add Service</h5>

                        <button
                        class="btn-close"
                        data-bs-dismiss="modal"></button>

                    </div>

                    <div class="modal-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label>Status</label>

                                <select
                                    name="status"
                                    class="form-select">

                                    <option value="1">

                                        Enabled

                                    </option>

                                    <option value="0">

                                        Disabled

                                    </option>

                                </select>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Name</label>

                                <input
                                type="text"
                                name="name"
                                class="form-control"
                                value="{{ old('name') }}"
                                required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Provider</label>

                                <input
                                type="text"
                                name="provider"
                                class="form-control"
                                value="{{ old('provider') }}"
                                required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Charge</label>

                                <input
                                type="number"
                                name="charge"
                                class="form-control"
                                value="{{ old('charge') }}"
                                required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Profit</label>

                                <input
                                type="number"
                                name="profit"
                                class="form-control"
                                value="{{ old('profit') }}"
                                required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Minimum</label>

                                <input
                                type="number"
                                name="minimum"
                                class="form-control"
                                value="{{ old('minimum') }}"
                                required>

                            </div>

                            <div class="col-md-6 mb-3">

                                <label>Maximum</label>

                                    <input
                                    type="number"
                                    name="maximum"
                                    class="form-control"
                                    value="{{ old('maximum') }}"
                                    required>

                                </div>

                                <div class="col-12">

                                    <label>API Name</label>

                                    <input
                                    type="text"
                                    name="api_name"
                                    class="form-control"
                                    value="{{ old('api-name') }}">

                                </div>

                                <div class="col-md-6 mb-3">

                                    <label>API Provider</label>

                                    <select
                                        name="provider"
                                        class="form-select">

                                        <option value="VTpass">

                                            VTpass

                                        </option>

                                        <option value="ClubKonnect">

                                            ClubKonnect

                                        </option>

                                        <option value="RechargeCardPrint">

                                            Recharge Card Print

                                        </option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <div class="modal-footer">

                            <button
                            class="btn btn-primary">

                                Save Service

                            </button>
                        </div>    

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection