<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverCurrentLocationController extends Controller
{
    public function currentLocation($driver_id)
    {
        try {
            $driver = DB::table('tj_conducteur')->where('id', $driver_id)->first();
            if (!is_null($driver)) {
                    $driverFind = DB::table('tj_conducteur')->where('id',$driver_id)->select('latitude','longitude','heading')->first();
                $response['success'] = 'Success';
                $response['error'] = null;
                $response['message'] = 'Successfully fetched data';
                $response['data'] = $driverFind;
                return response()->json($response);
            } else {
                $response['success'] = 'failure';
                $response['error'] = 'Driver not found';
                $response['message'] = 'Failed to find driver';
                $response['data'] = null;
                return response()->json($response, 404);
            }
        } catch (\Exception $exception) {
            return response()->json([$exception->getLine(), $exception->getMessage()], 500);
        }
    }
}
