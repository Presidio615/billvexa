<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Double Slider Authentication</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f6f5f7;
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            padding:20px;
        }

        h1{
            font-weight:bold;
            margin-bottom:15px;
        }

        p{
            font-size:14px;
            line-height:20px;
            letter-spacing:.3px;
            margin:20px 0 30px;
        }

        button{
            border-radius:20px;
            border:none;
            background: #0d6efd;
            color:#fff;
            font-size:12px;
            font-weight:bold;
            padding:12px 45px;
            letter-spacing:1px;
            text-transform:uppercase;
            cursor:pointer;
            transition:.3s;
        }

        button:hover{
            opacity:.9;
        }

        form{
            background:#fff;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            padding:0 50px;
            height:100%;
            text-align:center;
        }

        input{
            width:100%;
            padding:14px 16px;
            margin:8px 0;
            border:none;
            border-radius:8px;
            background:#f1f3f5;
            outline:none;
            transition:.3s;
        }

        input:focus{
            background:#fff;
            box-shadow:0 0 0 2px #0d6efd;
        }

        .form-options{
            width:100%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin:15px 0 20px;
            font-size:13px;
        }

        .remember{
            display:flex;
            align-items:center;
            gap:8px;
            cursor:pointer;
        }

        .remember input{
            width:auto;
            margin:0;
        }

        .form-options a{
            color:#0d6efd;
            text-decoration:none;
            font-size:13px;
        }

        .form-options a:hover{
            text-decoration:underline;
        }

        .mobile-link{
            margin-top:7px;
            color:#0d6efd;
            cursor:pointer;
            font-size:14px;
        }

        .mobile-link:hover{
            text-decoration:underline;
        }

        .message{
            width:100%;
            font-size:14px;
        }

        .success{
            color:#146c43;
        }

        .error{
            color:#842029;
        }

        button{
            margin-top:5px;
        }

        .container{
            background:#fff;
            border-radius:15px;
            box-shadow:0 14px 28px rgba(0,0,0,.15),
                        0 10px 10px rgba(0,0,0,.12);
            position:relative;
            overflow:hidden;
            width:900px;
            max-width:100%;
            min-height:600px;
        }

        .form-container{
            position:absolute;
            top:0;
            height:100%;
            transition:all .6s ease-in-out;
        }

        .sign-in-container{
            left:0;
            width:50%;
            z-index:2;
        }

        .sign-up-container{
            left:0;
            margin-top: 10px;
            width:50%;
            opacity:0;
            z-index:2;
        }

        .password-box {
            position: relative;
            width: 100%;
        }

        .password-box input {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 14px;
            transition: 0.2s;
        }

        .toggle-password:hover {
            color: #0d6efd;
        }

        .container.right-panel-active .sign-in-container{
            transform:translateX(100%);
        }

        .container.right-panel-active .sign-up-container{
            transform:translateX(100%);
            opacity:1;
            z-index:5;
        }

        .overlay-container{
            position:absolute;
            top:0;
            left:50%;
            width:50%;
            height:100%;
            overflow:hidden;
            transition:transform .6s ease-in-out;
            z-index:100;
        }

        .container.right-panel-active .overlay-container{
            transform:translateX(-100%);
        }

        .overlay{
            background:linear-gradient(135deg,#0d6efd,#6610f2);
            color:#fff;
            position:relative;
            left:-100%;
            height:100%;
            width:200%;
            transform:translateX(0);
            transition:transform .6s ease-in-out;
        }

        .container.right-panel-active .overlay{
            transform:translateX(50%);
        }

        .overlay-panel{
            position:absolute;
            display:flex;
            align-items:center;
            justify-content:center;
            flex-direction:column;
            padding:0 40px;
            text-align:center;
            top:0;
            height:100%;
            width:50%;
        }

        .overlay-left{
            transform:translateX(-5%);
        }

        .overlay-right{
            right:0;
        }

        .ghost{
            background:transparent;
            border:1px solid #fff;
        }

        .social-icons{
            display:flex;
            gap:15px;
            margin:17px 0;
        }

        .social-icons a{
            width:42px;
            height:42px;
            display:flex;
            justify-content:center;
            align-items:center;
            border:1px solid #ddd;
            border-radius:50%;
            color:#444;
            transition:.3s;
        }

        .social-icons a:hover{
            background:#0d6efd;
            color:#fff;
            border-color:#0d6efd;
        }

        /* Mobile Design */
        @media(max-width:768px){

            .container{
                min-height:650px;
            }

            .overlay-container{
                display:none;
            }

            .sign-in-container,
            .sign-up-container{
                width:100%;
            }

            .sign-in-container{
                z-index:2;
            }

            .sign-up-container{
                opacity:0;
                visibility:hidden;
            }

            .container.right-panel-active .sign-in-container{
                transform:none;
                opacity:0;
                visibility:hidden;
            }

            .container.right-panel-active .sign-up-container{
                transform:none;
                opacity:1;
                visibility:visible;
                z-index:5;
            }

            form{
                padding:30px;
            }
        }
    </style>
</head>
<body>

    <div class="container" id="container">

        <!-- Sign Up -->
        <div class="form-container sign-up-container">
            <form action="{{ route('register') }}" method="POST">

                @csrf

                <h1 style="margin-top: 5px;">Create Account</h1>

                <div class="social-icons">
                    <a href="{{ route('google.login') }}" ><i class="fab fa-google"></i></a>
                    <a href="{{ url('/auth/facebook') }}"><i class="fab fa-facebook"></i></a>
                    <a href="{{ url('/auth/github') }}"><i class="fab fa-github"></i></a>
                </div>

                <input
                    type="text"
                    name="name"
                    placeholder="Full Name"
                    required
                >

                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required
                >

                <input
                    type="text"
                    name="phone"
                    placeholder="Phone Number"
                    required
                >

                <div class="password-box">
                    <input type="password" name="password" id="signupPassword" placeholder="Password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('signupPassword', this)"></i>
                </div>

                <div class="password-box">
                    <input type="password" name="password_confirmation" id="signupConfirm" placeholder="Confirm Password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('signupConfirm', this)"></i>
                </div>
                <button type="submit">
                    Sign Up
                </button>

                @if(session('success'))
                    <div class="message success">
                        {{ session('success') }}
                    </div>
                @endif

                <p class="mobile-link" id="mobileSignIn">
                    Already have an account? <strong>Sign In</strong>
                </p>

            </form>
        </div>

        <!-- Sign In -->
        <div class="form-container sign-in-container">
            <form action="{{ route('signin') }}" method="POST">
                @csrf

                <h1>Sign In</h1>

                <div class="social-icons">
                    <a href="{{ route('google.login') }}" ><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-github"></i></a>
                </div>

                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    required
                >

                <div class="password-box">
                    <input type="password" name="password" id="loginPassword" placeholder="Password" required>
                    <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('loginPassword', this)"></i>
                </div>

                <div class="form-options">

                    <label class="remember">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>

                    <a href="{{ route('password.request') }}">Forgot Password?</a>

                </div>

                <button type="submit">
                    Sign In
                </button>

                @if ($errors->any())
                    <div class="message error">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <p class="mobile-link" id="mobileSignUp">
                    Don't have an account? <strong>Sign Up</strong>
                </p>

            </form>
        </div>

        <!-- Overlay -->
        <div class="overlay-container">
            <div class="overlay">

                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To stay connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">
                        Sign In
                    </button>
                </div>

                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start using our services</p>
                    <button class="ghost" id="signUp">
                        Sign Up
                    </button>
                </div>

            </div>
        </div>

    </div>

    <script>
        const container = document.getElementById('container');

        document.getElementById('signUp').addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        document.getElementById('signIn').addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });

        document.getElementById('mobileSignUp').addEventListener('click', () => {
            container.classList.add('right-panel-active');
        });

        document.getElementById('mobileSignIn').addEventListener('click', () => {
            container.classList.remove('right-panel-active');
        });


        function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);

        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
    </script>
    <script src="../../../Assets/libs/js/bootstrap.bundle.js"></script>

</body>
</html>