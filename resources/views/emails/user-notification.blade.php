<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>{{ $title }}</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto;">

        <div style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

            <div style="background:#0d6efd; padding:25px; text-align:center;">

                <h2 style="margin:0; color:#ffffff;">
                    BillVexa
                </h2>

            </div>

            <div style="padding:30px;">

                <h3 style="margin-top:0;">
                    {{ $title }}
                </h3>

                <p style="font-size:15px; line-height:1.7; color:#555;">

                    {!! nl2br(e($notificationMessage)) !!}

                </p>

                <hr style="border:0; border-top:1px solid #eee; margin:25px 0;">

                <p style="font-size:13px; color:#999; margin-bottom:0;">

                    This is an automated notification from BillVexa.

                </p>

            </div>

        </div>

    </div>

</body>

</html>