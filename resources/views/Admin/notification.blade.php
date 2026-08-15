@extends('layouts.admin')

@section('title', 'Notification Center')

@section('page-title', 'Notification Center')

@section('content')

{{-- =========================================================
    PAGE HEADER
========================================================= --}}

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Notification Center
        </h3>

        <p class="text-muted mb-0">
            Send notifications to users and view notification history.
        </p>
    </div>

</div>


{{-- =========================================================
    SUCCESS / ERROR MESSAGES
========================================================= --}}

@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show" role="alert">

        <i class="bi bi-check-circle-fill me-2"></i>

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


@if($errors->any())

    <div class="alert alert-danger alert-dismissible fade show" role="alert">

        <strong>Please fix the following:</strong>

        <ul class="mb-0 mt-2">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif


{{-- =========================================================
    NOTIFICATION FEATURES
========================================================= --}}

<div class="row g-4 mb-4">


    {{-- =====================================================
        SEND NOTIFICATION
    ====================================================== --}}

    <div class="col-lg-6">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-header bg-white py-3">

                <h5 class="mb-0 fw-semibold">
                    <i class="bi bi-send me-2 text-primary"></i>
                    Send Notification
                </h5>

            </div>


            <div class="card-body">

                <form id="notificationForm"
                      action="{{ route('admin.notifications.store') }}"
                      method="POST">

                    @csrf


                    {{-- Recipient Type --}}

                    <div class="mb-3">

                        <label for="recipientType"
                               class="form-label fw-semibold">

                            Send To

                        </label>

                        <select name="recipient_type"
                                id="recipientType"
                                class="form-select"
                                required>

                            <option value="">
                                Select Recipient Type
                            </option>

                            <option value="everyone">
                                Everyone
                            </option>

                            <option value="user">
                                One User
                            </option>

                            <option value="role">
                                By Role
                            </option>

                        </select>

                    </div>


                    {{-- =================================================
                        USER RECIPIENT
                    ================================================== --}}

                    <div class="mb-3 d-none"
                         id="userRecipient">

                        <label for="userSelect"
                               class="form-label fw-semibold">

                            Select User

                        </label>

                        <select name="recipient"
                                id="userSelect"
                                class="form-select"
                                disabled>

                            <option value="">
                                Select User
                            </option>

                            @foreach($users as $user)

                                <option value="{{ $user->id }}">

                                    {{ $user->name }}

                                    @if($user->email)
                                        — {{ $user->email }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                        <small class="text-muted">
                            Select the user who should receive this notification.
                        </small>

                    </div>


                    {{-- =================================================
                        ROLE RECIPIENT
                    ================================================== --}}

                    <div class="mb-3 d-none"
                         id="roleRecipient">

                        <label for="roleSelect"
                               class="form-label fw-semibold">

                            Select Role

                        </label>

                        <select name="recipient"
                                id="roleSelect"
                                class="form-select"
                                disabled>

                            <option value="">
                                Select Role
                            </option>

                            <option value="user">
                                User
                            </option>

                            <option value="admin">
                                Admin
                            </option>

                        </select>

                        <small class="text-muted">
                            All users with the selected role will receive the notification.
                        </small>

                    </div>


                    {{-- =================================================
                        NOTIFICATION TYPE
                    ================================================== --}}

                    <div class="mb-3">

                        <label for="notificationType"
                               class="form-label fw-semibold">

                            Notification Type

                        </label>

                        <select name="type"
                                id="notificationType"
                                class="form-select"
                                required>

                            <option value="">
                                Select Notification Type
                            </option>

                            <option value="payment">
                                Payment
                            </option>

                            <option value="wallet">
                                Wallet
                            </option>

                            <option value="refund">
                                Refund
                            </option>

                            <option value="retrieve">
                                Retrieve
                            </option>

                            <option value="approved">
                                Approved
                            </option>

                            <option value="security">
                                Security
                            </option>

                            <option value="system">
                                System
                            </option>

                        </select>

                    </div>


                    {{-- =================================================
                        TITLE
                    ================================================== --}}

                    <div class="mb-3">

                        <label for="notificationTitle"
                               class="form-label fw-semibold">

                            Notification Title

                        </label>

                        <input type="text"
                               name="title"
                               id="notificationTitle"
                               class="form-control"
                               placeholder="Enter notification title"
                               maxlength="255"
                               required>

                    </div>


                    {{-- =================================================
                        MESSAGE
                    ================================================== --}}

                    <div class="mb-3">

                        <label for="notificationMessage"
                               class="form-label fw-semibold">

                            Message

                        </label>

                        <textarea name="message"
                                  id="notificationMessage"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Write notification message..."
                                  required></textarea>

                    </div>


                    {{-- =================================================
                        DELIVERY CHANNELS
                    ================================================== --}}

                    <div class="mb-4">

                        <label class="form-label fw-semibold d-block">
                            Delivery Channels
                        </label>


                        <div class="row g-3">


                            {{-- Push --}}

                            <div class="col-md-4">

                                <div class="form-check">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="push"
                                           id="pushNotification"
                                           checked>

                                    <label class="form-check-label"
                                           for="pushNotification">

                                        <i class="bi bi-bell-fill text-dark me-1"></i>

                                        Push

                                    </label>

                                </div>

                            </div>


                            {{-- Email --}}

                            <div class="col-md-4">

                                <div class="form-check">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="email"
                                           id="emailNotification">

                                    <label class="form-check-label"
                                           for="emailNotification">

                                        <i class="bi bi-envelope-fill text-info me-1"></i>

                                        Email

                                    </label>

                                </div>

                            </div>


                            {{-- SMS --}}

                            <div class="col-md-4">

                                <div class="form-check">

                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="sms"
                                           id="smsNotification">

                                    <label class="form-check-label"
                                           for="smsNotification">

                                        <i class="bi bi-chat-dots-fill text-secondary me-1"></i>

                                        SMS

                                    </label>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        SUBMIT
                    ================================================== --}}

                    <button type="submit"
                            class="btn btn-primary w-100">

                        <i class="bi bi-send-fill me-2"></i>

                        Send Notification

                    </button>

                </form>

            </div>

        </div>

    </div>


    {{-- =====================================================
        QUICK ACTIONS
    ====================================================== --}}

    <div class="col-lg-6">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-header bg-white py-3">

                <h5 class="mb-0 fw-semibold">

                    <i class="bi bi-lightning-charge-fill me-2 text-warning"></i>

                    Quick Actions

                </h5>

            </div>


            <div class="card-body">

                <p class="text-muted small mb-4">

                    Quickly configure the notification form.

                </p>


                <div class="d-grid gap-3">


                    {{-- Send to Everyone --}}

                    <button type="button"
                            class="btn btn-primary quick-action"
                            data-action="everyone">

                        <i class="bi bi-megaphone-fill me-2"></i>

                        Send to Everyone

                    </button>


                    {{-- Send to One User --}}

                    <button type="button"
                            class="btn btn-success quick-action"
                            data-action="user">

                        <i class="bi bi-person-fill me-2"></i>

                        Send to One User

                    </button>


                    {{-- Send by Role --}}

                    <button type="button"
                            class="btn btn-warning quick-action"
                            data-action="role">

                        <i class="bi bi-people-fill me-2"></i>

                        Send by Role

                    </button>


                    {{-- Push --}}

                    <button type="button"
                            class="btn btn-dark quick-action"
                            data-action="push">

                        <i class="bi bi-bell-fill me-2"></i>

                        Push Notification

                    </button>


                    {{-- Email --}}

                    <button type="button"
                            class="btn btn-info text-white quick-action"
                            data-action="email">

                        <i class="bi bi-envelope-fill me-2"></i>

                        Email Notification

                    </button>


                    {{-- SMS --}}

                    <button type="button"
                            class="btn btn-secondary quick-action"
                            data-action="sms">

                        <i class="bi bi-chat-dots-fill me-2"></i>

                        SMS Notification

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>



