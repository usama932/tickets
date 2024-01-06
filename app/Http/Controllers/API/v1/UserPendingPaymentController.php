<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use DB;
class UserPendingPaymentController extends Controller
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
  

  public function userpayment(Request $request)
  {
   
        $user_id = $request->get('user_id');
     
        $query = DB::table('tj_requete')
            ->select('montant', 'statut', 'id')
            ->where('id_user_app','=',DB::raw($user_id))
            ->where('statut_paiement','=','')
            ->get();

        $amount = 0;

        foreach ($query as $row){
            if($row->statut=="completed"){
                $amount = $amount + $row->montant;
            }
            $row->amount = $amount;
        }
        if(!empty($row))
        {
            $response['success']= 'success';
            $response['error']= null;
            $response['message'] = 'Successfully fetch data';
            $response['data'] = $row;
        }
        else {
            $response['success']= 'Failed';
            $response['error']= 'Failed to fetch data';
        }
   return response()->json($response);
  }
}