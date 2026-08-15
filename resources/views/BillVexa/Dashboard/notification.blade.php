<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notifications | BillVexa</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>
        body {
            background: #f5f7fb;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        /* =========================
           SIDEBAR
        ========================== */

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
            border-radius:12px;

            margin-bottom:10px;

            transition:.3s ease;
        }

        .sidebar a:hover,
        .sidebar a.active{

            background:rgba(255,255,255,.15);

            transform:translateX(5px);
        }

        /* =========================
         MOBILE BOTTOM NAV 
        ========================== */
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
            justify-content:center;

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

        /* =========================
           MAIN
        ========================== */
        .main-content {
            margin-left: 260px;
            /* min-height: 100vh; */
            transition: all .3s ease;
        }

        /* =========================
           NAVBAR
        ========================== */
        .top-navbar {
            height: 70px;
            background: white;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 25px;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .menu-btn {
            border: none;
            background: transparent;
            font-size: 25px;
            display: none;
        }

        .notification-btn {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: none;
            background: #f1f5ff;
            color: #0d6efd;
            position: relative;
        }

        .notification-count {
            position: absolute;
            top: -2px;
            right: -2px;
            background: #dc3545;
            color: white;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 2px solid white;
        }

        /* =========================
           PROFILE
        ========================== */
        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #0d6efd;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* =========================
           PAGE
        ========================== */
        .page-content {
            padding: 30px;
        }

        .page-title {
            font-weight: 700;
            color: #212529;
        }

        .breadcrumb-item a {
            text-decoration: none;
        }

        /* =========================
           NOTIFICATION CARD
        ========================== */
        .notification-container {
            background: white;
            border-radius: 16px;
            border: 1px solid #e9ecef;
            overflow: hidden;
        }

        .notification-header {
            padding: 22px 25px;
            border-bottom: 1px solid #e9ecef;
        }

        .notification-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px 25px;
            border-bottom: 1px solid #edf0f4;
            transition: .2s;
            position: relative;
        }

        .notification-item:hover {
            background: #f8faff;
        }

        .notification-item.unread {
            background: #f1f6ff;
        }

        .notification-item.unread::before {
            content: "";
            width: 4px;
            height: 100%;
            background: #0d6efd;
            position: absolute;
            left: 0;
            top: 0;
        }

        .notification-icon {
            min-width: 48px;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 21px;
        }

        .icon-success {
            background: #d1e7dd;
            color: #198754;
        }

        .icon-info {
            background: #cff4fc;
            color: #0dcaf0;
        }

        .icon-warning {
            background: #fff3cd;
            color: #ffc107;
        }

        .icon-danger {
            background: #f8d7da;
            color: #dc3545;
        }

        .icon-primary {
            background: #cfe2ff;
            color: #0d6efd;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .notification-message {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 7px;
        }

        .notification-time {
            color: #9aa1a9;
            font-size: 12px;
        }

        .unread-dot {
            width: 9px;
            height: 9px;
            background: #0d6efd;
            border-radius: 50%;
            display: inline-block;
            margin-left: 5px;
        }

        /* =========================
           DROPDOWN
        ========================== */
        .notification-dropdown {
            width: 380px;
            max-width: calc(100vw - 30px);
            padding: 0;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,.12);
            border-radius: 14px;
            overflow: hidden;
        }

        .dropdown-header-custom {
            padding: 18px;
            background: white;
            border-bottom: 1px solid #eee;
        }

        .dropdown-notification {
            padding: 14px 18px;
            display: flex;
            gap: 12px;
            text-decoration: none;
            color: #212529;
            border-bottom: 1px solid #f0f0f0;
        }

        .dropdown-notification:hover {
            background: #f8f9fa;
        }

        .dropdown-icon {
            min-width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .dropdown-text {
            font-size: 13px;
        }

        .dropdown-text strong {
            display: block;
            font-size: 14px;
        }

        .dropdown-text small {
            color: #999;
        }

        /* =========================
           EMPTY STATE
        ========================== */
        .empty-state {
            padding: 70px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 65px;
            color: #adb5bd;
        }

        /* =========================
           MOBILE
        ========================== */
        @media (max-width: 991px) {

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .menu-btn {
                display: block;
            }

            .page-content {
                padding: 20px 15px;
            }
        }

        @media (max-width: 576px) {

            .top-navbar {
                padding: 0 15px;
            }

            .user-name {
                display: none;
            }

            .notification-item {
                padding: 18px 15px;
            }

            .notification-header {
                padding: 18px 15px;
            }

            .notification-icon {
                min-width: 42px;
                width: 42px;
                height: 42px;
                font-size: 18px;
            }

            .notification-title {
                font-size: 14px;
            }

            .notification-message {
                font-size: 13px;
            }
        }
    </style>
</head>

<body>

<!-- =====================================================
     SIDEBAR
===================================================== -->

    <div class="sidebar d-none d-lg-flex flex-column" id="sidebar">

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

        <a href="{{ route('dashboard') }}" >
            <i class="bi bi-grid-fill"></i>
            Dashboard
        </a>

        <a href="{{ route('service') }}" >
            <i class="bi bi-gear"></i>
            Services
        </a>

        <a href="{{ route('refer') }}" >
            <i class="bi bi-people"></i>
            Refer & Earn
        </a>

        <a href="{{ route('history') }}" >
            <i class="bi bi-clock-history"></i>
            Transactions
        </a>

        <a href="{{ route('profile.edit') }}" >
            <i class="bi bi-person-lines-fill"></i>
            Profile
        </a>

    </div>


<!-- =====================================================
     MAIN CONTENT
===================================================== -->

<div class="main-content">

    <!-- ================= MOBILE BOTTOM NAV ================= -->
    <div class="mobile-nav d-flex d-lg-none justify-content-around align-items-center">

        <a href="{{ route('dashboard') }}" class="active">
            <i class="bi bi-grid-fill"></i>
            <small>Home</small>
        </a>

        <a href="{{ route('service') }}" >
            <i class="bi bi-gear"></i>
            <small>Services</small>
        </a>

        <a href="{{ route('refer') }}" >
            <i class="bi bi-people"></i>
            <small>Refer & Earn</small>
        </a>

        <a href="{{ route('history') }}" >
            <i class="bi bi-clock-history"></i>
            <small>History</small>
        </a>

        <a href="{{ route('profile.edit') }}" >
            <i class="bi bi-person-lines-fill"></i>
            <small>Profile</small>
        </a>

    </div>

   

    <!-- ================= PAGE CONTENT ================= -->

    <main class="page-content">

        <!-- PAGE HEADER -->

        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">

            <div>

                <h2 class="page-title mb-1">
                    Notifications
                </h2>

                <div class="breadcrumb">
                    <span class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </span>

                    <span class="breadcrumb-item active">
                        Notifications
                    </span>
                </div>

            </div>


            <button
                class="btn btn-outline-primary"
                onclick="markAllAsRead()"
            >

                <i class="bi bi-check2-all me-1"></i>

                Mark All as Read

            </button>

        </div>


        <!-- ================= FILTER ================= -->

        <div class="card border-0 shadow-sm mb-4">

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-6">

                        <div class="input-group">

                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="text"
                                class="form-control"
                                id="searchNotification"
                                placeholder="Search notifications..."
                                onkeyup="searchNotifications()"
                            >

                        </div>

                    </div>


                    <div class="col-md-3">

                        <select
                            class="form-select"
                            id="notificationFilter"
                            onchange="applyNotificationFilters()"
                        >

                            <option value="all"{{ request('status', 'all') === 'all' ? 'selected' : '' }}>
                                All Notifications
                            </option>

                            <option value="unread"{{ request('status') === 'unread' ? 'selected' : '' }}>
                                Unread
                            </option>

                            <option value="read"{{ request('status') === 'read' ? 'selected' : '' }}>
                                Read
                            </option>

                        </select>

                    </div>


                    <div class="col-md-3">

                    <select
                        class="form-select"
                        id="notificationType"
                        onchange="applyNotificationFilters()"
                    >
                        <option value="all"{{ request('type') === 'all' ? 'selected' : '' }}>
                            All Types
                        </option>

                        <option value="payment"{{ request('type') === 'payment' ? 'selected' : '' }}>
                            Payments
                        </option>

                        <option value="wallet" {{ request('type') === 'wallet' ? 'selected' : '' }}>
                            Wallet
                        </option>

                        <option value="refund" {{ request('type') === 'refund' ? 'selected' : '' }}>
                            Refunds
                        </option>

                        <option value="retrieve" {{ request('type') === 'retrieve' ? 'selected' : '' }}>
                            Retrieve
                        </option>

                        <option value="approved" {{ request('type') === 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="security" {{ request('type') === 'security' ? 'selected' : '' }}>
                            Security
                        </option>

                        <option value="system" {{ request('type') === 'system' ? 'selected' : '' }}>
                            System
                        </option>
                    </select>
                    </div>

                </div>

            </div>

        </div>


        <!-- ================= NOTIFICATION CARD ================= -->

        <div class="notification-container shadow-sm">

            <div class="notification-header">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="mb-1 fw-bold">
                            Notification History
                        </h5>

                        <small class="text-muted">

                            <span id="totalNotifications">
                                6
                            </span>

                            notifications

                        </small>

                    </div>


                    <div>

                        <button
                            class="btn btn-sm btn-outline-secondary"
                            onclick="clearReadNotifications()"
                        >

                            <i class="bi bi-trash me-1"></i>

                            Clear Read

                        </button>

                    </div>

                </div>

            </div>


            <!-- ================= NOTIFICATION LIST ================= -->

            <div id="notificationList">

                @forelse($notifications as $notification)

                    <div
                        class="notification-item {{ !$notification->is_read ? 'unread' : '' }}"
                        data-id="{{ $notification->id }}"
                        data-status="{{ $notification->is_read ? 'read' : 'unread' }}"
                        data-type="{{ $notification->type }}"
                    >

                        <div class="notification-icon {{ $notification->icon_class ?? 'icon-primary' }}">
                            <i class="{{ $notification->icon ?? 'bi bi-bell' }}"></i>
                        </div>

                        <div class="notification-content">

                            <div class="notification-title">

                                {{ $notification->title }}

                                @if(!$notification->is_read)
                                    <span class="unread-dot"></span>
                                @endif

                            </div>

                            <div class="notification-message">
                                {!! nl2br(e($notification->message)) !!}
                            </div>

                            <div class="notification-time">

                                <i class="bi bi-clock me-1"></i>

                                {{ $notification->created_at->diffForHumans() }}

                            </div>

                        </div>

                        <div class="dropdown">

                            <button
                                class="btn btn-sm btn-light"
                                data-bs-toggle="dropdown"
                            >
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">

                                @if(!$notification->is_read)

                                    <li>
                                        <button
                                            class="dropdown-item"
                                            onclick="markAsRead({{ $notification->id }})"
                                        >
                                            <i class="bi bi-check2 me-2"></i>
                                            Mark as read
                                        </button>
                                    </li>

                                @endif

                                <li>
                                    <button
                                        class="dropdown-item text-danger"
                                        onclick="deleteNotification({{ $notification->id }})"
                                    >
                                        <i class="bi bi-trash me-2"></i>
                                        Delete
                                    </button>
                                </li>

                            </ul>

                        </div>

                    </div>

                @empty

                    <div class="empty-state">

                        <i class="bi bi-bell-slash"></i>

                        <h5 class="mt-3">
                            No notifications
                        </h5>

                        <p class="text-muted">
                            You don't have any notifications yet.
                        </p>

                    </div>

                @endforelse

            </div>


            <!-- ================= PAGINATION ================= -->

            <div class="p-3 border-top">

                <div class="d-flex justify-content-center">

                    {{ $notifications->onEachSide(1)->links('pagination::bootstrap-5') }}

                </div>

            </div>

        </div>

    </main>

</div>


<!-- =====================================================
     MOBILE OVERLAY
===================================================== -->

<div
    id="sidebarOverlay"
    style="
        display:none;
        position:fixed;
        inset:0;
        background:rgba(0,0,0,.4);
        z-index:1040;
    "
></div>


<!-- Bootstrap JS -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<script>

    /* ==========================================
       SIDEBAR
    ========================================== */

    const sidebar = document.getElementById("sidebar");
const menuButton = document.getElementById("menuButton");
const overlay = document.getElementById("sidebarOverlay");

if (menuButton && sidebar && overlay) {

    menuButton.addEventListener("click", function () {

        sidebar.classList.toggle("show");

        if (sidebar.classList.contains("show")) {
            overlay.style.display = "block";
        } else {
            overlay.style.display = "none";
        }

    });

    overlay.addEventListener("click", function () {

        sidebar.classList.remove("show");

        overlay.style.display = "none";

    });

}

    /* ==========================================
       MARK ONE AS READ
    ========================================== */
    function markAsRead(id) {

fetch(`/dashboard/notifications/${id}/read`, {
    method: "POST",

    headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json",
        "Content-Type": "application/json"
    }
})
.then(async response => {

    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "Failed to mark notification as read.");
    }

    return data;
})
.then(data => {

    if (!data.success) {
        throw new Error(data.message || "Failed.");
    }

    const notification =
        document.querySelector(
            `.notification-item[data-id="${id}"]`
        );

    if (notification) {

        notification.classList.remove("unread");

        notification.dataset.status = "read";

        const dot =
            notification.querySelector(".unread-dot");

        if (dot) {
            dot.remove();
        }

    }

    updateNotificationCount(data.unread_count);

})
.catch(error => {

    console.error("Mark as read error:", error);

    alert(error.message);

});
}


