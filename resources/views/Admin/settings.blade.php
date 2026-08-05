@extends('layouts.admin')

@section('title', 'Settings')

@section('page-title', 'System Settings')

@section('content')

<!-- Success Message -->
@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

        <button class="btn-close" data-bs-dismiss="alert"></button>

    </div>

@endif

<!-- Error Message -->
@if($errors->any())

    <div class="alert alert-danger">

        <i class="bi bi-exclamation-triangle-fill me-2"></i>

        Please fix the following errors.

        <hr>

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<!-- Settings Form -->
<form action="{{ route('admin.settings.update') }}"
      method="POST"
      enctype="multipart/form-data">

@csrf

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">System Settings</h3>
            <p class="text-muted mb-0">
                Configure the entire BillVexa platform.
            </p>
        </div>

        <button class="btn btn-primary btn-md shadow-sm">

            <i class="bi bi-check-circle-fill me-2"></i>

            Save All Changes

        </button>
    </div>

    <div class="row">

        <!-- General Settings -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-sliders me-2"></i>
                        General Settings
                    </h5>
                </div>

                <div class="card-body">
                  

                        <div class="mb-3">
                            <label class="form-label">Site Name</label>
                            <input name="site_name" type="text" class="form-control" value="{{ old('site_name', $setting->site_name) }}">

                            @error('site_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control">
                            
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contact Information</label>
                            <textarea name="contact_information" class="form-control" rows="3">{{ old('contact_information', $setting->contact_information) }}</textarea>
                        </div>
                        

                        <div class="mb-3">
                            <label class="form-label">Currency</label>
                            <select name="currency" class="form-select">
                                <option value="₦"
                                    {{ old('currency', $setting->currency) == '₦' ? 'selected' : '' }}>
                                    Nigerian Naira (₦)
                                </option>

                                <option value="$"
                                    {{ old('currency', $setting->currency) == '$' ? 'selected' : '' }}>
                                    US Dollar ($)
                                </option>

                                <option value="£"
                                    {{ old('currency', $setting->currency) == '£' ? 'selected' : '' }}>
                                    British Pound (£)
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="form-label">Time Zone</label>
                            <select name="timezone" class="form-select">
                                <option value="Africa/Lagos"
                                    {{ old('timezone', $setting->timezone) == 'Africa/Lagos' ? 'selected' : '' }}>
                                    Africa/Lagos
                                </option>

                                <option value="UTC"
                                    {{ old('timezone', $setting->timezone) == 'UTC' ? 'selected' : '' }}>
                                    UTC
                                </option>

                                <option value="Europe/London"
                                    {{ old('timezone', $setting->timezone) == 'Europe/London' ? 'selected' : '' }}>
                                    Europe/London
                                </option>
                            </select>
                        </div>

                    


                </div>

            </div>

        </div>

        <!-- Security -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-shield-lock me-2"></i>
                        Security
                    </h5>
                </div>

                <div class="card-body">

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input"
                        type="checkbox"
                        name="two_factor"
                        {{ $setting->two_factor ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Two-Factor Authentication
                        </label>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input
                        type="checkbox"
                        name="maintenance_mode"
                        {{ $setting->maintenance_mode ? 'checked' : '' }}>
                        <label class="form-check-label">
                            Maintenance Mode
                        </label>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Login Attempts
                        </label>
                        <input
                        type="number"
                        name="login_attempts"
                        class="form-control"
                        value="{{ old('login_attempts', $setting->login_attempts) }}">
                    </div>

                    <div>
                        <label class="form-label">
                            Session Timeout (Minutes)
                        </label>
                        <input
                        type="number"
                        name="session_timeout"
                        class="form-control"
                        value="{{ old('session_timeout', $setting->session_timeout) }}">
                    </div>

                </div>

            </div>

        </div>

        <!-- Transaction -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-wallet2 me-2"></i>
                        Transaction Settings
                    </h5>
                </div>

                <div class="card-body">

                    <!-- Minimum Transaction Amounts -->
                    <div class="mb-3">
                        <label class="form-label">
                            Minimum Deposit
                        </label>
                        <input
                        name="minimum_deposit"
                        type="number"
                        class="form-control"
                        value="{{ old('minimum_deposit',$setting->minimum_deposit) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">
                            Minimum Withdrawal
                        </label>
                        <input
                        name="minimum_withdrawal"
                        type="number"
                        class="form-control"
                        value="{{ old('minimum_withdrawal',$setting->minimum_withdrawal) }}">
                    </div>

                    <!-- VTU Service Discounts -->
                    <div class="mb-3">
                        <div class="card shadow-sm border-0">

                            <div class="card-header bg-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-percent me-2 text-success"></i>
                                    VTU Service Discounts
                                </h5>

                                <small class="text-muted">
                                    Set customer discounts for each service.
                                </small>
                            </div>

                            <div class="card-body">

                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Airtime Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="airtime_discount"
                                            value="{{ old('airtime_discount',$setting->airtime_discount) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Data Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="data_discount"
                                            value="{{ old('data_discount',$setting->data_discount) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Electricity Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="electricity_discount"
                                            value="{{ old('electricity_discount',$setting->electricity_discount) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Cable TV Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="cable_discount"
                                            value="{{ old('cable_discount',$setting->cable_discount) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Betting Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="betting_discount"
                                            value="{{ old('betting_discount',$setting->betting_discount) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Education Pin Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="education_discount"
                                            value="{{ old('education_discount',$setting->education_discount) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">
                                            Exam Pin Discount (%)
                                        </label>

                                        <input
                                            type="number"
                                            step="0.01"
                                            class="form-control"
                                            name="exam_discount"
                                            value="{{ old('exam_discount',$setting->exam_discount) }}">
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                    <div>
                        <label class="form-label">
                            Profit Percentage
                        </label>
                        <input
                        name="profit_percentage"
                        type="number"
                        class="form-control"
                        value="{{ old('profit_percentage',$setting->profit_percentage) }}">
                    </div>

                </div>

            </div>

        </div>

        <!-- API -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-cloud-arrow-up me-2"></i>
                        API Configuration
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">Airtime API</label>
                        <input
                        name="airtime_api"
                        type="text"
                        class="form-control"
                        value="{{ old('airtime_api',$setting->airtime_api) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Data API</label>
                        <input
                        name="data_api"
                        type="text"
                        class="form-control"
                        value="{{ old('data_api',$setting->data_api) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Electricity API</label>
                        <input
                        name="electricity_api"
                        type="text"
                        class="form-control"
                        value="{{ old('electricity_api',$setting->electricity_api) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cable API</label>
                        <input
                        name="cable_api"
                        type="text"
                        class="form-control"
                        value="{{ old('cable_api',$setting->cable_api) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Betting API</label>
                        <input
                        name="betting_api"
                        type="text"
                        class="form-control"
                        value="{{ old('betting_api',$setting->betting_api) }}">
                    </div>

                    <button
                        type="button"
                        class="btn btn-outline-primary">

                        <i class="bi bi-wifi me-2"></i>
                        Test API Connection

                    </button>

                </div>

            </div>

        </div>

        <!-- Email -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-envelope me-2"></i>
                        Email Configuration
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">
                            SMTP Server
                        </label>
                        <input
                        name="smtp_server"
                        type="text"
                        class="form-control"
                        value="{{ old('smtp_server',$setting->smtp_server) }}">
                    </div>

                    <div>
                        <label class="form-label">
                            Sender Name
                        </label>
                        <input
                        name="sender_name"
                        type="text"
                        class="form-control"
                        value="{{ old('sender_name',$setting->sender_name) }}">
                    </div>

                </div>

            </div>

        </div>

        <!-- SMS -->
        <div class="col-lg-6 mb-4">

            <div class="card shadow-sm border-0">

                <div class="card-header bg-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-dots me-2"></i>
                        SMS Configuration
                    </h5>
                </div>

                <div class="card-body">

                    <div class="mb-3">
                        <label class="form-label">
                            SMS Provider
                        </label>

                        <select name="sms_provider" class="form-select">

                            <option value="Termii"
                                {{ old('sms_provider', $setting->sms_provider) == 'Termii' ? 'selected' : '' }}>
                                Termii
                            </option>

                            <option value="Twilio"
                                {{ old('sms_provider', $setting->sms_provider) == 'Twilio' ? 'selected' : '' }}>
                                Twilio
                            </option>

                            <option value="Africa's Talking"
                                {{ old('sms_provider', $setting->sms_provider) == "Africa's Talking" ? 'selected' : '' }}>
                                Africa's Talking
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            API Key
                        </label>

                        <input
                        name="sms_api_key"
                        type="password"
                        class="form-control"
                        value="{{ old('sms_api_key',$setting->sms_api_key) }}">

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- Contact Information Preview -->
    <div class="card shadow-sm border-0 mt-4">

        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-info-circle me-2"></i>
                Contact Information Preview
            </h5>
        </div>

        <div class="card-body">

            <strong>{{ $setting->site_name }}</strong>

            <hr>

            {!! nl2br(e($setting->contact_information)) !!}

        </div>

    </div>
</form>
@endsection