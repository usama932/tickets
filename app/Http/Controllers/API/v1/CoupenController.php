<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;


class CoupenController extends Controller
{
    public function store_coupon(Request $request){
        $validator = Validator::make($request->all(), $rules = [
            'code' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'expire_at' => 'required|date',
            'discription'=>'required',
        ], $messages = [
            'code.required' => 'The Code field is required!',
            'discount.required' => 'The Discount field is required!',
            'type.required' => 'The Discount Type is required!',
            'expire_at.required' => 'The Expire date field is required!',
            'discription.required' => 'The Description field is required'


        ]);

        if ($validator->fails()) {

                $response['success']= 'Failed';
                $response['error']= 'Failed to store data';
                $response['remaining_token'] = $messages;
                return response()->json($response);
        }

        $code = $request->input('code');
        $discount = $request->input('discount') ?? '';
        $type = $request->input('type');
        $expire_at = $request->input('expire_at');
        $description = $request->input('discription')  ?? 'yes';
        $user_id = auth()->user()->id;

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

            $discounts->statut = $statut;
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

        $validator = Validator::make($request->all(), $rules = [
            'code' => 'required',
            'discount' => 'required',
            'type' => 'required',
            'expire_at' => 'required|date',
            'discription'=>'required',
        ], $messages = [
            'code.required' => 'The Code field is required!',
            'discount.required' => 'The Discount field is required!',
            'type.required' => 'The Discount Type is required!',
            'expire_at.required' => 'The Expire date field is required!',
            'discription.required' => 'The Description field is required'

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }


        $code = $request->input('code');
        $discount = $request->input('discount');
        $type = $request->input('type');
        $expire_at = $request->input('expire_at');
        $description = $request->input('discription');

        $statut = $request->input('statut');
        $date = date('Y-m-d H:i:s');
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
    public function coupen(Request $request,$code){
        $discounts = Discount::where('code',$code)->first();
        if(!empty($discounts)){

            $response['success']= 'success';
            $response['error']= null;
            $response['message']= 'Successfully get';
            $response['remaining_token'] = $discounts;
        }else{
            $response['success']= 'Failed';
            $response['error']= 'Coupen Not Found';
            $response['remaining_token'] = $discounts;
        }
        return response()->json($response);
    }
}
