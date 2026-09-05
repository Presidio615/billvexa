<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Education | {{ $setting->site_name ?? 'BillVexa' }}
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body {
            background: #f5f7fb;
            font-family: Inter, Arial, sans-serif;
        }

        /* SIDEBAR */

        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: linear-gradient(
                180deg,
                #5b21b6,
                #2563eb
            );
            padding: 25px 15px;
            z-index: 1000;
        }

        .logo {
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            color: rgba(255,255,255,.8);
            text-decoration: none;
            padding: 14px 16px;
            border-radius: 14px;
            margin-bottom: 10px;
            transition: .3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255,255,255,.15);
            color: white;
            transform: translateX(5px);
        }

        /* MAIN */

        .main {
            margin-left: 260px;
            padding: 25px 35px;
        }

        /* TOPBAR */

        .topbar {
            background: white;
            padding: 18px 25px;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,.05);
            margin-bottom: 30px;
        }

        /* EDUCATION CARDS */

        .education-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            height: 100%;
            border: 1px solid #edf0f5;
            transition: .2s;
            cursor: pointer;
        }

        .education-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,.07);
        }

        .service-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            background: #f0efff;
            color: #635bff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 25px;
            margin-bottom: 15px;
        }

        .education-card h6 {
            font-weight: 700;
            margin-bottom: 6px;
        }

        .education-card p {
            font-size: 13px;
            color: #8a94a6;
            margin-bottom: 15px;
        }

        .service-btn {
            color: #635bff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        /* SECTION */

        .section-title {
            font-weight: 750;
            margin-bottom: 18px;
        }

        /* QUICK ACTION */

        .quick-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #edf0f5;
        }

        .quick-action {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #344054;
            text-decoration: none;
            padding: 12px;
            border-radius: 10px;
            cursor: pointer;
        }

        .quick-action:hover {
            background: #f5f3ff;
            color: #635bff;
        }

        .quick-icon {
            width: 40px;
            height: 40px;
            background: #f0efff;
            color: #635bff;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* TRANSACTIONS */

        .transaction-card {
            background: white;
            border-radius: 16px;
            border: 1px solid #edf0f5;
            overflow: hidden;
        }

        .transaction-row {
            padding: 17px 20px;
            border-bottom: 1px solid #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .transaction-row:last-child {
            border-bottom: none;
        }

        .transaction-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: #f0efff;
            color: #635bff;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success {
            color: #16a34a;
            font-weight: 600;
        }

        .pending {
            color: #f59e0b;
            font-weight: 600;
        }
        

        /* =========================================================
   EDUCATION PLAN CUSTOM DROPDOWN
========================================================= */

.education-plan-select {
    position: relative;
    width: 100%;
}

.education-plan-button {
    width: 100%;
    min-height: 38px;

    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 6px;

    padding: 8px 12px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    text-align: left;

    color: #212529;
    font-size: 14px;

    cursor: pointer;

    transition: .15s ease;
}

.education-plan-button:hover {
    border-color: #86b7fe;
}

.education-plan-button:focus {
    outline: none;
    border-color: #86b7fe;
    box-shadow: 0 0 0 .2rem rgba(13,110,253,.15);
}

.education-plan-button i {
    flex-shrink: 0;
    margin-left: 10px;
}


/* DROPDOWN */

.education-plan-dropdown {
    position: absolute;

    top: calc(100% + 4px);
    left: 0;

    width: 100%;

    background: #fff;

    border: 1px solid #dee2e6;
    border-radius: 7px;

    box-shadow:
        0 5px 15px rgba(0,0,0,.12);

    max-height: 220px;

    overflow-y: auto;

    z-index: 1060;

    display: none;
}


/* SHOW */

.education-plan-dropdown.show {
    display: block;
}


/* OPTION */

.education-plan-option {
    padding: 10px 12px;

    font-size: 14px;

    color: #212529;

    cursor: pointer;

    border-bottom: 1px solid #f1f1f1;

    line-height: 1.4;

    word-break: break-word;
}

