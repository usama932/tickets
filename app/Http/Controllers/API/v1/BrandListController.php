<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use DB;
class BrandListController extends Controller
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
  public function index()
  {
    
    $driver = Vehicle::all();
    $driver = Vehicle::paginate($this->limit);
    return response()->json($driver);
  }

  public function getData(Request $request)
  {
         
    //  $vehicle_type = $request->get('vehicle_type');

        $chkdriver = DB::table('brands')
        ->select('id','name')
        ->where('status','=','yes')
        // ->where('vehicle_id','=',$vehicle_type)
        ->get();

      if(!empty($chkdriver))
      {
       $row = $chkdriver->toArray();
       //$output[]=$row;
        $response['success']= 'success';
        $response['error']= null;
        $response['message']= 'Brand fetch successful';
        $response['data'] = $row;
        } else {
            $response['success']= 'Failed';
            $response['error']= 'Error while fetch data';
        }

            
        
    return response()->json($response);
  }

}