{{-- =========================================================
    NOTIFICATION HISTORY
========================================================= --}}

<div class="card shadow-sm border-0">

    <div class="card-header bg-white py-3">

        <h5 class="mb-0 fw-semibold">

            <i class="bi bi-clock-history me-2 text-primary"></i>

            Notification History

        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th>Title</th>

                        <th>Recipient</th>

                        <th>Type</th>

                        <th>Status</th>

                        <th>Date</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($notifications as $notification)

                    <tr class="{{ !$notification->is_read ? 'table-warning' : '' }}"
                   >


                            {{-- =========================================
                                TITLE
                            ========================================== --}}

                            <td>

                                <div class="fw-semibold">

                                    {{ $notification->title }}

                                </div>

                                @if($notification->message)

                                    <small class="text-muted">

                                        {{ Str::limit($notification->message, 50) }}

                                    </small>

                                @endif

                            </td>


                            {{-- =========================================
                                RECIPIENT
                            ========================================== --}}

                            <td>

                                @if($notification->recipient_type == 'everyone')

                                    <span class="badge bg-primary">

                                        <i class="bi bi-people-fill me-1"></i>

                                        Everyone

                                    </span>


                                @elseif($notification->recipient_type == 'user')

                                    @if($notification->recipientUser)

                                        <div class="d-flex align-items-center">

                                            <div class="bg-primary text-white rounded-circle
                                                        d-flex align-items-center justify-content-center me-2"
                                                 style="width: 38px; height: 38px; min-width: 38px;">

                                                {{ strtoupper(substr($notification->recipientUser->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="fw-semibold">

                                                    {{ $notification->recipientUser->name }}

                                                </div>

                                                <small class="text-muted">

                                                    {{ $notification->recipientUser->email }}

                                                </small>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-danger">

                                            User not found

                                        </span>

                                    @endif


                                @elseif($notification->recipient_type == 'role')

                                    <span class="badge bg-warning text-dark">

                                        <i class="bi bi-people-fill me-1"></i>

                                        {{ ucfirst($notification->recipient) }}

                                    </span>


                                @else

                                    {{-- Old notifications without recipient_type --}}

                                    @if($notification->recipientUser)

                                        <div class="d-flex align-items-center">

                                            <div class="bg-primary text-white rounded-circle
                                                        d-flex align-items-center justify-content-center me-2"
                                                 style="width: 38px; height: 38px; min-width: 38px;">

                                                {{ strtoupper(substr($notification->recipientUser->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <div class="fw-semibold">

                                                    {{ $notification->recipientUser->name }}

                                                </div>

                                                <small class="text-muted">

                                                    {{ $notification->recipientUser->email }}

                                                </small>

                                            </div>

                                        </div>

                                    @else

                                        <span class="text-muted">

                                            {{ $notification->recipient ?? 'Unknown' }}

                                        </span>

                                    @endif

                                @endif

                            </td>


                            {{-- =========================================
                                TYPE
                            ========================================== --}}

                            <td>

                                @if($notification->push)

                                    <span class="badge bg-primary me-1">

                                        <i class="bi bi-bell-fill me-1"></i>

                                        Push

                                    </span><br>

                                @endif


                                @if($notification->email)

                                    <span class="badge bg-info me-1">

                                        <i class="bi bi-envelope-fill me-1"></i>

                                        Email

                                    </span><br>

                                @endif


                                @if($notification->sms)

                                    <span class="badge bg-secondary">

                                        <i class="bi bi-chat-dots-fill me-1"></i>

                                        SMS

                                    </span>

                                @endif

                            </td>


                            {{-- =========================================
                                STATUS
                            ========================================== --}}

                            <td>

                                @if($notification->status == 'Sent')

                                    <span class="badge bg-success">

                                        <i class="bi bi-check-circle-fill me-1"></i>

                                        Sent

                                    </span>

                                @elseif($notification->status == 'Pending')

                                    <span class="badge bg-warning text-dark">

                                        <i class="bi bi-clock-fill me-1"></i>

                                        Pending

                                    </span>

                                @else

                                    <span class="badge bg-danger">

                                        <i class="bi bi-x-circle-fill me-1"></i>

                                        Failed

                                    </span>

                                @endif

                            </td>


                            {{-- =========================================
                                DATE
                            ========================================== --}}

                            <td>

                                <span class="text-nowrap">

                                    {{ $notification->created_at->format('d M Y') }}

                                </span>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-bell-slash fs-2 d-block mb-2"></i>

                                    No notifications found.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}

        @if($notifications->hasPages())

            <div class="mt-4">

                {{ $notifications->links() }}

            </div>

        @endif

    </div>

</div>



{{-- =========================================================
    QUICK ACTION JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const recipientType =
        document.getElementById('recipientType');

    const userRecipient =
        document.getElementById('userRecipient');

    const roleRecipient =
        document.getElementById('roleRecipient');

    const userSelect =
        document.getElementById('userSelect');

    const roleSelect =
        document.getElementById('roleSelect');

    const pushCheckbox =
        document.getElementById('pushNotification');

    const emailCheckbox =
        document.getElementById('emailNotification');

    const smsCheckbox =
        document.getElementById('smsNotification');

    const notificationForm =
        document.getElementById('notificationForm');


    /*
    |--------------------------------------------------------------------------
    | Show / Hide Recipient Fields
    |--------------------------------------------------------------------------
    */

    function updateRecipientFields() {

        const value = recipientType.value;


        // Hide both

        userRecipient.classList.add('d-none');

        roleRecipient.classList.add('d-none');


        // Disable both

        userSelect.disabled = true;

        roleSelect.disabled = true;


        // Clear inactive values

        if (value !== 'user') {
            userSelect.value = '';
        }

        if (value !== 'role') {
            roleSelect.value = '';
        }


        // User

        if (value === 'user') {

            userRecipient.classList.remove('d-none');

            userSelect.disabled = false;

        }


        // Role

        if (value === 'role') {

            roleRecipient.classList.remove('d-none');

            roleSelect.disabled = false;

        }

    }


    /*
    |--------------------------------------------------------------------------
    | Recipient Type Change
    |--------------------------------------------------------------------------
    */

    recipientType.addEventListener('change', function () {

        updateRecipientFields();

    });


    /*
    |--------------------------------------------------------------------------
    | Quick Actions
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.quick-action').forEach(function (button) {

        button.addEventListener('click', function () {

            const action = this.dataset.action;


            /*
            |--------------------------------------------------------------
            | Send To Everyone
            |--------------------------------------------------------------
            */

            if (action === 'everyone') {

                recipientType.value = 'everyone';

                updateRecipientFields();

                notificationForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                return;

            }


            /*
            |--------------------------------------------------------------
            | Send To One User
            |--------------------------------------------------------------
            */

            if (action === 'user') {

                recipientType.value = 'user';

                updateRecipientFields();

                notificationForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                setTimeout(function () {

                    userSelect.focus();

                }, 500);

                return;

            }


            /*
            |--------------------------------------------------------------
            | Send By Role
            |--------------------------------------------------------------
            */

            if (action === 'role') {

                recipientType.value = 'role';

                updateRecipientFields();

                notificationForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                setTimeout(function () {

                    roleSelect.focus();

                }, 500);

                return;

            }


            /*
            |--------------------------------------------------------------
            | Push Notification
            |--------------------------------------------------------------
            */

            if (action === 'push') {

                pushCheckbox.checked = true;

                emailCheckbox.checked = false;

                smsCheckbox.checked = false;

                notificationForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                return;

            }


            /*
            |--------------------------------------------------------------
            | Email Notification
            |--------------------------------------------------------------
            */

            if (action === 'email') {

                pushCheckbox.checked = false;

                emailCheckbox.checked = true;

                smsCheckbox.checked = false;

                notificationForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                return;

            }


            /*
            |--------------------------------------------------------------
            | SMS Notification
            |--------------------------------------------------------------
            */

            if (action === 'sms') {

                pushCheckbox.checked = false;

                emailCheckbox.checked = false;

                smsCheckbox.checked = true;

                notificationForm.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                return;

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Initial State
    |--------------------------------------------------------------------------
    */

    updateRecipientFields();

});

</script>

@endsection