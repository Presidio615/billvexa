<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password</title>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>
    body {
        font-family: Arial, sans-serif;
        background: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: #ffffff;
        padding: 30px;
        width: 100%;
        max-width: 400px;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .password-box {
        position: relative;
        width: 100%;
    }

    input {
        width: 90%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
        transition: 0.2s;
    }

    input:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79,70,229,0.2);
    }

    .password-box input {
        /* padding-right: 40px; */
    }

    .toggle-password {
        position: absolute;
        right: 25px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #666;
        font-size: 14px;
        transition: 0.2s;
    }

    .toggle-password:hover {
        color: #4f46e5;
    }

    button {
        width: 100%;
        padding: 12px;
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
    }

    button:hover {
        background: #3730a3;
    }

    .note {
        font-size: 12px;
        text-align: center;
        color: #777;
        margin-top: 10px;
    }
</style>

</head>
<body>

<div class="container">

    <h2>Reset Password</h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $token }}">

        <!-- Email -->
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- New Password -->
        <div class="form-group password-box">
            <input type="password" name="password" id="newPassword" placeholder="New Password" required>
            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('newPassword', this)"></i>
        </div>

        <!-- Confirm Password -->
        <div class="form-group password-box">
            <input type="password" name="password_confirmation" id="confirmPassword" placeholder="Confirm Password" required>
            <i class="fa-solid fa-eye toggle-password" onclick="togglePassword('confirmPassword', this)"></i>
        </div>

        <button type="submit">Reset Password</button>
    </form>

    <div class="note">
        Make sure your password is strong and secure.
    </div>

</div>

<script>
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

</body>
</html>