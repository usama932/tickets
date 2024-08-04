<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function forgotPasswordForm()
    {
        return view('forgot_password');
    }

    public function findAccount(Request $request)
    {
        // return $request;
        $customMessages = [
            'email.exists' => "We can't find a user with that email address.",
        ];

        $request->validate([
            'email' =>  'required|email|exists:users',
        ], $customMessages);

        $token =  Str::random(64);
        DB::table('password_resets')->updateOrInsert(
            [
                'email' => $request->email,
            ],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );
        // $url = url('/') . 'reset-password/' . '?email=' . $request->email . '&token=' . $token;
        $url=route('resetPasswordForm').'?email=' . $request->email . '&token=' . $token;
        $email_template = 'email_template.client.reset-password';

        Mail::send(new ResetPasswordMail($url, $request->email));
        return redirect()->back()->with('password_success', 'Reset Password Email Sent Successfully');
    }


    public function showResetPasswordForm()
    {
        return view('reset_password');
    }


    public function submitResetPasswordForm(Request $request)
    {

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();
        if (!$updatePassword) {
            return redirect()->back()->with('password_error', 'Token Expired');
        }
        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('home')->with('password_success', 'Your password has been changed! Please login to continue.');
    }
}