.education-plan-option:last-child {
    border-bottom: none;
}

.education-plan-option:hover {
    background: #f5f7ff;
}

.education-plan-option.active {
    background: #f0efff;
    color: #635bff;
}


/* MOBILE */

@media(max-width:576px) {

    .education-plan-dropdown {
        max-height: 200px;
    }

    .education-plan-option {
        padding: 11px 12px;
        font-size: 13px;
    }

}

        /* MOBILE NAV */

        .mobile-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: white;
            height: 65px;
            z-index: 2000;
            border-top: 1px solid #eee;
            justify-content: space-around;
            align-items: center;
        }

        .mobile-nav a {
            color: #8a94a6;
            text-decoration: none;
            font-size: 11px;
            text-align: center;
        }

        .mobile-nav a i {
            display: block;
            font-size: 20px;
            margin-bottom: 2px;
        }

        .mobile-nav a.active {
            color: #635bff;
        }

        /* RESPONSIVE */

        @media(max-width: 991px) {

            .sidebar {
                width: 70px;
                padding: 20px 10px;
            }

            .logo {
                font-size: 18px;
                text-align: center;
                padding: 0;
            }

            .brand-text,
            .nav-link span {
                display: none;
            }

            .sidebar a span {
                display: none;
            }

            .sidebar a {
                justify-content: center;
                padding: 14px 10px;
            }

            .main {
                margin-left: 70px;
                padding: 20px;
            }

        }

        @media(max-width: 576px) {

            .main {
                margin-left: 0;
                padding: 15px;
                padding-bottom: 80px;
            }

            .sidebar {
                display: none !important;
            }

            .topbar {
                margin-bottom: 20px;
            }

            .profile-name {
                display: none;
            }

            .mobile-nav {
                display: flex !important;
            }

        }

    </style>

</head>

<body>


<!-- =========================================================
     SIDEBAR
========================================================= -->

<div class="sidebar d-none d-lg-flex flex-column">

    <h4 class="logo mb-5 d-flex align-items-center text-white fs-2 fw-bold">

        @if($setting && $setting->logo)

            <img
                src="{{ asset('storage/' . $setting->logo) }}"
                width="40"
                height="40"
                class="rounded me-2"
                alt="{{ $setting->site_name ?? 'BillVexa' }}"
            >

        @else

            <i class="bi bi-grid me-2"></i>

        @endif

        {{ $setting->site_name ?? 'BillVexa' }}

    </h4>


    <a href="{{ route('dashboard') }}">

        <i class="bi bi-grid-fill"></i>

        <span>Dashboard</span>

    </a>


    <a href="{{ route('service') }}">

        <i class="bi bi-gear"></i>

        <span>Services</span>

    </a>


    <a href="{{ route('refer') }}">

        <i class="bi bi-people"></i>

        <span>Refer & Earn</span>

    </a>


    <a href="{{ route('history') }}">

        <i class="bi bi-clock-history"></i>

        <span>Transactions</span>

    </a>


    <a href="{{ route('profile.edit') }}">

        <i class="bi bi-person-lines-fill"></i>

        <span>Profile</span>

    </a>

</div>


<!-- =========================================================
     MAIN
========================================================= -->

