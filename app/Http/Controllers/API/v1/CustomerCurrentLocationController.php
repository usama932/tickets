<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerCurrentLocationController extends Controller
{
    public function updateLocation(Request $request)
    {
        try {
            $customer = DB::table('tj_user_app')->where('id', $request->get('customer_id'))->first();
            if (!is_null($customer)) {
                if (!is_null(DB::table('live_customer_location')->where('customer_id',$request->get('customer_id'))->first())) {
                    DB::table('live_customer_location')->update([
                        'location' => $request->get('location'),
                        'customer_id' => $request->get('customer_id'),
                        'destination'=>$request->get('destination')
                    ]);

                } else {
                    DB::table('live_customer_location')->insert(['location' => $request->get('location'), 'customer_id' => $request->get('customer_id')]);
                }
                $updatedData = DB::table('live_customer_location')
                    ->where('customer_id', $request->get('customer_id'))
                    ->first();
                $response['success'] = 'Success';
                $response['error'] = null;
                $response['message'] = 'Successfully fetched data';
                $response['data'] = $updatedData;
                return response()->json($response);
            } else {
                $response['success'] = 'failure';
                $response['error'] = 'customer not found';
                $response['message'] = 'Failed to find customer';
                $response['data'] = null;
                return response()->json($response, 404);
            }
        } catch (\Exception $exception) {
            return response()->json([$exception->getLine(), $exception->getMessage()], 500);
        }
    }
}
