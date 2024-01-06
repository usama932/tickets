<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\Driver;
use Illuminate\Http\Request;
use DB;
class AddAmountController extends Controller
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
  public function register(Request $request)
  {
    $id_user = $request->get('id_user');
    $cat_user = $request->get('cat_user');
    $amount_init =$request->get('amount');
    $paymethod = $request->get('paymethod');
    $transaction =$request->get('transaction_id');

    $date_heure = date('Y-m-d H:i:s');

    if($cat_user == "user_app"){

        $sql = DB::table('tj_user_app')
        ->select('amount')
        ->where('id','=',DB::raw($id_user))
        ->get();
        foreach($sql as $row){
          $amount_ = $row->amount;
          $amount = $amount_+$amount_init;

        $updatedata = DB::update('update tj_user_app set amount = ?,modifier = ? where id = ?',[$amount,$date_heure,$id_user]);

        $query = DB::insert("insert into tj_transaction(amount,deduction_type,payment_method,id_user_app, creer,modifier)
        values('".$amount_init."',1,'".$paymethod."','".$id_user."','".$date_heure."','".$date_heure."')");
        }
        $sql_notification = UserApp::where('id',$id_user)->first();
        $data = $sql_notification->toArray();
        $row->amount = $data['amount'];
        if(!empty($row)){
          $response['success'] = 'success';
          $response['error'] = null;
          $response['message'] = 'successfully';
          $response['data'] = $row;

        }else{
          $response['success'] = 'Failed';
          $response['error'] = 'Failed';

        }

    }else{
      $response['success'] = 'Failed';
      $response['error'] = 'User category is incorrect';

    }
  /*  elseif($cat_user == "driver"){
        $sql = DB::table('tj_conducteur')
        ->select('amount')
        ->where('id','=',DB::raw($id_user))
        ->get();

        foreach($sql as $row){
          $amount_ = $row->amount;
          $amount = $amount_+$amount_init;

          $updatedata = DB::update('update tj_conducteur set amount = ? where id = ?',[$amount,$id_user]);

        }
        $sql_notification = Driver::where('id',$id_user)->first();
        $data = $sql_notification->toArray();
        $row->amount = $data['amount'];

        if(!empty($row)){
          $response['success'] = 'success';
          $response['error'] = null;
          $response['message'] = 'successfully';
          $response['data'] = $row;

        }else
        {
          $response['success'] = 'Failed';
          $response['error'] = 'Failed';

        }
    }*/
    return response()->json($response);
  }

}
