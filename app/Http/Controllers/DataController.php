<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('service', 'Data')
            ->latest()
            ->take(5)
            ->get();

        return view('BillVexa.Dashboard.Quick.data', compact('transactions'));
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'network' => 'required',
            'phone'   => 'required|digits:11',
            'plan'    => 'required',
            'amount'  => 'required|numeric|min:100',
        ]);

        $user = Auth::user();

        if ($user->wallet_balance < $request->amount) {
            return back()
                ->with('error', 'Insufficient wallet balance.')
                ->withInput();
        }

        DB::beginTransaction();

        try {

            // Deduct wallet
            $user->wallet_balance -= $request->amount;
            $user->save();

            // Save transaction
            Transaction::create([
                'user_id'   => $user->id,
                'reference' => 'DATA-' . strtoupper(Str::random(10)),
                'service'   => 'Data',
                'type'      => $request->plan,
                'network'   => $request->network,
                'phone'     => $request->phone,
                'amount'    => $request->amount,
                'status'    => 'Successful',
            ]);

            // Notification
            Notification::create([
                'user_id' => $user->id,
                'title'   => 'Data Purchase',
                'message' => 'Your ' .
                    $request->plan .
                    ' data purchase of ₦' .
                    number_format($request->amount, 2) .
                    ' was successful.',
                    'link' => route('history')
            ]);

            DB::commit();

            return redirect()
                ->route('data')
                ->with('success', 'Data bundle purchased successfully.');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Transaction failed.');
        }
    }
}