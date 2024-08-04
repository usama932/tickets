<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Deposit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller


{
    public function __construct()
{
    $this->middleware('auth');
}




    /**
     * Show the form for creating a new deposit.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $user = Auth::user();
        return view('dashboard');
    }

    /**
     * Store a newly created deposit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
   



    /**
     * Display the specified deposit.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $deposit = Deposit::findOrFail($id);

        return view('dashboard', compact('deposit'));
    }

    /**
     * Show the form for editing the specified deposit.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $deposit = Deposit::findOrFail($id);

        return view('dashboard', compact('deposit'));
    }

    /**
     * Update the specified deposit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    

    /**
     * Remove the specified deposit from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $deposit = Deposit::findOrFail($id);
        $deposit->delete();

        return redirect()->route('dashboard')->with('success', 'Deposit deleted successfully.');
    }
}
