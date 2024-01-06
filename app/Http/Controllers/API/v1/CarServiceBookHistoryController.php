<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\VehicleServiceBook;
use Illuminate\Http\Request;
use DB;
class CarServiceBookHistoryController extends Controller
{

   public function __construct()
   {
      $this->limit=20;
   }
  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

  public function getData(Request $request)
  {

    $id_user =$request->get('id_driver');
    if(!empty($id_user)){
    $sql = DB::table('tj_vehicule_service_book')
    ->select('*')
    ->where('id_conducteur','=',DB::raw($id_user))
    ->orderBy('id','desc')
    ->get();;

    // output data of each row
    foreach($sql as $row)
    {
        $row->photo_car_service_book = '';
        // $car = $row->photo_car_service_book_path;
        if($row->photo_car_service_book_path != ''){
          if(file_exists('assets/images/vehicule'.'/'.$row->photo_car_service_book_path ))
          {
              $car = asset('my-assets/images/vehicule').'/'. $row->photo_car_service_book_path;
          }
          else
          {
              $car = asset('assets/images/placeholder_image.jpg');

          }
          $row->photo_car_service_book_path = $car;
      }
        $output[] = $row;
    }


    if(!empty($row)){
        $response['success']= 'success';
        $response['error']= null;
        $response['message'] = 'Successfully';
        $response['data'] = $output;

    }else{
        $response['success']= 'Failed';
        $response['error']= 'Failed to fetch data';
    }
  }
  else{
    $response['success']= 'Failed';
    $response['error']= 'Not Found';
  }  return response()->json($response);

    }



}
