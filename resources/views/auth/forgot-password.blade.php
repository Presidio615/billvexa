<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Forgot Password</title>

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
        margin-bottom: 10px;
        color: #333;
    }

    p {
        text-align: center;
        font-size: 13px;
        color: #777;
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    input {

        width: 100%;

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

    button {

        width: 100%;
        width: 95%;

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

    <h2>Forgot Password</h2>
    <p>Enter your email and we’ll send you a reset link</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="form-group">
            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >
        </div>

        @error('email')
            <div style="color:red; margin-top:10px;">
                {{ $message }}
            </div>
        @enderror

        <button type="submit">
            Send Reset Link
        </button>
    </form>

    <div class="note">
        Check your inbox after submitting.
    </div>

</div>

</body>
</html>