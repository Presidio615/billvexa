<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>BillVexa Receipt</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f4f6f8;
            color: #222;
            margin: 0;
            padding: 30px;
        }

        .receipt {
            width: 100%;
            max-width: 700px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #5b2cff;
            padding-bottom: 20px;
            margin-bottom: 25px;
        }

        .logo {
            font-size: 30px;
            font-weight: bold;
            color: #5b2cff;
        }

        .subtitle {
            color: #777;
            font-size: 13px;
            margin-top: 5px;
        }

        .status {
            text-align: center;
            margin: 20px 0;
        }

        .status-success {
            display: inline-block;
            padding: 8px 18px;
            background: #e8f8ee;
            color: #16803c;
            border-radius: 20px;
            font-weight: bold;
        }

        .status-pending {
            display: inline-block;
            padding: 8px 18px;
            background: #fff4d6;
            color: #946200;
            border-radius: 20px;
            font-weight: bold;
        }

        .status-failed {
            display: inline-block;
            padding: 8px 18px;
            background: #fdeaea;
            color: #b42318;
            border-radius: 20px;
            font-weight: bold;
        }

        .amount-box {
            text-align: center;
            background: #f7f5ff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .amount-label {
            font-size: 13px;
            color: #777;
        }

        .amount {
            font-size: 28px;
            font-weight: bold;
            color: #5b2cff;
            margin-top: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 12px 5px;
            border-bottom: 1px solid #eeeeee;
            font-size: 13px;
        }

        td:first-child {
            color: #777;
            width: 40%;
        }

        td:last-child {
            text-align: right;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            color: #777;
            font-size: 11px;
        }

        .reference {
            word-break: break-all;
        }
    </style>
</head>

<body>

    <div class="receipt">

        {{-- Header --}}
        <div class="header">
            <div class="logo">
                {{ $setting->site_name ?? 'BillVexa' }}
            </div>

            <div class="subtitle">
                Transaction Receipt
            </div>
        </div>


        {{-- Status --}}
        <div class="status">

            @if(in_array($transaction->status, ['successful', 'success']))

                <span class="status-success">
                    ✓ Transaction Successful
                </span>

            @elseif($transaction->status === 'pending')

                <span class="status-pending">
                    ⏳ Transaction Pending
                </span>

            @else

                <span class="status-failed">
                    ✕ Transaction {{ ucfirst($transaction->status) }}
                </span>

            @endif

        </div>


        {{-- Amount --}}
        <div class="amount-box">

            <div class="amount-label">
                Total Paid
            </div>

            <div class="amount">
                ₦{{ number_format($transaction->total, 2) }}
            </div>

        </div>


        {{-- Transaction Details --}}
        <table>

            <tr>
                <td>Customer</td>
                <td>
                    {{ $transaction->user->name ?? 'Customer' }}
                </td>
            </tr>

            <tr>
                <td>Service</td>
                <td>
                    {{ $transaction->service }}
                </td>
            </tr>

            @if($transaction->network)

                <tr>
                    <td>Network / Provider</td>
                    <td>
                        {{ $transaction->network }}
                    </td>
                </tr>

            @endif

            @if($transaction->phone)

                <tr>
                    <td>Phone</td>
                    <td>
                        {{ $transaction->phone }}
                    </td>
                </tr>

            @endif

            <tr>
                <td>Transaction Type</td>
                <td>
                    {{ ucfirst($transaction->type) }}
                </td>
            </tr>

            <tr>
                <td>Amount</td>
                <td>
                    ₦{{ number_format($transaction->amount, 2) }}
                </td>
            </tr>

            @if($transaction->discount > 0)

                <tr>
                    <td>Discount</td>
                    <td>
                        ₦{{ number_format($transaction->discount, 2) }}
                    </td>
                </tr>

            @endif

            <tr>
                <td>Total</td>
                <td>
                    ₦{{ number_format($transaction->total, 2) }}
                </td>
            </tr>

            <tr>
                <td>Status</td>
                <td>
                    {{ ucfirst($transaction->status) }}
                </td>
            </tr>

            <tr>
                <td>Reference</td>
                <td class="reference">
                    {{ $transaction->reference }}
                </td>
            </tr>

            <tr>
                <td>Date</td>
                <td>
                    {{ $transaction->created_at->format('d M Y, h:i A') }}
                </td>
            </tr>

        </table>


        {{-- Footer --}}
        <div class="footer">

            <p>
                Thank you for using
                <strong>{{ $setting->site_name ?? 'BillVexa' }}</strong>.
            </p>

            <p>
                This is an electronically generated receipt.
            </p>

        </div>

    </div>

</body>

</html>