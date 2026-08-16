<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Settings Dashboard
    </title>

    <!-- icon image -->
    <link rel="shortcut icon" href="../../Assets/Image/icon.png" type="image/x-icon">
    
    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7fe;
            font-family:Arial, Helvetica, sans-serif;
            overflow-x:hidden;
        }

        /* DESKTOP SIDEBAR */
        .sidebar{

            width:260px;
            min-height:100vh;

            background:linear-gradient(
                180deg,
                #5b21b6,
                #2563eb
            );

            position:fixed;
            left:0;
            top:0;

            padding:25px 15px;

            z-index:1000;
        }

        .sidebar a{

            display:flex;
            align-items:center;
            gap:12px;

            color:white;
            text-decoration:none;

            padding:14px 16px;

            border-radius:14px;

            margin-bottom:10px;

            transition:.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active{

            background:rgba(255,255,255,.15);
        }

        /* MOBILE NAV */
        .mobile-nav{

            position:fixed;

            bottom:0;
            left:0;

            width:100%;

            background:white;

            padding:10px 0;

            box-shadow:0 -5px 20px rgba(0,0,0,.08);

            z-index:2000;
        }

        .mobile-nav a{

            display:flex;
            flex-direction:column;

            align-items:center;

            text-decoration:none;

            color:#777;

            font-size:12px;

            gap:4px;
        }

        .mobile-nav a i{
            font-size:20px;
        }

        .mobile-nav a.active{
            color:blueviolet;
        }

        /* MAIN */
        .main-content{
            margin-left:260px;
            padding:30px;
        }

        /* TOPBAR */
        .topbar{

            background:white;

            border-radius:20px;

            padding:20px 25px;

            box-shadow:0 5px 20px rgba(0,0,0,.05);

            margin-bottom:30px;
        }

        /* CARD */
        .settings-card{

            background:white;

            border-radius:24px;

            padding:25px;

            box-shadow:0 5px 20px rgba(0,0,0,.05);
        }

        /* INPUTS */
        .form-control,
        .form-select{

            border-radius:14px;

            padding:14px;

            background:#f8f9ff;

            border:1px solid #eee;
        }

        .form-control:focus,
        .form-select:focus{

            box-shadow:none;

            border-color:blueviolet;
        }

        /* BUTTON */
        .save-btn{

            background:linear-gradient(
                135deg,
                blueviolet,
                #4b49f5
            );

            border:none;

            padding:14px;

            border-radius:14px;

            color:white;

            font-weight:bold;

            transition:.3s ease;
        }

        .save-btn:hover{

            transform:translateY(-2px);

            opacity:.95;
        }

        /* SWITCH */
        .setting-item{

            padding:18px 0;

            border-bottom:1px solid #eee;
        }

        .setting-item:last-child{
            border-bottom:none;
        }
        .input-group-text{
            border-radius:12px 0 0 12px;
            border-color:#dee2e6;
        }

        .input-group .form-control{
            border-radius:0 12px 12px 0;
        }

        .card{
            transition:.3s ease;
        }

        .card:hover{
            transform:translateY(-2px);
            box-shadow:0 10px 30px rgba(0,0,0,.08);
        }

        .badge{
            font-size:.85rem;
            font-weight:600;
            letter-spacing:.3px;
        }

        .alert{
            border-radius:18px;
        }

        .btn-primary{
            background:linear-gradient(135deg,#5b21b6,#2563eb);
            border:none;
        }

        .btn-primary:hover{
            opacity:.95;
            transform:translateY(-1px);
        }

        /* MOBILE */
        @media(max-width:991px){

            body{
                padding-bottom:80px;
            }

            .main-content{
                margin-left:0;
                padding:20px;
            }
        }

    </style>

</head>
<body>

    <!-- DESKTOP SIDEBAR -->
    <div class="sidebar d-none d-lg-flex flex-column">

        <h4 class="mb-4 d-flex align-items-center logo mb-5 text-white fs-2 fw-bold">

            @if($setting && $setting->logo)

                <img src="{{ asset('storage/'.$setting->logo) }}"
                    width="40"
                    height="40"
                    class="rounded me-2">

            @else

                <i class="bi bi-grid me-2"></i>

            @endif

            {{ $setting->site_name ?? 'BillVexa' }}

        </h4>

        <a href={{ route('dashboard') }}>
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a href={{ route('service') }} >
            <i class="bi bi-gear"></i>
            Services
        </a>

        <a href={{ route('refer') }} >
            <i class="bi bi-people"></i>
            Refer & Earn
        </a>

        <a href={{ route('history') }} >
            <i class="bi bi-clock-history"></i>
            Transactions
        </a>


        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
        <i class="bi bi-person-lines-fill"></i>
        Profile
        </a>

    </div>


    <!-- MOBILE BOTTOM NAV -->
    <div class="mobile-nav d-flex d-lg-none justify-content-around align-items-center">

        <a href={{ route('dashboard') }} >
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>

        <a href={{ route('service') }}>
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>

        <a href={{ route('refer') }} >
            <i class="bi bi-people"></i>
            <small>Refer & Earn</small>
        </a>

        <a href={{ route('history') }} >
            <i class="bi bi-clock-history"></i>
            <small>History</small>
        </a>

        <a href={{ route('profile.edit') }} class="active">
            <i class="bi bi-person-lines-fill"></i>
            <small>Profile</small>
        </a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">

            <div>
                <h4 class="fw-bold mb-1">
                    Account Profile
                </h4>

                <small class="text-muted">
                    Manage your account preferences
                </small>
            </div>

            <div class="d-flex align-items-center gap-3">

                @php
                    $nameParts = preg_split('/\s+/', trim(auth()->user()->name));
                    $initials = '';

                    foreach (array_slice($nameParts, 0, 2) as $part) {
                        $initials .= strtoupper(substr($part, 0, 1));
                    }
                @endphp

                @if(auth()->user()->profile_photo)

                    <img
                        src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                        alt="{{ auth()->user()->name }}"
                        class="rounded-circle border border-2 border-primary"
                        width="45"
                        height="45"
                        style="object-fit:cover;"
                    >

                @else

                    <div
                        class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center"
                        style="width:45px; height:45px;"
                    >
                        {{ $initials }}
                    </div>

                @endif
            </div>

        </div>

        <div class="row g-4">

            <!-- PROFILE COLUMN -->
            <div class="col-lg-7">

                <div class="settings-card">

                    <!-- PROFILE -->
                    <div class="text-center mb-4">

                        @php
                            $nameParts = preg_split('/\s+/', trim(auth()->user()->name));
                            $initials = '';

                            foreach (array_slice($nameParts, 0, 2) as $part) {
                                $initials .= strtoupper(substr($part, 0, 1));
                            }
                        @endphp

                        @if(auth()->user()->profile_photo)

                            <img
                                id="previewImage"
                                src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                                alt="{{ auth()->user()->name }}"
                                class="rounded-circle border border-4 border-primary mb-0"
                                width="120"
                                height="120"
                                style="object-fit: cover;"
                            >

                        @else

                            <div
                                id="previewImage"
                                class="rounded-circle border border-4 border-primary bg-primary text-white fw-bold d-inline-flex align-items-center justify-content-center mb-0"
                                style="
                                    width:120px;
                                    height:120px;
                                    font-size:40px;
                                    line-height:1;
                                "
                            >
                                {{ $initials }}
                            </div>

                        @endif

                        <h4 class="fw-bold mt-3 mb-1">
                            {{ auth()->user()->name }}
                        </h4>

                        <small class="text-muted d-block mb-3">
                            {{ auth()->user()->email }}
                        </small>

                        <label
                            for="profile_photo"
                            class="btn btn-primary rounded-pill px-4"
                        >
                            <i class="fas fa-camera me-2"></i>
                            Change Photo
                        </label>

                    </div>
                    <hr>

                    <!-- STATS -->
                    <div class="row text-center mb-4">

                        <div class="col-4">
                            <a href="./index.php" class="nav-link">
                                <i class="fas fa-wallet fs-2 text-primary"></i>
                                <h6 class="fw-bold mt-2"> ₦{{ number_format(auth()->user()->wallet_balance ?? 0, 2) }}</h6>
                                <small class="text-muted">Wallet</small>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="./transactions.php" class="nav-link">
                                <i class="fas fa-arrow-right-arrow-left fs-2 text-success"></i>


                                <h6 class="fw-bold mt-2">{{ auth()->user()->transactions()->count() }}</h6>
                                <small class="text-muted">Transactions</small>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="" class="nav-link">
                                <i class="fas fa-shield-alt fs-2 text-warning"></i>
                                <h6 class="fw-bold mt-2">Verify</h6>
                                <small class="text-muted">NIN</small>
                            </a>
                        </div>    
                        <!-- ==========================================
                        IDENTITY VERIFICATION (KYC)
                        =========================================== -->
                        <div class="card border-0 shadow-sm rounded-4 mt-4">

                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <div>
                                        <h5 class="fw-bold mb-1">
                                            <i class="fas fa-id-card text-primary me-2"></i>
                                            Identity Verification
                                        </h5>

                                        <small class="text-muted">
                                            Verify your identity with your National Identification Number (NIN).
                                        </small>
                                    </div>

                                    @if(auth()->user()->kyc_verified)

                                        <span class="badge bg-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-check-circle me-1"></i>
                                            Verified
                                        </span>

                                    @else

                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">
                                            <i class="fas fa-clock me-1"></i>
                                            Pending
                                        </span>

                                    @endif

                                </div>

                                @if(auth()->user()->kyc_verified)

                                    <div class="alert alert-success border-0 rounded-4">

                                        <div class="d-flex align-items-center">

                                            <div class="me-3">

                                                <i class="fas fa-shield-check fa-2x text-success"></i>

                                            </div>

                                            <div>

                                                <h6 class="fw-bold mb-1">
                                                    Verification Successful
                                                </h6>

                                                <p class="mb-0 text-muted">
                                                    Your identity has been verified successfully.
                                                    You now have full access to all BillVexa services.
                                                </p>

                                            </div>

                                        </div>

                                    </div>

                                @else

                                <form action="{{ route('kyc.verify') }}" method="POST">

                                    @csrf

                                    <div class="mb-3">

                                        <label class="form-label fw-semibold">
                                            National Identification Number (NIN)
                                        </label>

                                        <div class="input-group">

                                            <span class="input-group-text bg-white">
                                                <i class="fas fa-id-card text-primary"></i>
                                            </span>

                                            <input
                                                type="text"
                                                name="nin"
                                                class="form-control"
                                                maxlength="11"
                                                minlength="11"
                                                pattern="[0-9]{11}"
                                                placeholder="Enter your 11-digit NIN"
                                                required>

                                        </div>

                                        <small class="text-muted">
                                            Your NIN is encrypted and securely stored. It is used only for identity verification.
                                        </small>

                                    </div>

                                    <div class="alert alert-light border rounded-4">

                                        <i class="fas fa-lock text-success me-2"></i>

                                        Your information is protected with bank-level encryption and is never shared with third parties.

                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-primary w-100 rounded-3 py-3 fw-bold">

                                        <i class="fas fa-shield-alt me-2"></i>

                                        Verify Identity

                                    </button>

                                </form>

                                @endif

                            </div>

                        </div>

                    </div>

                    <hr>

                    <!-- PERSONAL INFO -->
                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-person-fill me-2"></i>
                        Personal Information
                    </h5>

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <input
                        type="file"
                        id="profile_photo"
                        name="profile_photo"
                        class="d-none"
                        accept="image/*">

                        

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ old('name', auth()->user()->name) }}"
                                >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="text"
                                name="phone"
                                class="form-control"
                                value="{{ old('phone', auth()->user()->phone) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label">Email Address</label>
                                <input type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}">
                            </div>





                            <div class="col-12 mt-4">
                                <button class="save-btn w-100" name="submit">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    Save Changes
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- SECURITY COLUMN -->
            <div class="col-lg-5">

                <div class="settings-card">

                    <h5 class="fw-bold mb-4">
                        <i class="fas fa-lock me-2 text-primary"></i>
                        Security Settings
                    </h5>

                    <!-- CHANGE PASSWORD -->
                    <div class="border rounded-4 p-3 mb-3">

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">


                            <div class="mb-3 mb-md-0">
                                <h6 class="fw-bold mb-1">
                                    Change Password
                                </h6>

                                <small class="text-muted">
                                    Update your account password regularly
                                </small>
                            </div>

                            <button class="btn btn-outline-primary rounded-pill"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#passwordForm">

                                <i class="fas fa-key me-2"></i>
                                Update

                            </button>

                        </div>

                        <div class="collapse mt-4" id="passwordForm">


                            <form method="POST" action="{{ route('profile.password') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="password"
                                    name="current_password"

                                        class="form-control py-3"
                                        placeholder="Current Password">
                                </div>

                                <div class="mb-3">
                                    <input type="password"

                                        name="password"

                                        class="form-control py-3"
                                        placeholder="New Password">
                                </div>

                                <div class="mb-3">
                                    <input type="password"

                                    name="password_confirmation"

                                        class="form-control py-3"
                                        placeholder="Confirm Password">
                                </div>


                                <button type="submit" class="save-btn w-100">

                                    <i class="fas fa-save me-2"></i>
                                    Update Password
                                </button>

                            </form>

                        </div>

                    </div>

                    <!-- TWO FACTOR -->
                    <div class="border rounded-4 p-3 mb-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <h6 class="fw-bold mb-1">
                                    Two-Factor Authentication
                                </h6>

                                <small class="text-muted">
                                    Add extra security to your account
                                </small>
                            </div>


                            <form method="POST" action="{{ route('profile.twofactor') }}">
                            @csrf

                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="two_factor"
                                        id="twoFactor"
                                        onchange="this.form.submit()"
                                        {{ auth()->user()->two_factor_enabled ? 'checked' : '' }}>
                                </div>
                            </form>


                        </div>

                    </div>



                    <!-- ACTIVE DEVICES -->
                    <div class="border rounded-4 p-3">

                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center">

                            <div class="mb-3 mb-md-0">
                                <h6 class="fw-bold mb-1">
                                    Active Devices
                                </h6>

                                <small class="text-muted">
                                    View devices currently logged in
                                </small>
                            </div>

                            <a href="{{ route('profile.devices') }}" id="deviceBtn" class="btn btn-outline-primary rounded-pill">
                                <i class="fas fa-laptop me-2"></i>
                                View Devices
                            </a>


                        </div>

                    </div>

                    <!-- LOGOUT -->
                    <div class="border rounded-4 p-3 mt-4">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>
                                <h6 class="fw-bold mb-1 text-dark">
                                    Logout
                                </h6>

                                <small class="text-muted">
                                    Sign out from your BillVexa account.
                                </small>
                            </div>

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit" class="btn btn-outline-danger rounded-pill">
                                    <i class="fas fa-sign-out-alt me-2"></i>
                                    Logout
                                </button>
                            </form>

                        </div>

                    </div>



                    @if(session('success'))
                        <div class="alert text-success alert-dismissible fade show">

                        <i class="fas fa-check-circle me-2"></i>

                        {{ session('success') }}

                        <button
                            class="btn-close"
                            data-bs-dismiss="alert">
                        </button>

                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert text-danger alert-dismissible fade show">
                            <strong>
                                Please fix the following:
                            </strong>
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button
                                type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">
                            </button>
                        </div>
                    @endif


                </div>

            </div>

        </div>

    </div>

    <!-- TOAST CONTAINER -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="appToast" class="toast align-items-center text-white border-0"
            role="alert" aria-live="assertive" aria-atomic="true">

            <div class="d-flex">
                <div class="toast-body" id="toastMessage">
                    Message here
                </div>

                <button type="button"
                    class="btn-close btn-close-white me-2 m-auto"
                    data-bs-dismiss="toast">
                </button>
            </div>

        </div>
    </div>

    <script>

        /* =========================
        TOAST NOTIFICATION SYSTEM
        ========================= */
        function showToast(message, type = "primary") {
            const toastEl = document.getElementById("appToast");
            const toastBody = document.getElementById("toastMessage");

            // set message
            toastBody.innerText = message;

            // reset classes
            toastEl.className = "toast align-items-center text-white border-0";

            // set color
            toastEl.classList.add("bg-" + type);

            // show toast
            const toast = new bootstrap.Toast(toastEl);
            toast.show();
        }

        /* =========================
        PROFILE IMAGE PREVIEW
        ========================= */
        const fileInput = document.getElementById("profile_photo");
        const profileImg = document.getElementById("previewImage");

        if (fileInput) {
            fileInput.addEventListener("change", function () {

                if (this.files.length) {
                    profileImg.src = URL.createObjectURL(this.files[0]);
                }

            });
        }


        /* =========================
        SAVE PROFILE FORM
        ========================= */

        const profileForm = document.querySelector('form[action="{{ route("profile.update") }}"]');
        const saveBtn = profileForm.querySelector(".save-btn");

        profileForm.addEventListener("submit", function () {

            saveBtn.disabled = true;
            saveBtn.innerHTML = "Saving...";

        });


        /* =========================
        PASSWORD VALIDATION
        ========================= */
        const passwordForm = document.querySelector('form[action="{{ route("profile.password") }}"]');
        const updateBtn = passwordForm.querySelector(".save-btn");
        const inputs = passwordForm.querySelectorAll("input");

        updateBtn.addEventListener("click", function (e) {
           

            const current = inputs[0].value;
            const newPass = inputs[1].value;
            const confirm = inputs[2].value;

            if (!current || !newPass || !confirm) {
                showToast("All password fields are required!", "danger");
                return;
            }

            if (newPass.length < 6) {
                showToast("New password must be at least 6 characters!", "danger");
                return;
            }

            if (newPass !== confirm) {
                showToast("Passwords do not match!", "danger");
                return;
            }

            showToast("Password updated successfully!", "success");
        });


        /* =========================
        TWO FACTOR TOGGLE
        ========================= */
        const toggle = document.querySelector(".form-check-input");

        toggle.addEventListener("change", function () {
            showToast(
                this.checked ? "2FA Enabled 🔐" : "2FA Disabled ⚠️",
                this.checked ? "success" : "warning"
            );
        });


        /* =========================
        ACTIVE DEVICES BUTTON
        ========================= */

        const deviceBtn = document.getElementById("deviceBtn");

        if (deviceBtn) {
            deviceBtn.addEventListener("click", function () {
                showToast("Fetching active devices...", "info");
            });
        }
    </script>

</body>
</html>