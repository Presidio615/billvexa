<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $setting->site_name ?? 'BillVexa' }} Admin Verification</title>
</head>

<body style="margin:0; padding:0; background:#f5f6f8; font-family:Arial,sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; padding:35px; border-radius:10px;">

        <h2>
            {{ $setting->site_name ?? 'BillVexa' }} Admin Security
        </h2>

        <p>
            A login attempt was made on your {{ $setting->site_name ?? 'BillVexa' }} administrator account.
        </p>

        <p>
            Use the verification code below to complete your login:
        </p>

        <div style="text-align:center; margin:30px 0;">

            <div style="
                display:inline-block;
                padding:15px 30px;
                background:#f1f3f5;
                border-radius:8px;
                font-size:32px;
                font-weight:bold;
                letter-spacing:8px;
            ">
                {{ $code }}
            </div>

        </div>

        <p>
            This code will expire in <strong>10 minutes</strong>.
        </p>

        <p style="color:#777;">
            If you did not attempt to log into the {{ $setting->site_name ?? 'BillVexa' }} admin dashboard,
            please secure your account immediately.
        </p>

        <hr style="border:0; border-top:1px solid #eee; margin:30px 0;">

        <p style="font-size:13px; color:#888;">
            © {{ date('Y') }} {{ $setting->site_name ?? 'BillVexa' }}. All rights reserved.
        </p>

    </div>

</body>

</html>