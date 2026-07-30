<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function index()
    {
        $accounts = BankAccount::latest()->get();

        return view('admin.bank-accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'type' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
            'qr_code' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('qr_code')) {
            $path = $request->file('qr_code')->store('qr-codes', 'public');
        }

        BankAccount::create([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'type' => $request->type,
            'instructions' => $request->instructions,
            'qr_code' => $path,
            'status' => true,
        ]);

        return redirect()
            ->route('bank-accounts.index')
            ->with('success', 'Bank account added successfully.');
    }

    public function edit(BankAccount $bank_account)
    {
        return view('admin.bank-accounts.edit', compact('bank_account'));
    }

    public function update(Request $request, BankAccount $bank_account)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:20',
            'type' => 'nullable|string|max:100',
            'instructions' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $bank_account->update($request->only([
            'bank_name',
            'account_name',
            'account_number',
            'type',
            'instructions',
            'status',
        ]));

        return redirect()
            ->route('bank-accounts.index')
            ->with('success', 'Bank account updated.');
    }

    public function destroy(BankAccount $bank_account)
    {
        $bank_account->delete();

        return back()->with('success', 'Bank account deleted.');
    }
}
