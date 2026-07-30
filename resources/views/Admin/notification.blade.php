@extends('layouts.admin')

@section('title', 'Notification Center')

@section('page-title', 'Notification Center')

@section('content')

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">Notification Center</h3>

        <p class="text-muted mb-0">
            Send notifications to users and view notification history.
        </p>

    </div>

</div>

<!-- Notification Features -->
<div class="row g-4 mb-4">

    <div class="col-lg-6">

        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Send Notification

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <label class="form-label">

                        Send To

                    </label>

                    <select class="form-select">

                        <option>Everyone</option>

                        <option>One User</option>

                        <option>By Role</option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        User / Role

                    </label>

                    <input type="text"
                           class="form-control"
                           placeholder="Enter User or Role">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Notification Title

                    </label>

                    <input type="text"
                           class="form-control"
                           placeholder="Notification Title">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Message

                    </label>

                    <textarea class="form-control"
                              rows="5"
                              placeholder="Write notification message..."></textarea>

                </div>

                <div class="row g-3 mb-4">

                    <div class="col-md-4">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox"
                                   checked>

                            <label class="form-check-label">

                                Push Notification

                            </label>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox">

                            <label class="form-check-label">

                                Email Notification

                            </label>

                        </div>

                    </div>

                    <div class="col-md-4">

                        <div class="form-check">

                            <input class="form-check-input"
                                   type="checkbox">

                            <label class="form-check-label">

                                SMS Notification

                            </label>

                        </div>

                    </div>

                </div>

                <button class="btn btn-primary">

                    <i class="bi bi-send me-2"></i>

                    Send Notification

                </button>

            </div>

        </div>

    </div>

    <div class="col-lg-6">

        <div class="card shadow-sm border-0 h-100">

            <div class="card-header bg-white">

                <h5 class="mb-0">

                    Quick Actions

                </h5>

            </div>

            <div class="card-body">

                <div class="d-grid gap-3">

                    <button class="btn btn-primary">

                        <i class="bi bi-megaphone-fill me-2"></i>

                        Send to Everyone

                    </button>

                    <button class="btn btn-success">

                        <i class="bi bi-person-fill me-2"></i>

                        Send to One User

                    </button>

                    <button class="btn btn-warning">

                        <i class="bi bi-people-fill me-2"></i>

                        Send by Role

                    </button>

                    <button class="btn btn-dark">

                        <i class="bi bi-bell-fill me-2"></i>

                        Push Notification

                    </button>

                    <button class="btn btn-info text-white">

                        <i class="bi bi-envelope-fill me-2"></i>

                        Email Notification

                    </button>

                    <button class="btn btn-secondary">

                        <i class="bi bi-chat-dots-fill me-2"></i>

                        SMS Notification

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- Notification History -->
<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

        <h5 class="mb-0">

            Notification History

        </h5>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

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

                    <tr>

                        <td>Welcome Bonus</td>

                        <td>Everyone</td>

                        <td>

                            <span class="badge bg-primary">

                                Push

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-success">

                                Sent

                            </span>

                        </td>

                        <td>05 Jul 2026</td>

                    </tr>

                    <tr>

                        <td>Maintenance Notice</td>

                        <td>Users</td>

                        <td>

                            <span class="badge bg-info">

                                Email

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-success">

                                Sent

                            </span>

                        </td>

                        <td>04 Jul 2026</td>

                    </tr>

                    <tr>

                        <td>KYC Reminder</td>

                        <td>Pending KYC</td>

                        <td>

                            <span class="badge bg-secondary">

                                SMS

                            </span>

                        </td>

                        <td>

                            <span class="badge bg-warning text-dark">

                                Pending

                            </span>

                        </td>

                        <td>03 Jul 2026</td>

                    </tr>

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-end mt-4">

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

@endsection