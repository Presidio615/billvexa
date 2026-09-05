<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
    content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} Cable TV Dashboard
    </title>

    <!-- icon image -->
    <link rel="shortcut icon" 
    href="../../../Assets/Image/icon.png" type="image/x-icon">

    <!-- Bootstrap -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>

    *{
        margin:0;
        padding:0;
        box-sizing:border-box;
    }

    body{
        background:#f4f7ff;
        font-family:Arial, Helvetica, sans-serif;
        overflow-x:hidden;
    }

    /* SIDEBAR */
    .sidebar{

        width:260px;
        height:100vh;

        position:fixed;
        top:0;
        left:0;

        background:linear-gradient(
            180deg,
            #7c3aed,
            #2563eb
        );

        padding:25px 15px;

        z-index:1000;
    }

    .logo{

        color:white;

        font-size:28px;
        font-weight:bold;

        margin-bottom:40px;
    }

    .sidebar a{

        display:flex;
        align-items:center;
        gap:12px;

        color:rgba(255,255,255,.8);

        text-decoration:none;

        padding:14px 16px;

        border-radius:14px;

        margin-bottom:10px;

        transition:.3s ease;
    }

    .sidebar a:hover,
    .sidebar a.active{

        background:rgba(255,255,255,.15);

        color:white;

        transform:translateX(5px);
    }

    /* MAIN */
    .main-content{

        margin-left:260px;

        padding:30px;
    }

    /* TOPBAR */
    .topbar{

        background:white;

        padding:18px 25px;

        border-radius:20px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);

        margin-bottom:30px;
    }

    /* HERO CARD */
    .tv-card{

        background:linear-gradient(
            180deg,
            #5b21b6,
            #2563eb
        );

        color:white;

        border-radius:30px;

        padding:35px;

        position:relative;

        overflow:hidden;

        box-shadow:0 15px 40px rgba(0,0,0,.08);
    }

    .tv-card::before{

        content:"";

        position:absolute;

        width:260px;
        height:260px;

        border-radius:50%;

        background:rgba(255,255,255,.1);

        top:-100px;
        right:-80px;
    }

    .tv-card h1{

        font-size:3rem;
        font-weight:bold;
    }

    /* CUSTOM CARD */
    .custom-card{

        background:white;

        border-radius:22px;

        padding:25px;

        box-shadow:0 5px 20px rgba(0,0,0,.05);
    }

    /* PROVIDER CARD */
    .provider-card{

        border:1px solid #e5e7eb;

        border-radius:18px;

        padding:20px;

        text-align:center;

        transition:.3s ease;

        cursor:pointer;
    }

    .provider-card:hover{

        border-color: #7c3aed;

        background: #f6f0ff;

        transform:translateY(-5px);
    }

    .provider-card.clicked{

        background-color: #f6f0ff;

        border-color: #7c3aed;

        transform:translateY(-5px);
    }  

    /* PLAN CARD */
    .plan-card{

        border:1px solid #e5e7eb;

        border-radius:18px;

        padding:18px;

        transition:.3s ease;

        cursor:pointer;
    }

    .plan-card:hover{

        border-color:#7c3aed;

        background:#f8f5ff;

        transform:translateY(-5px);
    }

    .plan-card.clicked {
    background: #f6f0ff;
    border-color: #7c3aed;
    transform: translateY(-5px);
}

.provider-card.clicked {
    background: #f6f0ff;
    border-color: #7c3aed;
    transform: translateY(-5px);
}

#verifyMessage {
    font-size: 14px;
    font-weight: 600;
}

#customerBox {
    animation: fadeIn .25s ease;
}

