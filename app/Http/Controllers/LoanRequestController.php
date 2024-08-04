<?php

namespace App\Http\Controllers;

use App\Models\LoanRequest;
use App\Models\User;
use Illuminate\Http\Request;

class LoanRequestController extends Controller
{
    //

    public function loanRequest(Request $request)
    {
        $user = auth()->user();
    
        // Check if the user's subscription status is greater than or equal to 3
        if ($user->subscription_status >= 3) {
    
            // Check if the user has at least 25 tokens
            if ($user->number_of_tokens >= 25) {
    
                // Get the form input data
                $easypaisaAccountNumber = $request->input('easypaisaAccountNumber');
                $loanAmount = $request->input('loanamount');
                $loanInEarnings = $request->input('earningsCheckbox');
                $loanInEarningsAmount = $request->input('loaninearningamount');
    
                // Create a new LoanRequest object and set its properties
                $loanRequest = new LoanRequest();
                $loanRequest->user_id = $user->id;
                $loanRequest->easypaisa_account_number = $easypaisaAccountNumber;
                $loanRequest->loan_amount = $loanAmount;
                $loanRequest->loan_in_earnings = $loanInEarnings;
                $loanRequest->loan_in_earnings = $loanInEarningsAmount;
                $loanRequest->status = 'Pending';
    
                // Save the LoanRequest object to the database
                $loanRequest->save();
    
                // Redirect back with a success message (or return a JSON response, etc.)
                return redirect()->back()->with('success', 'Loan request submitted successfully.');
            } else {
                // Redirect back with an error message (not enough tokens)
                return redirect()->back()->with('error', 'You must have at least 25 tokens to avail the loan.');
            }
        } else {
            // Redirect back with an error message (subscription status is not eligible)
            return redirect()->back()->with('error', 'You should be in subscription status 3 or above to avail the loan.');
        }
    }
    

    public function loanrequestview()
    {
        $loanRequests =  LoanRequest::where('status', 'Pending')->get(); // Retrieve all loan request records from the database
    
        return view('loanrequestview', compact('loanRequests'));
    }



    public function approveLoanRequest($id)
    {
        // Find the loan request by its ID
        $loanRequest = LoanRequest::findOrFail($id);
    
        // Check if the loan request status is "Pending"
        if ($loanRequest->status === 'Pending') {
            // Update the loan request status to "Approved"
            $loanRequest->status = 'Approved';
            $loanRequest->save();
    
            // Get the user associated with the loan request
            $user = $loanRequest->user;
    
            // Increase the user's current_balance by the loan_in_earning amount
            $user->current_balance += $loanRequest->loan_in_earnings;
    
            // Update the total_balance by adding the loan_in_earning amount
            $user->total_balance = $user->current_balance + $user->loan_in_earnings;
            $user->save();
    
            // Redirect back with a success message (or return a JSON response, etc.)
            return redirect()->back()->with('success', 'Loan request approved successfully.');
        } else {
            // Redirect back with an error message (loan request is not pending)
            return redirect()->back()->with('error', 'Loan request is already processed or not pending.');
        }
    }
    
    
}


