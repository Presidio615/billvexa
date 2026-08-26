<!DOCTYPE html>
<html>
<head>

    <title>BillVexa Admin Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container">

    <div class="row justify-content-center mt-5">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h4>Admin Login</h4>
                </div>

                <div class="card-body">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert">
                            </button>
                        </div>
                    @endif

                    {{-- Error Messages --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">

                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert">
                            </button>

                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label for="email" class="form-label">
                                Email
                            </label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}"
                                required
                                autofocus
                            >

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label for="password" class="form-label">
                                Password
                            </label>

                            <div class="input-group">

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    required
                                >

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    id="togglePassword"
                                >
                                    Show
                                </button>

                            </div>

                            @error('password')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="mb-3 form-check">

                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="form-check-input"
                            >

                            <label for="remember" class="form-check-label">
                                Remember Me
                            </label>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

document.getElementById('togglePassword').addEventListener('click', function () {

    const password = document.getElementById('password');

    if (password.type === 'password') {

        password.type = 'text';
        this.textContent = 'Hide';

    } else {

        password.type = 'password';
        this.textContent = 'Show';

    }

});

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>