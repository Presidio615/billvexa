@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('page-title', 'My Profile')

@section('content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}

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


    <div class="row">

        <!-- Left Card -->

        <div class="col-lg-4">

            <div class="card shadow-sm border-0">

                <div class="card-body text-center">

                    @if($admin->profile_photo)

                        <img src="{{ asset('storage/'.$admin->profile_photo) }}"
                             class="rounded-circle border border-3 border-primary mb-3"
                             width="140"
                             height="140">

                    @else

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&background=4f46e5&color=fff&size=200"
                             class="rounded-circle border border-3 border-primary mb-3">

                    @endif

                    <h4 class="fw-bold">

                        {{ $admin->name }}

                    </h4>

                    <p class="text-muted">

                        {{ $admin->email }}

                    </p>

                    <span class="badge bg-success px-3 py-2">

                        Administrator

                    </span>

                </div>

            </div>

        </div>

        <!-- Right -->

        <div class="col-lg-8">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Edit Profile

                    </h5>

                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('admin.profile.update') }}"
                          enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Full Name

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{ old('name',$admin->name) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Email Address

                                </label>

                                <input
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    value="{{ old('email',$admin->email) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Phone Number

                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    value="{{ old('phone',$admin->phone) }}">

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">

                                    Upload Profile Photo

                                </label>

                                <input
                                    type="file"
                                    class="form-control"
                                    name="profile_photo">

                            </div>

                        </div>

                        <button class="btn btn-primary">

                            <i class="bi bi-check-circle"></i>

                            Update Profile

                        </button>

                    </form>

                </div>

            </div>


            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">

                    <h5 class="mb-0">

                        Change Password

                    </h5>

                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('admin.password.update') }}">

                        @csrf

                        @method('PUT')

                        <div class="mb-3">

                            <label class="form-label">

                                Current Password

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                name="current_password">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                New Password

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                name="password">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Confirm Password

                            </label>

                            <input
                                type="password"
                                class="form-control"
                                name="password_confirmation">

                        </div>

                        <button class="btn btn-danger">

                            <i class="bi bi-key"></i>

                            Change Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection