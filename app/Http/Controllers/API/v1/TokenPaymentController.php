<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TokenPayment;
use App\Models\RemainingToken;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Models\CouponUse;
use App\Models\UserCard;
use App\Models\RideSetting;
use Stripe\Stripe;
use Stripe\Balance;
use Stripe\Customer;
use Stripe\Token;



class TokenPaymentController extends Controller
{
    public function token_pay(Request $request){

        //Stripe\Stripe::setApiKey('sk_test_51M1CQcBXbn9BsZ0hPR23i3B0mIBWnYI9rX1woVhgMyjT81ySeRUhX3BPwUQluen4ku4ljsI2ydOpGCS5ZNqdd3BO00y60S864r');

        // $stripe = Stripe\Charge::create ([
        //         "amount" => $request->amount * 100,
        //         "currency" => "usd",
        //         "source" => $request->stripeToken,
        //         "description" => "Test payment from itsolutionstuff.com."
        // ]);


            $token = TokenPayment::create([
                'user_id'   =>  $request->user_id,
                'stripe_id' =>  $request->stripe_id,
                'tokens'    => $request->tokens,
                'amount'    => $request->amount,
            ]);

            if($token){
                $rem =RemainingToken::where('user_id',$token->user_id)->first();
                if(empty($rem)){
                    RemainingToken::create([
                        'user_id'   =>  $request->user_id,
                        'tokens'    => $request->tokens
                    ]);
                }
                else{
                    RemainingToken::where('user_id',$token->user_id)->update([
                        'tokens'    => $rem->tokens + $request->tokens
                    ]);
                }

            }
            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully';
            $response['remaining_token'] = $rem;

        return response()->json($response);

    }
    public function remain_token(Request $request){


        $rem =RemainingToken::where('user_id',$request->user_id)->first();

        if(!empty($rem)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully';
            $response['remaining_token'] = $rem;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'Failed to fetch data';
            $response['remaining_token'] = $rem;
        }
        return response()->json($response);
    }