#selectedPlanBox {
    animation: fadeIn .25s ease;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

    /* FORM */
    .form-control,
    .form-select{

        border-radius:14px;

        padding:14px;

        border:1px solid #dbe1ea;
    }

    .form-control:focus,
    .form-select:focus{

        box-shadow:none;

        border-color:#7c3aed;
    }

    /* BUTTON */
    .subscribe-btn{

        background:linear-gradient(
            135deg,
            #7c3aed,
            #2563eb
        );

        border:none;

        border-radius:14px;

        padding:15px;

        color:white;

        font-weight:bold;

        transition:.3s ease;
    }

    .subscribe-btn:hover{

        transform:translateY(-3px);

        opacity:.95;
    }

    /* TRANSACTIONS */
    .transaction-item{

        padding:16px 0;

        border-bottom:1px solid #f0f0f0;
    }

    .transaction-item:last-child{
        border-bottom:none;
    }

    /* MOBILE NAV */
    .mobile-nav{
        display:none;
    }

    /* MOBILE */
    @media(max-width:992px){

        .sidebar{
            display:none;
        }

        .main-content{

            margin-left:0;

            padding:20px;

            padding-bottom:100px;
        }

        .tv-card h1{
            font-size:2rem;
        }

        .mobile-nav{

            display:flex;

            justify-content:space-around;
            align-items:center;

            position:fixed;

            bottom:0;
            left:0;

            width:100%;

            background:white;

            padding:12px 5px;

            box-shadow:0 -5px 20px rgba(0,0,0,.08);

            z-index:2000;
        }

        .mobile-nav a{

            text-decoration:none;

            color:#666;

            font-size:13px;

            display:flex;
            flex-direction:column;
            align-items:center;

            gap:4px;
        }

        .mobile-nav a.active{
            color:#7c3aed;
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

        <a href={{ route('profile.edit') }} >
            <i class="bi bi-person-lines-fill"></i>
            Profile
        </a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">

            <div>

                <h4 class="fw-bold mb-1">
                    Cable TV 
                </h4>

                <small class="text-muted">
                    Renew and manage your TV subscriptions
                </small>

            </div>

        </div>

        <div class="row g-4">

            <!-- LEFT -->
            <div class="col-lg-8">

                <!-- SUBSCRIBE -->
                <div class="custom-card">

                    <h4 class="fw-bold mb-4">
                        Subscribe Cable TV
                    </h4>

                    <form id="cableTvForm">

                        @csrf

                        <!-- PROVIDER -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select TV Provider
                            </label>

                            <div class="row g-3">

                                <!-- DSTV -->
                                <div class="col-md-4">

                                    <div
                                        class="provider-card"
                                        data-provider="dstv"
                                    >

                                        <i class="fa-solid fa-tv fs-2 text-primary mb-2"></i>

                                        <h6 class="fw-bold mb-0">
                                            DStv
                                        </h6>

                                    </div>

                                </div>

                                <!-- GOTV -->
                                <div class="col-md-4">

                                    <div
                                        class="provider-card"
                                        data-provider="gotv"
                                    >

                                        <i class="fa-solid fa-satellite-dish fs-2 text-danger mb-2"></i>

                                        <h6 class="fw-bold mb-0">
                                            GOtv
                                        </h6>

                                    </div>

                                </div>

                                <!-- STARTIMES -->
                                <div class="col-md-4">

                                    <div
                                        class="provider-card"
                                        data-provider="startimes"
                                    >

                                        <i class="fa-solid fa-display fs-2 text-success mb-2"></i>

                                        <h6 class="fw-bold mb-0">
                                            Startimes
                                        </h6>

                                    </div>

                                </div>

                            </div>

                            <input
                                type="hidden"
                                id="provider"
                                name="provider"
                            >

                        </div>


                        <!-- SMART CARD -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Smart Card / IUC Number
                            </label>

                            <div class="input-group">

                                <input
                                    type="text"
                                    id="smart_card"
                                    name="smart_card"
                                    class="form-control"
                                    placeholder="Enter smart card number"
                                    autocomplete="off"
                                >

                                <button
                                    type="button"
                                    id="verifyCustomerBtn"
                                    class="btn btn-outline-primary"
                                >
                                    Verify
                                </button>

                            </div>

                            <small
                                id="verifyMessage"
                                class="d-block mt-2"
                            ></small>

                        </div>


                        <!-- CUSTOMER NAME -->
                        <div
                            class="mb-4"
                            id="customerBox"
                            style="display:none;"
                        >

                            <label class="form-label fw-semibold">
                                Customer Name
                            </label>

                            <input
                                type="text"
                                id="customer_name"
                                class="form-control"
                                readonly
                            >

                            <div class="mt-2">

                                <small
                                    class="text-muted"
                                    id="customerDetails"
                                ></small>

                            </div>

                        </div>


                        <!-- PLANS -->
                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Select Subscription Plan
                            </label>

                            <div
                                id="plansContainer"
                                class="row g-3"
                            >

                                <div class="col-12">

                                    <div class="alert alert-light border">

                                        Select a provider to load
                                        available subscription plans.

                                    </div>

                                </div>

                            </div>

                        </div>


                        <!-- SELECTED PLAN -->
                        <input
                            type="hidden"
                            id="variation_code"
                            name="variation_code"
                        >

                        <input
                            type="hidden"
                            id="variation_name"
                            name="variation_name"
                        >

                        <input
                            type="hidden"
                            id="amount"
                            name="amount"
                        >


                        <!-- SELECTED PLAN DISPLAY -->
                        <div
                            id="selectedPlanBox"
                            class="alert alert-primary"
                            style="display:none;"
                        >

                            <div class="d-flex justify-content-between">

                                <span>
                                    Selected Plan
                                </span>

                                <strong id="selectedPlanName">
                                </strong>

                            </div>

                            <div class="d-flex justify-content-between mt-2">

                                <span>
                                    Amount
                                </span>

                                <strong id="selectedPlanAmount">
                                </strong>

                            </div>

                        </div>


                        <!-- WALLET -->
                        <div class="alert alert-light border">

                            <div class="d-flex justify-content-between">

                                <span>
                                    Wallet Balance
                                </span>

                                <strong>
                                    ₦{{ number_format(auth()->user()->wallet_balance, 2) }}
                                </strong>

                            </div>

                        </div>


                        <!-- BUTTON -->
                        <button
                            type="submit"
                            id="subscribeBtn"
                            class="subscribe-btn w-100"
                            disabled
                        >

                            <i class="fa-solid fa-circle-check me-2"></i>

                            Subscribe Now

                        </button>

                    </form>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <!-- INFO -->
                <div class="custom-card">

                    <div class="d-flex justify-content-between mb-4">

                        <h5 class="fw-bold mb-0">
                            Recent Subscriptions
                        </h5>

                        <a
                            href="{{ route('history') }}"
                            class="text-decoration-none"
                        >
                            View all
                        </a>

                    </div>


                    @forelse($transactions as $transaction)

                        <div class="transaction-item d-flex justify-content-between">

                            <div>

                                <h6 class="mb-1">

                                    {{ $transaction->variation_name
                                        ?? strtoupper($transaction->provider) }}

                                </h6>

                                <small class="text-muted">

                                    {{ strtoupper($transaction->provider) }}

                                    •
                                    
                                    {{ $transaction->smart_card }}

                                    <br>

                                    {{ $transaction->created_at->format('d M Y • h:i A') }}

                                </small>

                            </div>


                            <div class="text-end">

                                <strong
                                    class="
                                    {{ $transaction->status === 'delivered'
                                        ? 'text-success'
                                        : ($transaction->status === 'refunded'
                                            ? 'text-danger'
                                            : 'text-warning') }}
                                    "
                                >

                                    ₦{{ number_format($transaction->amount, 2) }}

                                </strong>

                                <br>

                                <small>

                                    {{ ucfirst($transaction->status) }}

                                </small>

                            </div>

                        </div>

                    @empty

                        <div class="text-center py-4">

                            <i class="fa-solid fa-tv fs-1 text-muted mb-3"></i>

                            <p class="text-muted mb-0">
                                No cable TV subscriptions yet.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>
    
    <!-- MOBILE BOTTOM NAV -->
    <div class="mobile-nav d-flex d-lg-none justify-content-around align-items-center">

        <a href={{ route('dashboard') }}>
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>

        <a href={{ route('service') }} >
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
        <a href={{ route('profile.edit') }} >
            <i class="bi bi-person-lines-fill"></i>
            <small>Profile</small>
        </a>
    </div>



    <script>

document.addEventListener('DOMContentLoaded', function () {

    const providerCards =
        document.querySelectorAll('.provider-card');

    const providerInput =
        document.getElementById('provider');

    const smartCardInput =
        document.getElementById('smart_card');

    const verifyBtn =
        document.getElementById('verifyCustomerBtn');

    const verifyMessage =
        document.getElementById('verifyMessage');

    const customerBox =
        document.getElementById('customerBox');

    const customerName =
        document.getElementById('customer_name');

    const customerDetails =
        document.getElementById('customerDetails');

    const plansContainer =
        document.getElementById('plansContainer');

    const variationCode =
        document.getElementById('variation_code');

    const variationName =
        document.getElementById('variation_name');

    const amountInput =
        document.getElementById('amount');

    const selectedPlanBox =
        document.getElementById('selectedPlanBox');

    const selectedPlanName =
        document.getElementById('selectedPlanName');

    const selectedPlanAmount =
        document.getElementById('selectedPlanAmount');

    const subscribeBtn =
        document.getElementById('subscribeBtn');

    const form =
        document.getElementById('cableTvForm');


    let selectedProvider = null;

    let customerVerified = false;


    /*
    |--------------------------------------------------------------------------
    | PROVIDER SELECTION
    |--------------------------------------------------------------------------
    */

    providerCards.forEach(card => {

        card.addEventListener('click', function () {

            providerCards.forEach(item => {
                item.classList.remove('clicked');
            });

            this.classList.add('clicked');

            selectedProvider =
                this.dataset.provider;

            providerInput.value =
                selectedProvider;

            /*
             * Reset customer.
             */
            customerVerified = false;

            customerBox.style.display =
                'none';

            customerName.value = '';

            customerDetails.textContent = '';

            variationCode.value = '';

            variationName.value = '';

            amountInput.value = '';

            selectedPlanBox.style.display =
                'none';

            subscribeBtn.disabled = true;

            /*
             * Load plans.
             */
            loadPlans(selectedProvider);

        });

    });


    /*
    |--------------------------------------------------------------------------
    | LOAD PLANS
    |--------------------------------------------------------------------------
    */

    async function loadPlans(provider) {

plansContainer.innerHTML = `
    <div class="col-12 text-center py-4">
        <div
            class="spinner-border text-primary"
            role="status"
        ></div>

        <p class="text-muted mt-2">
            Loading plans...
        </p>
    </div>
`;

try {

    const response = await fetch(
        `{{ route('cable.tv.plans') }}?provider=${encodeURIComponent(provider)}`,
        {
            method: 'GET',

            headers: {
                'Accept': 'application/json'
            }
        }
    );

    const data = await response.json();

    if (!response.ok || !data.success) {
        throw new Error(
            data.message || 'Unable to load plans.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | GET PLANS
    |--------------------------------------------------------------------------
    |
    | Laravel may return the plans directly as an array,
    | or VTpass may return them inside content.variations.
    |
    */

    let plans = [];

    if (Array.isArray(data.plans)) {

        plans = data.plans;

    } else if (
        data.plans &&
        Array.isArray(data.plans.content?.variations)
    ) {

        plans = data.plans.content.variations;

    } else if (
        data.plans &&
        Array.isArray(data.plans.variations)
    ) {

        plans = data.plans.variations;

    } else if (
        Array.isArray(data.content?.variations)
    ) {

        plans = data.content.variations;
    }

    renderPlans(plans);

} catch (error) {

    console.error('Cable TV plans error:', error);

    plansContainer.innerHTML = `
        <div class="col-12">
            <div class="alert alert-danger">
                ${escapeHtml(error.message)}
            </div>
        </div>
    `;
}
}

    /*
    |--------------------------------------------------------------------------
    | DISPLAY PLANS
    |--------------------------------------------------------------------------
    */
    function renderPlans(plans) {

    /*
    |--------------------------------------------------------------------------
    | MAKE SURE PLANS IS AN ARRAY
    |--------------------------------------------------------------------------
    */

    if (!Array.isArray(plans)) {

        console.error('Invalid plans received:', plans);

        plansContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    Unable to load subscription plans.
                    Invalid plan data was returned.
                </div>
            </div>
        `;

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | NO PLANS
    |--------------------------------------------------------------------------
    */

    if (plans.length === 0) {

        plansContainer.innerHTML = `
            <div class="col-12">
                <div class="alert alert-warning">
                    No plans are currently available.
                </div>
            </div>
        `;

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | DISPLAY PLANS
    |--------------------------------------------------------------------------
    */

    plansContainer.innerHTML = plans.map(plan => {

        const code =
            plan.variation_code || '';

        const name =
            plan.name ||
            plan.variation_name ||
            'Subscription Plan';

        const price =
            parseFloat(
                plan.variation_amount || 0
            );

        return `
            <div class="col-md-4">

                <div
                    class="plan-card"
                    data-code="${escapeHtml(code)}"
                    data-name="${escapeHtml(name)}"
                    data-amount="${price}"
                >

                    <h6 class="fw-bold">
                        ${escapeHtml(name)}
                    </h6>

                    <small class="text-muted">
                        Cable TV Subscription
                    </small>

                    <h5 class="fw-bold mt-3 text-primary">
                        ₦${price.toLocaleString(
                            'en-NG',
                            {
                                minimumFractionDigits: 2
                            }
                        )}
                    </h5>

                </div>

            </div>
        `;

    }).join('');

    /*
    |--------------------------------------------------------------------------
    | PLAN CLICK EVENTS
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll('.plan-card')
        .forEach(card => {

            card.addEventListener(
                'click',
                function () {

                    document
                        .querySelectorAll('.plan-card')
                        .forEach(item => {
                            item.classList.remove(
                                'clicked'
                            );
                        });

                    this.classList.add(
                        'clicked'
                    );

                    const code =
                        this.dataset.code;

                    const name =
                        this.dataset.name;

                    const amount =
                        parseFloat(
                            this.dataset.amount
                        );

                    variationCode.value =
                        code;

                    variationName.value =
                        name;

                    amountInput.value =
                        amount;

                    selectedPlanName.textContent =
                        name;

                    selectedPlanAmount.textContent =
                        '₦' +
                        amount.toLocaleString(
                            'en-NG',
                            {
                                minimumFractionDigits: 2
                            }
                        );

                    selectedPlanBox.style.display =
                        'block';

                    updateSubscribeButton();
                }
            );

        });
}


    /*
    |--------------------------------------------------------------------------
    | VERIFY CUSTOMER
    |--------------------------------------------------------------------------
    */

    verifyBtn.addEventListener(
        'click',
        verifyCustomer
    );


    async function verifyCustomer() {

        const provider =
            providerInput.value;

        const smartCard =
            smartCardInput.value.trim();


        if (!provider) {

            showVerifyMessage(
                'Please select a TV provider.',
                'danger'
            );

            return;
        }


        if (!smartCard) {

            showVerifyMessage(
                'Enter your Smart Card / IUC number.',
                'danger'
            );

            return;
        }


        verifyBtn.disabled = true;

        verifyBtn.innerHTML = `

            <span
                class="spinner-border spinner-border-sm"
            ></span>

            Verifying...

        `;


        try {

            const response =
                await fetch(
                    '{{ route('cable.tv.verify') }}',
                    {

                        method: 'POST',

                        headers: {

                            'Content-Type':
                                'application/json',

                            'Accept':
                                'application/json',

                            'X-CSRF-TOKEN':
                                document
                                .querySelector(
                                    'input[name="_token"]'
                                )
                                .value

                        },

                        body: JSON.stringify({

                            provider:
                                provider,

                            smart_card:
                                smartCard

                        })

                    }
                );


            const data =
                await response.json();


            if (!response.ok || !data.success) {

                throw new Error(
                    data.message
                    || 'Unable to verify customer.'
                );

            }


            customerVerified = true;


            const customer =
                data.customer;


            customerName.value =
                customer.name
                || 'Customer verified';


            customerBox.style.display =
                'block';


            let details = '';


            if (customer.status) {

                details +=
                    `Status: ${customer.status}`;

            }


            if (customer.current_bouquet) {

                details +=
                    ` • Current package: ${customer.current_bouquet}`;

            }


            if (customer.due_date) {

                details +=
                    ` • Due: ${customer.due_date}`;

            }


            customerDetails.textContent =
                details;


            showVerifyMessage(
                'Customer verified successfully.',
                'success'
            );


            updateSubscribeButton();


        } catch (error) {

            customerVerified = false;

            customerBox.style.display =
                'none';

            showVerifyMessage(
                error.message,
                'danger'
            );

            updateSubscribeButton();

        } finally {

            verifyBtn.disabled = false;

            verifyBtn.textContent =
                'Verify';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | SUBSCRIBE
    |--------------------------------------------------------------------------
    */

    form.addEventListener(
        'submit',
        async function (event) {

            event.preventDefault();


            if (!customerVerified) {

                alert(
                    'Please verify your Smart Card number first.'
                );

                return;

            }


            if (!variationCode.value) {

                alert(
                    'Please select a subscription plan.'
                );

                return;

            }


            const amount =
                parseFloat(
                    amountInput.value
                );


            if (!amount || amount <= 0) {

                alert(
                    'Invalid subscription amount.'
                );

                return;

            }


            const confirmed =
                confirm(
                    `Subscribe ${customerName.value} for ₦${amount.toLocaleString('en-NG', {
                        minimumFractionDigits: 2
                    })}?`
                );


            if (!confirmed) {
                return;
            }


            subscribeBtn.disabled =
                true;


            subscribeBtn.innerHTML = `

                <span
                    class="spinner-border spinner-border-sm me-2"
                ></span>

                Processing...

            `;


            try {

                const response =
                    await fetch(
                        '{{ route('cable.tv.purchase') }}',
                        {

                            method: 'POST',

                            headers: {

                                'Content-Type':
                                    'application/json',

                                'Accept':
                                    'application/json',

                                'X-CSRF-TOKEN':
                                    document
                                    .querySelector(
                                        'input[name="_token"]'
                                    )
                                    .value

                            },

                            body: JSON.stringify({

                                provider:
                                    providerInput.value,

                                smart_card:
                                    smartCardInput.value.trim(),

                                variation_code:
                                    variationCode.value,

                                variation_name:
                                    variationName.value,

                                amount:
                                    amountInput.value

                            })

                        }
                    );


                const data =
                    await response.json();


                if (!response.ok || !data.success) {

                    throw new Error(
                        data.message
                        || 'Transaction failed.'
                    );

                }


                if (
                    data.status ===
                    'pending'
                ) {

                    alert(
                        data.message
                        + '\nReference: '
                        + (
                            data.reference
                            || ''
                        )
                    );

                    window.location.reload();

                    return;

                }


                alert(
                    'Cable TV subscription successful!'
                    + '\n\n'
                    + 'Customer: '
                    + (
                        customerName.value
                        || ''
                    )
                    + '\n'
                    + 'Plan: '
                    + (
                        data.transaction?.plan
                        || ''
                    )
                    + '\n'
                    + 'Amount: ₦'
                    + (
                        data.transaction?.amount
                        || ''
                    )
                    + '\n'
                    + 'Reference: '
                    + (
                        data.transaction?.reference
                        || ''
                    )
                );


                window.location.reload();


            } catch (error) {

                alert(
                    error.message
                );


                subscribeBtn.disabled =
                    false;

                subscribeBtn.innerHTML = `

                    <i
                        class="fa-solid fa-circle-check me-2"
                    ></i>

                    Subscribe Now

                `;

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | BUTTON STATE
    |--------------------------------------------------------------------------
    */

    function updateSubscribeButton() {

        subscribeBtn.disabled =
            !customerVerified
            ||
            !variationCode.value;

    }


    /*
    |--------------------------------------------------------------------------
    | VERIFY MESSAGE
    |--------------------------------------------------------------------------
    */

    function showVerifyMessage(
        message,
        type
    ) {

        verifyMessage.className =
            `d-block mt-2 text-${type}`;

        verifyMessage.textContent =
            message;

    }


    /*
    |--------------------------------------------------------------------------
    | HTML ESCAPE
    |--------------------------------------------------------------------------
    */

    function escapeHtml(value) {

        return String(value)
            .replace(
                /&/g,
                '&amp;'
            )
            .replace(
                /</g,
                '&lt;'
            )
            .replace(
                />/g,
                '&gt;'
            )
            .replace(
                /"/g,
                '&quot;'
            )
            .replace(
                /'/g,
                '&#039;'
            );

    }

});

</script>


</body>
</html>