<main class="main">


    <!-- TOPBAR -->

    <div class="topbar">

        <h4 class="mb-1">
            Education
        </h4>

        <small class="text-muted">
            Access educational services easily
        </small>

    </div>


    <!-- =====================================================
         QUICK ACTIONS
    ====================================================== -->

    <div class="row g-4 mb-4">

        <div class="col-lg-4">

            <div class="quick-card h-100">

                <h6 class="fw-bold mb-3">
                    Quick Actions
                </h6>


                <a
                    href="javascript:void(0)"
                    class="quick-action"
                    onclick="openEducation('jamb')"
                >

                    <div class="quick-icon">

                        <i class="bi bi-receipt"></i>

                    </div>

                    <div>

                        <strong>Buy PIN</strong>

                        <small class="d-block text-muted">
                            Get examination PIN
                        </small>

                    </div>

                </a>


                <a
                    href="javascript:void(0)"
                    class="quick-action"
                    onclick="openEducation('waec')"
                >

                    <div class="quick-icon">

                        <i class="bi bi-search"></i>

                    </div>

                    <div>

                        <strong>Check Result</strong>

                        <small class="d-block text-muted">
                            Check examination result
                        </small>

                    </div>

                </a>

            </div>

        </div>

    </div>


    <!-- =====================================================
         SERVICES
    ====================================================== -->

    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="section-title mb-0">
                Education Services
            </h5>

            <span class="text-muted small">
                {{ $setting->site_name ?? 'BillVexa' }} Education
            </span>

        </div>


        <div class="row g-3">


            <!-- JAMB -->

            <div class="col-6 col-md-4">

                <div
                    class="education-card"
                    onclick="openEducation('jamb')"
                >

                    <div class="service-icon">

                        <i class="bi bi-mortarboard"></i>

                    </div>

                    <h6>
                        JAMB
                    </h6>

                    <p>
                        Purchase JAMB examination PIN and services.
                    </p>

                    <span class="service-btn">

                        Continue
                        <i class="bi bi-arrow-right"></i>

                    </span>

                </div>

            </div>


            <!-- WAEC -->

            <div class="col-6 col-md-4">

                <div
                    class="education-card"
                    onclick="openEducation('waec')"
                >

                    <div class="service-icon">

                        <i class="bi bi-file-earmark-text"></i>

                    </div>

                    <h6>
                        WAEC
                    </h6>

                    <p>
                        Purchase WAEC result checker services.
                    </p>

                    <span class="service-btn">

                        Continue
                        <i class="bi bi-arrow-right"></i>

                    </span>

                </div>

            </div>


            <!-- WAEC REGISTRATION -->

            <div class="col-6 col-md-4">

                <div
                    class="education-card"
                    onclick="openEducation('waec-registration')"
                >

                    <div class="service-icon">

                        <i class="bi bi-pencil-square"></i>

                    </div>

                    <h6>
                        WAEC Registration
                    </h6>

                    <p>
                        Access available WAEC registration services.
                    </p>

                    <span class="service-btn">

                        Continue
                        <i class="bi bi-arrow-right"></i>

                    </span>

                </div>

            </div>


        </div>

    </div>


    <!-- =====================================================
         RECENT TRANSACTIONS
    ====================================================== -->

    <div class="mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="section-title mb-0">
                Recent Education Transactions
            </h5>

            <a
                href="{{ route('history') }}"
                class="text-decoration-none"
                style="color:#635bff;"
            >
                View All
            </a>

        </div>


        <div class="transaction-card">

            @forelse($transactions ?? [] as $transaction)

                <div class="transaction-row">

                    <div class="d-flex align-items-center gap-3">

                        <div class="transaction-icon">

                            <i class="bi bi-mortarboard"></i>

                        </div>

                        <div>

                            <strong>

                                {{ $transaction->service_name ?? $transaction->service_id }}

                            </strong>

                            <small class="d-block text-muted">

                                {{ $transaction->created_at?->format('d M, h:i A') }}

                            </small>

                        </div>

                    </div>


                    <div class="text-end">

                        <strong>

                            ₦{{ number_format($transaction->amount ?? 0, 2) }}

                        </strong>


                        @php

                            $status = strtolower(
                                $transaction->status ?? 'pending'
                            );

                        @endphp


                        <small class="d-block

                            {{ in_array($status, ['successful', 'success', 'completed'])
                                ? 'success'
                                : (in_array($status, ['processing', 'pending'])
                                    ? 'pending'
                                    : 'text-danger') }}"

                        >

                            {{ ucfirst($status) }}

                        </small>

                    </div>

                </div>

            @empty

                <div class="text-center p-4">

                    <i class="bi bi-receipt fs-2 text-muted"></i>

                    <p class="text-muted mt-2 mb-0">

                        No education transactions yet.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

