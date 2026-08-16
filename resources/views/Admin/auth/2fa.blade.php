<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $setting->site_name ?? 'BillVexa' }} - Two-Factor Authentication</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-md-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">

                        <h3 class="fw-bold">
                            Two-Factor Authentication
                        </h3>

                        <p class="text-muted mb-0">
                            Verify your administrator account
                        </p>

                    </div>


                    {{-- Error messages --}}

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach

                        </div>

                    @endif


                    {{-- Success message --}}

                    @if (session('success'))

                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>

                    @endif


                    <div class="alert alert-info">

                        <strong>Verification code sent.</strong>

                        <br>

                        Check your administrator email for the
                        6-digit verification code.

                    </div>


                    <form
                        method="POST"
                        action="{{ route('admin.2fa.verify') }}"
                    >

                        @csrf


                        <div class="mb-4">

                            <label
                                for="code"
                                class="form-label fw-semibold"
                            >
                                Verification Code
                            </label>

                            <input
                                type="text"
                                name="code"
                                id="code"
                                class="form-control form-control-lg text-center"
                                placeholder="000000"
                                maxlength="6"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                required
                                autofocus
                            >

                            @error('code')

                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100 btn-lg"
                        >
                            Verify Code
                        </button>

                    </form>


                    <div class="text-center mt-4">

                        <a
                            href="{{ route('admin.login') }}"
                            class="text-decoration-none"
                        >
                            Back to Admin Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>