<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class WithdrawalController extends Controller
{
    public function showWithdrawalForm(User $user)
{
     $totalwithraw = Deposit::where('user_id', $user->id)->sum('amount');
    return view('dashboard', compact('totalwithraw'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'amount' => 'required|numeric',
        'payment_method' => 'required|string',
        'account_number' => 'required|string',
    ]);
    $validatedData['status'] = 'pending';
    $validatedData['user_id'] = Auth::user()->id;

    Withdrawal::create($validatedData);

    return redirect()->route('dashboard')->with('success', 'Withdrawal Request Pending.');
}




}
