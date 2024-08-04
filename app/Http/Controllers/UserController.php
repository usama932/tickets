<?php

namespace App\Http\Controllers;

use App\Mail\RegisterationMail;
use App\Models\User;
use App\Models\Deposit;
use App\Models\Package;
use App\Models\Withdrawal;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Handle user sign up request
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function showSignUpForm()
    {
        return view('signup');
    }
    public function showSigninForm()
    {
        return view('signin');
    }


    public function signup(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
            'referrer_id' => 'nullable|string',

        ]);

        if ($validator->fails()) {

            return view('signup')->withErrors($validator);
        }

        if ($request->has('referrer_id')) {
            $referrer = User::where('referral_code', $request->referrer_id)->first();
            if ($referrer) {
                // If the referral code exists, set the referrer_id for the new user
                $referrer_id = $referrer->id;
            } else {
                // If the referral code doesn't exist, set referrer_id to null
                $referrer_id = null;
            }
        } else {
            // If no referral code is provided, set referrer_id to null
            $referrer_id = null;
        }

        // Generate a unique referral code
        $referral_code = $this->generateUniqueReferralCode();

        $user = new User([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'customer',
            'status' => 'active',
            'referral_code' => $referral_code,
            'referrer_id' => $referrer_id,
        ]);

        $user->save();
        Mail::send(new RegisterationMail($user));
        return redirect('/')->with('registeration_success', 'Your account has been registered successfully. Please login to continue');
    }


    // Function to generate a unique referral code
    private function generateUniqueReferralCode()
    {
        $referral_code = Str::random(6);

        // Check if the generated referral code already exists in the database
        while (User::where('referral_code', $referral_code)->exists()) {
            $referral_code = Str::random(6);
        }

        return $referral_code;
    }



    /**
     * Handle user sign in request
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return view('signup')->withErrors($validator);
        }

        $credentials = $request->only(['email', 'password']);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        if ($user->status === 'suspended') {
            return redirect()->back()->with(['message' => 'Your account is suspended. Please contact the admin for assistance.']);
        }

        $token = $user->createToken('AuthToken')->accessToken;

        return redirect()->route('dashboard')->with(['token' => $token]);
    }

    public function myTeam()
    {
        $user = auth()->user();
        $teamMembers = User::where('referrer_id', $user->id)->get();
        $teamLeader = null;
        if ($teamMembers->isNotEmpty()) {
            $teamLeader = User::find($teamMembers->first()->referrer_id);
        }

        // Retrieve team members where referrer_id is equal to the user's id

        return view('myteam', compact('teamLeader', 'teamMembers'));
    }

    public function suspend($id)
    {
        $user = User::find($id);
        if (!$user) {
            // Handle user not found, show an error message or redirect as needed.
        }

        $user->update(['status' => 'suspended']);

        // Optionally, you can redirect back with a success message
        return redirect()->back()->with('status', 'User suspended successfully.');
    }

    public function activate($id)
    {
        $user = User::find($id);
        if (!$user) {
            // Handle user not found, show an error message or redirect as needed.
        }

        $user->update(['status' => 'active']);

        // Optionally, you can redirect back with a success message
        return redirect()->back()->with('status', 'User activated successfully.');
    }
}