</main>


<!-- =========================================================
     EDUCATION MODAL
========================================================= -->

<div
    class="modal fade"
    id="educationModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <h5
                    class="modal-title"
                    id="educationModalTitle"
                >
                    Education Service
                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                ></button>

            </div>


            <div class="modal-body">

                <!-- LOADING -->

                <div
                    id="educationLoading"
                    class="text-center py-4"
                >

                    <div
                        class="spinner-border text-primary"
                        role="status"
                    ></div>

                    <p class="text-muted mt-2 mb-0">
                        Loading available plans...
                    </p>

                </div>


                <!-- ERROR -->

                <div
                    id="educationError"
                    class="alert alert-danger d-none"
                ></div>


                <!-- FORM -->

                <form
                    id="educationForm"
                    class="d-none"
                >

                    <input
                        type="hidden"
                        id="educationServiceId"
                    >


                    <div class="mb-3">

                        <label class="form-label">
                            Select Plan
                        </label>

                        <div
                            class="education-plan-select"
                            id="educationPlanSelect"
                        >

                            <button
                                type="button"
                                class="education-plan-button"
                                id="educationVariationButton"
                            >
                                <span id="educationVariationText">
                                    Select a plan
                                </span>

                                <i class="bi bi-chevron-down"></i>
                            </button>


                            <div
                                class="education-plan-dropdown"
                                id="educationVariationDropdown"
                            ></div>

                        </div>

                    </div>

                    <!-- JAMB PROFILE -->

                    <div
                        class="mb-3 d-none"
                        id="jambProfileGroup"
                    >

                        <label
                            for="jambProfile"
                            class="form-label"
                        >
                            JAMB Profile ID
                        </label>

                        <input
                            type="text"
                            id="jambProfile"
                            class="form-control"
                            placeholder="Enter JAMB Profile ID"
                        >

                        <small class="text-muted">
                            Your JAMB profile will be verified before payment.
                        </small>

                    </div>


                    <!-- BILLER -->

                    <div class="mb-3">

                        <label
                            for="educationBiller"
                            class="form-label"
                        >
                            Reference / Candidate Number
                        </label>

                        <input
                            type="text"
                            id="educationBiller"
                            class="form-control"
                            placeholder="Enter required number"
                            required
                        >

                    </div>


                    <!-- PHONE -->

                    <div class="mb-3">

                        <label
                            for="educationPhone"
                            class="form-label"
                        >
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="educationPhone"
                            class="form-control"
                            placeholder="08012345678"
                            maxlength="11"
                            required
                        >

                    </div>


                    <!-- AMOUNT -->

                    <div
                        id="educationAmountContainer"
                        class="alert alert-light d-none"
                    >

                        <div class="d-flex justify-content-between">

                            <span>
                                Amount
                            </span>

                            <strong id="educationAmount">
                                ₦0.00
                            </strong>

                        </div>

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                        id="educationPurchaseButton"
                    >

                        Continue to Payment

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     MOBILE NAV
========================================================= -->

<div class="mobile-nav">

    <a href="{{ route('dashboard') }}">

        <i class="bi bi-grid-fill"></i>

        <small>
            Home
        </small>

    </a>


    <a href="{{ route('service') }}">

        <i class="bi bi-gear"></i>

        <small>
            Services
        </small>

    </a>


    <a href="{{ route('refer') }}">

        <i class="bi bi-people"></i>

        <small>
            Refer
        </small>

    </a>


    <a href="{{ route('history') }}">

        <i class="bi bi-clock-history"></i>

        <small>
            History
        </small>

    </a>


    <a href="{{ route('profile.edit') }}">

        <i class="bi bi-person-lines-fill"></i>

        <small>
            Profile
        </small>

    </a>