/* ==========================================
       MARK ALL AS READ
    ========================================== */


function markAllAsRead() {

    fetch("{{ route('notification.readAll') }}", {

        method: "POST",

        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json",
            "Content-Type": "application/json"
        }

    })
    .then(async response => {

        const data = await response.json();

        if (!response.ok) {
            throw new Error(
                data.message || "Failed to mark all notifications as read."
            );
        }

        return data;
    })
    .then(data => {

        if (!data.success) {
            throw new Error(
                data.message || "Failed to mark notifications as read."
            );
        }

        document
            .querySelectorAll(".notification-item")
            .forEach(notification => {

                notification.classList.remove("unread");

                notification.dataset.status = "read";

                const dot =
                    notification.querySelector(".unread-dot");

                if (dot) {
                    dot.remove();
                }

            });

        updateNotificationCount(0);

    })
    .catch(error => {

        console.error("Mark all as read error:", error);

        alert(error.message);

    });
}

    /* ==========================================
       DELETE NOTIFICATION
    ========================================== */

    function deleteNotification(id) {

if (!confirm("Delete this notification?")) {
    return;
}

fetch(`/dashboard/notifications/${id}`, {
    method: "DELETE",

    headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json"
    }
})
.then(response => response.json())
.then(data => {

    if (data.success) {

        const notification =
            document.querySelector(
                `.notification-item[data-id="${id}"]`
            );

        if (notification) {
            notification.remove();
        }

        updateNotificationCount(data.unread_count);

        updateTotalNotifications();
    }

})
.catch(error => {
    console.error(error);
});
}

    /* ==========================================
       CLEAR READ
    ========================================== */
    function clearReadNotifications() {

if (!confirm("Clear all read notifications?")) {
    return;
}

fetch("{{ route('notification.clearRead') }}", {

    method: "DELETE",

    headers: {
        "X-CSRF-TOKEN": "{{ csrf_token() }}",
        "Accept": "application/json",
        "Content-Type": "application/json"
    }

})
.then(async response => {

    const data = await response.json();

    if (!response.ok) {
        throw new Error(
            data.message || "Failed to clear notifications."
        );
    }

    return data;
})
.then(data => {

    if (!data.success) {
        throw new Error(
            data.message || "Failed to clear notifications."
        );
    }

    location.reload();

})
.catch(error => {

    console.error("Clear read error:", error);

    alert(error.message);

});
}
    /* ==========================================
       TOTAL NOTIFICATIONS
    ========================================== */

    function updateNotificationCount(count = null) {

if (count === null) {

    count =
        document.querySelectorAll(
            '.notification-item[data-status="unread"]'
        ).length;
}

const sidebarCount =
    document.getElementById("sidebarNotificationCount");

const navbarCount =
    document.getElementById("navbarNotificationCount");

if (sidebarCount) {

    sidebarCount.textContent = count;

    sidebarCount.style.display =
        count > 0 ? "flex" : "none";
}

if (navbarCount) {

    navbarCount.textContent = count;

    navbarCount.style.display =
        count > 0 ? "flex" : "none";
}
}


    /* ==========================================
       SEARCH
    ========================================== */

    function searchNotifications() {

const search =
    document.getElementById("searchNotification").value.trim();

const status =
    document.getElementById("notificationFilter").value;

const type =
    document.getElementById("notificationType").value;


const params = new URLSearchParams();


if (search !== "") {
    params.set("search", search);
}


if (status !== "all") {
    params.set("status", status);
}


if (type !== "all") {
    params.set("type", type);
}


window.location.href =
    "{{ route('notification') }}" +
    (params.toString()
        ? "?" + params.toString()
        : "");
}
    /* ==========================================
       FILTER
    ========================================== */

    function applyNotificationFilters() {

        const status =
            document.getElementById(
                "notificationFilter"
            ).value;

        const type =
            document.getElementById(
                "notificationType"
            ).value;

        const notifications =
            document.querySelectorAll(
                ".notification-item"
            );

        notifications.forEach(notification => {

            const notificationStatus =
                notification.dataset.status;

            const notificationType =
                notification.dataset.type;

            let show = true;


            if (
                status !== "all" &&
                notificationStatus !== status
            ) {

                show = false;

            }


            if (
                type !== "all" &&
                notificationType !== type
            ) {

                show = false;

            }


            notification.style.display =
                show ? "flex" : "none";

        });

    }


    /* ==========================================
       OPEN NOTIFICATION
    ========================================== */

    function openNotification(id) {

        markAsRead(id);

    }


    /* ==========================================
       INITIAL COUNT
    ========================================== */

    updateNotificationCount();

</script>

</body>
</html>