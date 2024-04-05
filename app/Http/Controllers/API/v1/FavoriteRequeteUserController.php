<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\FavoriteRide;
use Illuminate\Http\Request;
use DB;
class FavoriteRequeteUserController extends Controller
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
    $months = array ("January"=>'Jan',"February"=>'Feb',"March"=>'Mar',"April"=>'Apr',"May"=>'May',"June"=>'Jun',"July"=>'Jul',"August"=>'Aug',"September"=>'Sep',"October"=>'Oct',"November"=>'Nov',"December"=>'Dec');

    $id_user_app =$request->get('id_user_app');
  

    $sql = DB::table('tj_favorite_ride')
    ->select('*')
    ->where('id_user_app','=',DB::raw($id_user_app))
    ->where('statut','=','yes')
    ->orderBy('id','desc')
    ->get();
    
    // output data of each row
    foreach($sql as $row)
    {
       
        $row->creer = date("d", strtotime($row->creer))." ".$months[date("F", strtotime($row->creer))].". ".date("Y", strtotime($row->creer));

         $output[] = $row;
    }
  
        if(!empty($row)){
            $response['success']='Success';
            $response['error']= null;
            $response['data'] = $output;

        }else{
            $response['success']='Failed';
            $response['error']= 'Not Found';
        }
        //$output[] = $row;
  
        return response()->json($response);

    }
        

  
}