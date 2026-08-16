<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ $setting->site_name ?? 'BillVexa' }} - Maintenance
    </title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >
</head>

<body class="bg-light">

<div class="container">

    <div class="row min-vh-100 justify-content-center align-items-center">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center p-5">

                    @if (!empty($setting->logo))

                        <img
                            src="{{ asset('storage/' . $setting->logo) }}"
                            alt="{{ $setting->site_name ?? 'BillVexa' }}"
                            style="max-width: 120px; max-height: 80px;"
                            class="mb-4"
                        >

                    @endif

                    <div class="mb-3">
                        <i
                            class="bi bi-tools"
                            style="font-size: 55px;"
                        ></i>
                    </div>

                    <h1 class="fw-bold">
                        We'll Be Back Soon
                    </h1>

                    <p class="text-muted mt-3">
                        {{ $setting->site_name ?? 'BillVexa' }}
                        is currently undergoing maintenance.
                    </p>

                    <p class="text-muted">
                        We're working to improve your experience.
                        Please check back shortly.
                    </p>

                    <div class="mt-4">

                        <div
                            class="spinner-border"
                            role="status"
                        >
                            <span class="visually-hidden">
                                Loading...
                            </span>
                        </div>

                    </div>

                    <p class="small text-muted mt-4 mb-0">
                        Thank you for your patience.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>