    public function store_coupon(Request $request){


        $code = $request->input('code');
        $discount = $request->input('discount');
        $type = $request->input('type');
        $expire_at = $request->input('expire_at');
        $description = $request->input('discription');
        $user_id = $request->input('user_id');

        $statut = $request->input('statut');
        $date = date('Y-m-d H:i:s');
        if ($statut == "on") {
            $statut = "yes";
        } else {
            $statut = "no";
        }

        $discounts = new Discount;

        if ($discounts) {
            $discounts->code = $code;
            $discounts->discount = $discount;
            $discounts->type = $type;
            $discounts->expire_at = $expire_at;
            $discounts->discription = $description;
            $discounts->user_id = $user_id;

            $discounts->statut = "yes";
            $discounts->creer = $date;
            $discounts->modifier = $date;
            $discounts->save();
        }


        if(!empty($discounts)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully Stored';
            $response['remaining_token'] = $discounts;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'Failed to store data';
            $response['remaining_token'] = $discounts;
        }
        return response()->json($response);
    }
    public function updateDiscount(Request $request, $id){

        $code = $request->input('code') ?? '';
        $discount = $request->input('discount')?? '';
        $type = $request->input('type') ?? '';
        $expire_at = $request->input('expire_at') ?? '';
        $description = $request->input('discription') ?? '';

        $statut = $request->input('statut') ?? '';
        $date = date('Y-m-d H:i:s') ;
        if ($statut == "on") {
            $statut = "yes";
        } else {
            $statut = "no";
        }

        $discounts = Discount::find($id);

        if ($discounts) {
            $discounts->code = $code;
            $discounts->discount = $discount;
            $discounts->type = $type;
            $discounts->expire_at = $expire_at;
            $discounts->discription = $description;

            $discounts->statut = $statut;
            $discounts->modifier = $date;
            $discounts->save();
        }
        if(!empty($discounts)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully update';
            $response['remaining_token'] = $discounts;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'Failed to supdatetore data';
            $response['remaining_token'] = $discounts;
        }
        return response()->json($response);

    }
    public function get_coupen($id){
        $discounts = Discount::find($id);
        if(!empty($discounts)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully get';
            $response['remaining_token'] = $discounts;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'Failed to get data';
            $response['remaining_token'] = $discounts;
        }
        return response()->json($response);

    }
    public function get_user_coupon($user_id){
        $discounts = Discount::where('user_id',$user_id)->first();
        if(!empty($discounts)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully get';
            $response['remaining_token'] = $discounts;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'Failed to get data';
            $response['remaining_token'] = $discounts;
        }
        return response()->json($response);

    }
    public function coupen(Request $request,$code){
        $discounts = Discount::where('code',$code)->first();

        if(!empty($discounts)){
            $coupon = CouponUse::where('user_id', $request->user_id)
                                ->where('driver_id',$discounts->user_id)
                                ->where('coupon_id',$discounts->id)->first();
            if(empty($coupon)){
                CouponUse::create([
                    'driver_id' => $discounts->user_id,
                    'coupon_id' => $discounts->id,
                    'user_id'  => $request->user_id
                ]);
                $token_gift = RideSetting::latest()->first();
                $rem = RemainingToken::where('user_id',$discounts->user_id)->first();
                $rem->tokens = $rem->tokens +  $token_gift->gift_token;
                $rem->save();

                $response['success']= 'success';
                $response['error']= null;
                $response['message']= 'Successfully get';
                $response['remaining_token'] = $discounts;
            }
            else{
                $response['success']= 'success';
                $response['error']= 's';
                $response['message']= 'You Alreadt Get Award .!!';

            }

        }else{
            $response['success']= 'Failed';
            $response['error']= 'Coupen Not Found';
            $response['remaining_token'] = $discounts;
        }
        return response()->json($response);
    }
    public function settings(){
        $setting = RideSetting::with('fareRange')->latest()->first();
        if(!empty($setting)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully get setting';
            $response['remaining_token'] = $setting;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'setting Not Found';
            $response['remaining_token'] = $setting;
        }
        return response()->json($response);
    }
    public function check_balance(Request $request){
        $customerId = $request->input('customer_id');

        // Set the Stripe API secret key
        Stripe::setApiKey("sk_test_51M1CQcBXbn9BsZ0hPR23i3B0mIBWnYI9rX1woVhgMyjT81ySeRUhX3BPwUQluen4ku4ljsI2ydOpGCS5ZNqdd3BO00y60S864r");
        $cardNumber = $request->card_number;
        $exp_month = $request->exp_month;
        $exp_year = $request->exp_year;
        $cvc = $request->cvc;

            // Create a new Stripe customer with the provided card
            $token = Token::create([
                'card' => [
                    'number' => $cardNumber,
                    'exp_month' => $exp_month,
                    'exp_year' => $exp_year,
                    'cvc' => $cvc,
                ],
            ]);

            // Create a new Stripe customer using the token
            $customer = Customer::create([
                'source' => $token->id,
            ]);

            // Retrieve the customer's balance (you may need to adapt this part depending on your Stripe setup)
            $balance = $customer->balance;

            // Check if the client has a balance of ten
            if ($balance >= 10) {


                $bal = UserCard::where('user_id',$request->customer_id)->first();
                if($bal != Null){
                    $bal = UserCard::where('user_id',$request->customer_id)->update([
                        'cvc' => $cvc,
                        'card_number' =>  $cardNumber,
                        'exp_month' => $exp_month,
                        'exp_year' => $exp_year,
                        'balance' => $balance,
                        'card_name' =>$request->card_name ?? '',
                    ]);
                }
                else{
                    $bal = UserCard::create([
                        'cvc' => $cvc,
                        'card_number' =>  $cardNumber,
                        'exp_month' => $exp_month,
                        'exp_year' => $exp_year,
                        'balance' => $balance,
                        'user_id' => $customerId,
                        'card_name' =>$request->card_name ?? '',
                    ]);
                }
                $payment = TRUE;


                $response['success']= 'success';
                $response['error']= null;
                $response['message']= 'Balance getted'.$balance;
                $response['balance'] = $payment;


            } else {
                $payment = FALSE;


                $response['success']= 'success';
                $response['error']= null;
                $response['message']= 'balance is zero plz recharge';
                $response['balance'] = $payment;
            }
            return response()->json($response);
        // } catch (\Stripe\Exception\CardException $e) {
        //     $response['success']= 'success';
        //     $response['error']= null;
        //     $response['message']= $e;

        // } catch (\Stripe\Exception\RateLimitException $e) {
        //     $response['success']= 'success';
        //     $response['error']= null;
        //     $response['message']= $e;
        // } catch (\Stripe\Exception\InvalidRequestException $e) {
        //     $response['success']= 'success';
        //     $response['error']= null;
        //     $response['message']= $e;
        // } catch (\Stripe\Exception\AuthenticationException $e) {
        //     $response['success']= 'success';
        //     $response['error']= null;
        //     $response['message']= $e;
        // } catch (\Stripe\Exception\ApiConnectionException $e) {
        //     $response['success']= 'success';
        //     $response['error']= null;
        //     $response['message']= $e;
        // } catch (\Stripe\Exception\ApiErrorException $e) {
        //     $response['success']= 'success';
        //     $response['error']= null;
        //     $response['message']= $e;
        // }
    }
}