</div>


<!-- BOOTSTRAP JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<script>

let educationModal = null;
let currentEducationService = null;


/*
|--------------------------------------------------------------------------
| OPEN EDUCATION SERVICE
|--------------------------------------------------------------------------
*/

async function openEducation(serviceId)
{
    currentEducationService = serviceId;

    const modalElement =
        document.getElementById('educationModal');

    educationModal =
        bootstrap.Modal.getOrCreateInstance(modalElement);

    const title =
        document.getElementById('educationModalTitle');

    const loading =
        document.getElementById('educationLoading');

    const error =
        document.getElementById('educationError');

    const form =
        document.getElementById('educationForm');

    const variationButton =
       document.getElementById('educationVariationButton');

    const variationText =
        document.getElementById('educationVariationText');

    const variationDropdown =
        document.getElementById('educationVariationDropdown');

    const jambGroup =
        document.getElementById('jambProfileGroup');

    const amountContainer =
        document.getElementById('educationAmountContainer');

    const serviceIdInput =
        document.getElementById('educationServiceId');

    const billerInput =
        document.getElementById('educationBiller');


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    form.classList.add('d-none');

    loading.classList.remove('d-none');

    error.classList.add('d-none');

    jambGroup.classList.add('d-none');

    amountContainer.classList.add('d-none');

    variationText.textContent = 'Select a plan';

    variationDropdown.innerHTML = '';

    variationDropdown.classList.remove('show');

    variationButton.dataset.value = '';
    variationButton.dataset.amount = '';


    /*
    |--------------------------------------------------------------------------
    | SAVE SERVICE ID
    |--------------------------------------------------------------------------
    */

    serviceIdInput.value = serviceId;


    /*
    |--------------------------------------------------------------------------
    | SERVICE TITLE
    |--------------------------------------------------------------------------
    */

    const titles = {

        'jamb': 'JAMB',

        'waec': 'WAEC',

        'waec-registration': 'WAEC Registration'

    };

    title.textContent =
        titles[serviceId] ?? 'Education Service';


    /*
    |--------------------------------------------------------------------------
    | BILLER PLACEHOLDER
    |--------------------------------------------------------------------------
    */

    if (serviceId === 'jamb') {

        billerInput.placeholder =
            'Enter JAMB profile / candidate number';

    } else if (serviceId === 'waec') {

        billerInput.placeholder =
            'Enter WAEC candidate / reference number';

    } else if (serviceId === 'waec-registration') {

        billerInput.placeholder =
            'Enter registration reference';

    } else {

        billerInput.placeholder =
            'Enter required reference number';

    }


    /*
    |--------------------------------------------------------------------------
    | SHOW MODAL
    |--------------------------------------------------------------------------
    */

    educationModal.show();


    /*
    |--------------------------------------------------------------------------
    | LOAD EDUCATION PLANS
    |--------------------------------------------------------------------------
    */

    try {

        const response = await fetch(
            `/education/variations/${encodeURIComponent(serviceId)}`,
            {
                method: 'GET',

                headers: {
                    'Accept': 'application/json'
                }
            }
        );


        const data =
            await response.json();


        if (!response.ok || data.success === false) {

            throw new Error(
                data.message ||
                data.error ||
                'Unable to load education plans.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FIND VARIATIONS
        |--------------------------------------------------------------------------
        */

        const variations =
            data.content?.variations ??
            data.content ??
            [];


        if (
            !Array.isArray(variations) ||
            variations.length === 0
        ) {

            throw new Error(
                'No plans are currently available for this service.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | POPULATE PLANS
        |--------------------------------------------------------------------------
        */

variations.forEach(plan => {

    const code =
        plan.variation_code ??
        plan.variationCode ??
        '';

    const name =
        plan.name ??
        plan.variation_name ??
        plan.variationName ??
        'Education Plan';

    const price =
        Number(
            plan.variation_amount ??
            plan.amount ??
            0
        );


    if (!code) {
        return;
    }


    /*
    |----------------------------------------------------------
    | CREATE CUSTOM OPTION
    |----------------------------------------------------------
    */

    const option =
        document.createElement('div');

    option.className =
        'education-plan-option';


    /*
    |----------------------------------------------------------
    | DISPLAY TEXT
    |----------------------------------------------------------
    */

    const displayText =
        price > 0
            ? `${name} - ₦${price.toLocaleString(
                'en-NG',
                {
                    minimumFractionDigits: 2
                }
            )}`
            : name;


    option.textContent =
        displayText;


    /*
    |----------------------------------------------------------
    | STORE VALUES
    |----------------------------------------------------------
    */

    option.dataset.value =
        code;

    option.dataset.amount =
        price;


    /*
    |----------------------------------------------------------
    | SELECT PLAN
    |----------------------------------------------------------
    */

    option.addEventListener(
        'click',
        function ()
        {

            /*
            | Set selected value
            */

            variationButton.dataset.value =
                this.dataset.value;


            /*
            | Set amount
            */

            variationButton.dataset.amount =
                this.dataset.amount;


            /*
            | Display selected plan
            */

            variationText.textContent =
                this.textContent;


            /*
            | Highlight selected
            */

            document
                .querySelectorAll(
                    '.education-plan-option'
                )
                .forEach(item => {

                    item.classList.remove(
                        'active'
                    );

                });


            this.classList.add('active');


            /*
            | Close dropdown
            */

            variationDropdown.classList.remove(
                'show'
            );


            /*
            | Update amount
            */

            const amount =
                Number(
                    this.dataset.amount || 0
                );


            const container =
                document.getElementById(
                    'educationAmountContainer'
                );


            const amountElement =
                document.getElementById(
                    'educationAmount'
                );


            if (amount > 0) {

                amountElement.textContent =
                    `₦${amount.toLocaleString(
                        'en-NG',
                        {
                            minimumFractionDigits: 2
                        }
                    )}`;

                container.classList.remove(
                    'd-none'
                );

            } else {

                amountElement.textContent =
                    '₦0.00';

                container.classList.add(
                    'd-none'
                );

            }

        }
    );


    /*
    | Add option
    */

    variationDropdown.appendChild(
        option
    );

});


        /*
        |--------------------------------------------------------------------------
        | JAMB
        |--------------------------------------------------------------------------
        */

        if (serviceId === 'jamb') {

            jambGroup.classList.remove('d-none');

        }


        /*
        |--------------------------------------------------------------------------
        | SHOW FORM
        |--------------------------------------------------------------------------
        */

        loading.classList.add('d-none');

        form.classList.remove('d-none');


    } catch (error) {

        console.error(
            'Education variation error:',
            error
        );

        loading.classList.add('d-none');

        errorBox(
            error.message ||
            'Unable to load education plans.'
        );

    }

}


/*
|----------------------------------------------------------------------
| EDUCATION PLAN DROPDOWN
|----------------------------------------------------------------------
*/

const educationVariationButton =
    document.getElementById(
        'educationVariationButton'
    );

const educationVariationDropdown =
    document.getElementById(
        'educationVariationDropdown'
    );


educationVariationButton.addEventListener(
    'click',
    function (event)
    {

        event.stopPropagation();

        educationVariationDropdown.classList.toggle(
            'show'
        );

    }
);


/*
| Close when clicking outside
*/

document.addEventListener(
    'click',
    function (event)
    {

        const select =
            document.getElementById(
                'educationPlanSelect'
            );


        if (
            select &&
            !select.contains(event.target)
        ) {

            educationVariationDropdown.classList.remove(
                'show'
            );

        }

    }
);


/*
|--------------------------------------------------------------------------
| ERROR BOX
|--------------------------------------------------------------------------
*/

function errorBox(message)
{
    const error =
        document.getElementById('educationError');

    error.textContent =
        message ||
        'Something went wrong.';

    error.classList.remove('d-none');
}



/*
|--------------------------------------------------------------------------
| EDUCATION PURCHASE
|--------------------------------------------------------------------------
*/

document
    .getElementById('educationForm')
    .addEventListener(
        'submit',
        async function(event)
        {

            event.preventDefault();


            const button =
                document.getElementById(
                    'educationPurchaseButton'
                );


            const serviceId =
                document.getElementById(
                    'educationServiceId'
                ).value ||
                currentEducationService;


            const variationButton =
                document.getElementById(
                    'educationVariationButton'
                );


            const variationCode =
                variationButton.dataset.value || '';


            const billersCode =
                document.getElementById(
                    'educationBiller'
                ).value.trim();


            const phone =
                document.getElementById(
                    'educationPhone'
                ).value.trim();


            /*
            |--------------------------------------------------------------------------
            | VALIDATION
            |--------------------------------------------------------------------------
            */

            if (!serviceId) {

                alert(
                    'Invalid education service.'
                );

                return;

            }


            if (!variationCode) {

                alert(
                    'Please select a plan.'
                );

                return;

            }


            if (!billersCode) {

                alert(
                    'Please enter the required reference number.'
                );

                return;

            }


            if (!phone) {

                alert(
                    'Please enter your phone number.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | GET SELECTED AMOUNT
            |--------------------------------------------------------------------------
            */

            const amount =
                Number(
                    variationButton.dataset.amount || 0
                );


            if (amount <= 0) {

                alert(
                    'Invalid education plan amount.'
                );

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | DISABLE BUTTON
            |--------------------------------------------------------------------------
            */

            button.disabled = true;

            button.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm me-2"
                    role="status"
                    aria-hidden="true"
                ></span>
                Processing...
            `;


            /*
            |--------------------------------------------------------------------------
            | CSRF
            |--------------------------------------------------------------------------
            */

            const csrfToken =
                document
                    .querySelector(
                        'meta[name="csrf-token"]'
                    )
                    ?.getAttribute('content');


            if (!csrfToken) {

                alert(
                    'CSRF token is missing. Please refresh the page.'
                );

                button.disabled = false;

                button.innerHTML =
                    'Continue to Payment';

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | PURCHASE REQUEST
            |--------------------------------------------------------------------------
            */

            try {

                const response =
                    await fetch(
                        '/education/purchase',
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    csrfToken

                            },

                            body: JSON.stringify({

                                service_id:
                                    serviceId,

                                billers_code:
                                    billersCode,

                                variation_code:
                                    variationCode,

                                amount:
                                    amount,

                                phone:
                                    phone

                            })

                        }
                    );


                const data =
                    await response.json();


                /*
                |--------------------------------------------------------------------------
                | PENDING
                |--------------------------------------------------------------------------
                */

                if (
                    response.status === 202 &&
                    data.status === 'pending'
                ) {

                    alert(
                        data.message ||
                        'Your transaction is being processed. Please check your transaction history shortly.'
                    );

                    educationModal.hide();

                    window.location.reload();

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | FAILED
                |--------------------------------------------------------------------------
                */

                if (!response.ok) {

                    throw new Error(
                        data.message ||
                        data.error ||
                        'Education purchase failed.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | SUCCESS
                |--------------------------------------------------------------------------
                */

                if (data.success) {

                    alert(
                        data.message ||
                        'Education service purchased successfully.'
                    );

                    educationModal.hide();

                    window.location.reload();

                    return;

                }


                throw new Error(
                    data.message ||
                    'Education purchase failed.'
                );


            } catch (error) {

                console.error(
                    'Education purchase error:',
                    error
                );


                alert(
                    error.message ||
                    'Unable to complete purchase.'
                );

            } finally {

                button.disabled = false;

                button.innerHTML =
                    'Continue to Payment';

            }

        }
    );

</script>

</body>
</html>

