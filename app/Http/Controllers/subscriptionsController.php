<?php

namespace App\Http\Controllers;

use DB;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\TokkenRequest;

class SubscriptionsController extends Controller
{
    public function subscriptionsView()
    {
        return view('Subscriptions');
    }

    public function subscriptionsfiveparts()
    {
        return view('subscriptionsfiveparts');
    }

    public function investment_option()
    {
        return view('investment_option');
    }

    public function activateSubscription(Request $request)
    {
        $user = auth()->user();
        $currentStatus = $user->subscription_status;
       
        if ($currentStatus === null || $currentStatus <= 5) {
          
            $requestedStatus = $request->input('status');
            $subscriptionPrice = $request->input('price');
        
            // Validate the requested status
            if ($requestedStatus <= $currentStatus + 1) {
               
                return redirect()->back()->with('error', 'You can only purchase the next Subscription Rank.');
            }
        
           
            if ( $user->current_balance < $subscriptionPrice) {
               
                return redirect()->back()->with('error', 'Your current balance is low to buy this subscription.');
            }
          
            $salmanReward = $subscriptionPrice * 0.25;
            $aliReward = $subscriptionPrice * 0.125;
        
            // Retrieve referrer details
            $teamMember = $user->referrer_id ? User::find($user->referrer_id) : null;
            $teamLeader = $teamMember ? User::find($teamMember->referrer_id) : null;
        
            // Update current_balance for the user
            $user->decrement('current_balance', $subscriptionPrice);
       
            // Update balances and tokens for the team member
            if ($teamMember) {
                $teamMember->increment('total_balance', $salmanReward);
                $teamMember->increment('current_balance', $salmanReward);
        
                if ($requestedStatus === '1') {
                    $teamMember->increment('number_of_tokens');
                }
            }
        
            // Update balances for the team leader
            if ($teamLeader) {
                $teamLeader->increment('total_balance', $aliReward);
                $teamLeader->increment('current_balance', $aliReward);
            }
        
            // Save subscription record
            Subscription::create([
                'price' => $subscriptionPrice,
                'status' => $requestedStatus,
                'user_id' => $user->id,
                'created_at' => now(),
            ]);
        
            // Update user's subscription status
            $user->update(['subscription_status' => $requestedStatus]);
        
            return redirect()->back()->with('success', 'Rank Updated successfully');
        }
        
        return redirect()->back()->with('error', 'Something went wrong.');
        
     
    }
    
    public function tokkenRequest(Request $request)
    {
        $tokkenRequest = new TokkenRequest();
        $tokkenRequest->user_id = auth()->user()->id;
        $tokkenRequest->number_of_tokens = $request->numberOfTokens;
        $tokkenRequest->total_price = $request->totalPrice;
        $tokkenRequest->payment_method = $request->paymentMethod;
        $tokkenRequest->transaction_number = $request->transactionnumber;
        $tokkenRequest->status = 'Pending'; // You can set the status as pending by default, or change it based on your logic
        $tokkenRequest->save();

        return back()->with('success', 'Purchase request submitted successfully.');
    }

    public function activateTokenRequest($id)
    {
        $request = TokkenRequest::findOrFail($id);

        if ($request->status === 'Pending') {
            $request->status = 'Active';
            $request->save();

            $user = User::find($request->user_id);
            if ($user) {
                $user->number_of_tokens += $request->number_of_tokens;
                $user->save();
            }
        }

        return back()->with('success', 'Token request has been activated successfully.');
    }

    public function accepttokenrequest()
    {
        $pendingRequests = TokkenRequest::with('user')->where('status', 'pending')->get();
        return view('tokenrequests', compact('pendingRequests'));
    }
}
