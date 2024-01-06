<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\DriverModel;
use App\Models\VehicleType;
use App\Models\Commission;
use App\Models\Vehicle;

use Illuminate\Http\Request;
use DB;

class DriversVehicleController extends Controller
{

    public function __construct()
    {
        $this->limit = 20;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(Request $request)
    {
        $id_driver = $request->get('id_driver');
        // $sql = DB::table('tj_vehicule')
        // ->select('*')
        // ->where('tj_vehicule.id_conducteur','=',DB::raw($id_driver))
        // ->where('tj_vehicule.statut','=','yes')
        // ->first();
        $sql = Vehicle::where('id_conducteur', $id_driver)->where('tj_vehicule.statut', '=', 'yes')->first();
        $sql['brand'] =  $sql->brand_name;
        $sql['model'] = $sql->model_name;
        $tyep = VehicleType::where('id', $sql->id_type_vehicule)->first();
        if (!empty($sql->car_image)) {
            $car_image = asset('assets/images/vehicle').'/'.$sql->car_image;
        } else {
            $car_image = asset('assets/images/placeholder_image.jpg');

        }
        if (  !empty($sql->image)) {
            $image_path = asset('assets/images/type_vehicle') . '/' . $tyep->image;
        } else {
            $image_path = asset('assets/images/placeholder_image.jpg');

        }
        if (!empty($tyep->selected_image)) {
            $selected_image_path = asset('assets/images/type_vehicle') . '/' . $tyep->selected_image;
        } else {
            $selected_image_path = asset('assets/images/placeholder_image.jpg');

        }
        $tyep['image'] = $image_path;
        $tyep['selected_image'] = $selected_image_path;
        $sql['category'] = $tyep;
        $sql['car_image'] = $car_image;
        $row = $sql->toArray();

        if (!empty($row)) {
            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'Successfully';
            $response['data'] = $row;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'No Data Found';
            $response['message'] = null;
        }
        return response()->json($response);
    }

}
