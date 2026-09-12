<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    public function download(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $transaction->load('user');

        $setting = \App\Models\Setting::first();

        $pdf = Pdf::loadView(
            'BillVexa.Dashboard.receipt',
            compact('transaction', 'setting')
        );

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'BillVexa-Receipt-' . $transaction->reference . '.pdf'
        );
    }
}