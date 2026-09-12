
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $setting->site_name ?? 'BillVexa' }} Transaction Update</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f9; font-family:Arial, Helvetica, sans-serif;">

    <div style="max-width:600px; margin:30px auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

        <!-- Header -->
        <div style="background:#5b2cff; padding:25px; text-align:center; color:#ffffff;">
            <h1 style="margin:0; font-size:28px;">
            {{ $setting->site_name ?? 'BillVexa' }}
            </h1>

            <p style="margin:8px 0 0;">
                Transaction Update
            </p>
        </div>

        <!-- Body -->
        <div style="padding:30px;">

            <h2 style="margin-top:0; color:#222;">
                Transaction {{ ucfirst($action) }}
            </h2>

            <p style="font-size:15px; color:#555; line-height:1.6;">
                Hello {{ $transaction->user->name ?? 'Customer' }},
            </p>

            @if($action === 'approved')

                <p style="font-size:15px; color:#555; line-height:1.6;">
                    Your transaction has been <strong>approved successfully</strong>.
                </p>

            @elseif($action === 'reversed')

                <p style="font-size:15px; color:#555; line-height:1.6;">
                    Your transaction has been <strong>reversed</strong> by {{ $setting->site_name ?? 'BillVexa' }}.
                </p>

            @elseif($action === 'refunded')

                <p style="font-size:15px; color:#555; line-height:1.6;">
                    Your transaction has been <strong>refunded</strong>.
                    The refunded amount has been returned to your wallet.
                </p>

            @endif

            <!-- Transaction Details -->
            <div style="background:#f8f9fa; border-radius:8px; padding:20px; margin:25px 0;">

                <p style="margin:8px 0;">
                    <strong>Service:</strong>
                    {{ $transaction->service }}
                </p>

                <p style="margin:8px 0;">
                    <strong>Amount:</strong>
                    ₦{{ number_format($transaction->total, 2) }}
                </p>

                <p style="margin:8px 0;">
                    <strong>Reference:</strong>
                    {{ $transaction->reference }}
                </p>

                <p style="margin:8px 0;">
                    <strong>Status:</strong>
                    {{ ucfirst($transaction->status) }}
                </p>

                <p style="margin:8px 0;">
                    <strong>Date:</strong>
                    {{ $transaction->updated_at->format('d M Y, h:i A') }}
                </p>

            </div>

            <p style="font-size:14px; color:#666; line-height:1.6;">
                If you did not expect this transaction update, please contact
                {{ $setting->site_name ?? 'BillVexa' }} support.
            </p>

            <p style="margin-top:30px; color:#555;">
                Thank you for using <strong>{{ $setting->site_name ?? 'BillVexa' }}</strong>.
            </p>

        </div>

        <!-- Footer -->
        <div style="background:#f1f1f1; padding:20px; text-align:center; color:#777; font-size:13px;">

            <p style="margin:0;">
                © {{ date('Y') }} {{ $setting->site_name ?? 'BillVexa' }}. All rights reserved.
            </p>

        </div>

    </div>

</body>
</html>

