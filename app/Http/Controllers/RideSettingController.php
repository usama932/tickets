<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RideSetting;
use App\Models\RideFareRangeTokens;
use Illuminate\Support\Facades\Validator;

class RideSettingController extends Controller
{
    public function index(){
        $setting = RideSetting::with('fareRange')->latest()->first();
        return view('ride_setting.index',compact('setting'));
    }
    public function store(Request $request){

        $validator = Validator::make($request->all() ,$rules = [
            'token_price' => 'required|numeric|not_in:0',
            'ride_token' => 'required|numeric|not_in:0',
            'gift_token' => 'required|numeric|not_in:0',

            'pet_more' => 'required|numeric|not_in:0',
        ],  $messages = [
          'token_price.required' => 'The token_price field is required! and Not 0',
          'ride_token.required' => 'The ride_token field is required! and Not 0',
          'gift_token.required' => 'The gift_token field is required! and Not 0',
          'pet_more.required' => 'The pet_more field is required! and Not 0',

        ]);

        if ($validator->fails()) {
        return redirect()->back()
                    ->withErrors($validator)->with(['message' => $messages])
                    ->withInput();
        }
        $rideSettingId = '';
        if(empty($request->id)){
            $settings =  RideSetting::create([
                'token_price' => $request->token_price,
                'ride_token' => $request->ride_token,
                'gift_token' => $request->gift_token,
                'passenger_more' => $request->passenger_more ?? '',
                'luggage_more' => $request->luggage_more ?? '',
                'pet_more' => $request->pet_more,
                'package_more' => $request->package_more ?? '',
            ]);
            $rideSettingId = $settings->id;
        }
        else{
            $rideSettingId = $request->id;
            $settings =  RideSetting::where('id',$request->id)->update([
                'token_price' => $request->token_price,
                'ride_token' => $request->ride_token,
                'passenger_more' => $request->passenger_more,
                'gift_token' => $request->gift_token,
                'luggage_more' => $request->luggage_more,
                'pet_more' => $request->pet_more,
                'package_more' => $request->package_more,
            ]);
        }
        RideFareRangeTokens::where('ride_setting_id',$rideSettingId)->delete();
        $tokens = $request->token;
        $fromRange = $request->from_range;
         $toRange = $request->to_range;
        for($i = 0; $i<count($tokens); $i++){
            RideFareRangeTokens::create([
                'from_range'=>$fromRange[$i],
                'to_range'=>$toRange[$i],
                'token'=>$tokens[$i],
                'ride_setting_id'=>$rideSettingId]);
        }
        return redirect()->back()->with('Successfully Added');

    }
}
