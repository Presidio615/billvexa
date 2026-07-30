<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>BillVexa | Two-Factor Authentication</title>

    <!-- Bootstrap -->
    @vite(['resources/css/app.css','resources/js/app.js'])

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

            min-height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            background:linear-gradient(
                135deg,
                #5b21b6,
                #2563eb
            );

            font-family:Arial, Helvetica, sans-serif;
        }

        .verify-card{

            width:100%;
            max-width:470px;

            background:#fff;

            border-radius:25px;

            padding:40px;

            box-shadow:0 25px 60px rgba(0,0,0,.15);

            animation:fadeIn .5s ease;
        }

        @keyframes fadeIn{

            from{
                opacity:0;
                transform:translateY(30px);
            }

            to{
                opacity:1;
                transform:translateY(0);
            }

        }

        .logo{

            width:85px;
            height:85px;

            margin:auto;

            display:flex;
            justify-content:center;
            align-items:center;

            border-radius:50%;

            background:linear-gradient(
                135deg,
                #5b21b6,
                #2563eb
            );

            color:#fff;

            font-size:35px;

            margin-bottom:20px;
        }

        h2{

            font-weight:700;

            color:#1e293b;
        }

        .description{

            color:#6b7280;

            line-height:1.6;
        }

        .form-control{

            height:60px;

            border-radius:15px;

            font-size:24px;

            letter-spacing:10px;

            text-align:center;

            font-weight:bold;

            border:2px solid #e5e7eb;
        }

        .form-control:focus{

            border-color:#4f46e5;

            box-shadow:none;
        }

        .btn-verify{

            height:55px;

            border:none;

            border-radius:15px;

            background:linear-gradient(
                135deg,
                #5b21b6,
                #2563eb
            );

            color:#fff;

            font-weight:600;

            transition:.3s;
        }

        .btn-verify:hover{

            transform:translateY(-2px);

            box-shadow:0 15px 30px rgba(37,99,235,.35);
        }

        .timer{

            color:#6b7280;

            font-size:14px;
        }

        .footer{

            margin-top:30px;

            color:#9ca3af;

            font-size:14px;
        }

        @media(max-width:576px){

            .verify-card{

                margin:20px;

                padding:30px 25px;
            }

        }

    </style>

</head>
<body>

    <div class="verify-card">

        <div class="logo">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <div class="text-center mb-4">

            <h2>Two-Factor Authentication</h2>

            <p class="description mt-3">

                Enter the <strong>6-digit verification code</strong>
                that was sent to your registered email address to
                complete your login.

            </p>

        </div>

        @if(session('success'))

            <div class="alert alert-success alert-dismissible fade show">

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ $errors->first() }}

                <button class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif


        <!-- Verify Form -->
        <form action="{{ route('2fa.verify.post') }}" method="POST">

            @csrf

            <div class="mb-4">

                <input
                    type="text"
                    name="code"
                    class="form-control"
                    maxlength="6"
                    placeholder="------"
                    autocomplete="off"
                    required>

            </div>

            <button type="submit" class="btn btn-verify w-100">

                <i class="bi bi-shield-check me-2"></i>

                Verify Code

            </button>

        </form>

        <!-- Resend Form -->
        <div class="text-center mt-4">

            <form action="{{ route('2fa.resend') }}" method="POST">

                @csrf

                <button
                    type="submit"
                    id="resendBtn"
                    class="btn btn-link text-decoration-none"
                    disabled>

                    <i class="bi bi-arrow-repeat me-1"></i>

                    Resend Code

                </button>

            </form>

        </div>
        
        <div class="text-center mt-4">

            <small class="text-muted d-block mt-2">

                You can resend another code in

                <strong id="timer">
                        60
                </strong>

                seconds

            </small>

        </div>

        <div class="footer text-center">

            Didn't receive the code?

            <br>

            Check your Spam/Junk folder or request a new code.

        </div>

    </div>

    <script>

        const input = document.querySelector("input[name='code']");

        input.addEventListener("input", function(){

            this.value = this.value.replace(/[^0-9]/g,'');

        });

        let seconds = 60;

        const timer = document.getElementById("timer");

        const resendBtn = document.getElementById("resendBtn");

        const countdown = setInterval(() => {

            seconds--;

            timer.innerHTML = seconds;

            if(seconds <= 0){

                clearInterval(countdown);

                timer.innerHTML = "0";

                resendBtn.disabled = false;

            }

        },1000);
  
    </script>

</body>
</html>