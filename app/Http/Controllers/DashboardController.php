<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdrawal;
use App\Models\Package;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalDeposits        = Deposit::where('user_id', $user->id)->where('status', 'active')->sum('amount');
        $totalWithdraw        = Withdrawal::where('user_id', $user->id)->where('status', 'active')->sum('amount');
        $deposits             = Deposit::where('status', 'pending')->get();
        $deposit_statement    = Deposit::where('user_id', $user->id)->get();
        $withdrawal_statement = Withdrawal::where('user_id', $user->id)->get();
        $withdrawals          = Withdrawal::where('status', 'pending')->get();
        $totalDeposit         = Deposit::where('status', 'pending')->sum('id');
        $totWithdraw          = Withdrawal::where('status', 'pending')->sum('id');
        $package              = Package::where('id', $user->package_id)->get();

        return view('dashboard', ['user' => $user, "totalDeposits" => $totalDeposits, "totalWithdraw" => $totalWithdraw, "withdrawals" => $withdrawals, "deposits" => $deposits, 'totalDeposit' => $totalDeposit, 'totWithdraw' => $totWithdraw, 'deposit_statement' => $deposit_statement, 'withdrawal_statement' => $withdrawal_statement, 'package' => $package]);
    }
    public function dipositupdate(Request $request, $id)
    {
        $getuserid_deposit = Deposit::select('user_id')->where('id', $id)->first();
        $getstatus = Deposit::select('status', 'amount')->where('id', $id)->first();
        if ($getstatus !== null && $getstatus->status == "pending") {
            $status = "active";
            $user = User::find($getuserid_deposit->user_id);
            $new_balance = $user->current_balance + $getstatus->amount;

            User::where('id', $getuserid_deposit->user_id)->update(['current_balance' => $new_balance]);
        } else {
            $status = $getstatus->status;
        }

        Deposit::where('id', $id)->update(['status' => $status]);
        return redirect()->route('dashboard')->with('success', 'Deposit accepted successfully.');
    }

    public function withdrawupdate(Request $request, $id)
    {
        $getuserid_withdra = Withdrawal::select('user_id')->where('id', $id)->first();
        $getstatus = Withdrawal::select('status', 'amount')->where('id', $id)->first();
        if ($getstatus !== null && $getstatus->status == "pending") {
            $status = "active";
            $user = User::find($getuserid_withdra->user_id);
            $new_balance = $user->current_balance - $getstatus->amount;
            $new_balance_w = $user->withdrawal_balance - $getstatus->amount;
            User::where('id', $getuserid_withdra->user_id)->update(['current_balance' => $new_balance, 'withdrawal_balance' => $new_balance_w]);
        } else {
            $status = $getstatus->status;
        }

        Withdrawal::where('id', $id)->update(['status' => $status]);
        return redirect()->route('dashboard')->with('success', 'Withdrawal accepted successfully.');
    }

    public function activate(Request $request, $id)
    {
        $user = Auth::user();
        $package = Package::find($id);
        if ($user->current_balance < $package->price) {
            return redirect()->route('dashboard')->with('deposit', 'Please Deposit');
        } else {
            $user->current_balance -= $package->price;
            $user->package_id = $package->id;
            $user->save();
            return redirect()->route('dashboard')->with('success', 'Package Activated Successfully');
        }
    }



    public function withdrawreject(Request $request, $id)
    {

        $getstatus = Withdrawal::select('status')->where('id', $id)->first();
        if ($getstatus->status == "active" || "pending") {
            $status = "Rejected";
        }
        Withdrawal::where('id', $id)->update(['status' => $status]);
        return redirect()->route('dashboard')->with('w_reject', 'Withdrawal Rejected!.');
    }
    public function depositreject(Request $request, $id)
    {

        $getstatus = Deposit::select('status')->where('id', $id)->first();
        if ($getstatus->status == "active" || "pending") {
            $status = "reject";
        }
        Deposit::where('id', $id)->update(['status' => $status]);
        return redirect()->route('dashboard')->with('d_reject', 'Deposit Rejected!.');
    }

    public function dipoststore(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'payment_method' => 'required|string|max:255',
            'transaction_number' => 'required|max:255',
        ]);

        $deposit = new Deposit;
        $deposit->user_id = auth()->id();
        $deposit->amount = $request->amount;
        $deposit->payment_method = $request->payment_method;
        $deposit->transaction_number = $request->transaction_number;
        $deposit->save();

        return redirect()->route('dashboard')->with('success', 'Deposit Request Pending.');
    }



    public function signout()
    {
        Auth::logout();

        return redirect()->route('signin');
    }


    public function allUser()
    {

        // return auth()->user();
        // Assuming you have a 'roles' table and a 'Role' model
        $user = User::where('role', 'customer')->get();

        return view('alluser', compact('user'));
    }
    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // Perform validation if needed
        // Update the user data
        $user->current_balance = $request->input('current_balance');
        $user->number_of_tokens = $request->input('number_of_tokens');
        $user->save();

        return redirect()->back()->with('success', 'User data updated successfully');
    }


    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function rank()
    {

        $user = User::where('subscription_status', '5')->get();

        return view('rank', compact('user'));
    }
}
