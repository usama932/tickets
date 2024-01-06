<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\Driver;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Http\Request;
use DB;
class DriverWithdrawalsController extends Controller
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

    $users = UserApp::all();
    $users = UserApp::paginate($this->limit);
    return response()->json($users);
  }

  public function Withdrawals(Request $request)
  {

        $user_id = $request->get('driver_id');
        $amount = $request->get('amount');
        $note = $request->get('note');
        $date_heure = date('Y-m-d H:i:s');

        if(!empty($user_id) && !empty($amount)){

          $chkid = Driver::where('id',$user_id)->first();
                if($chkid){
                    $driverAmount=$chkid->amount;
                    if($driverAmount>=$amount){
                      $insertdata = DB::insert("insert into withdrawals(id_conducteur,amount,note,statut,creer,modifier)
                      values('".$user_id."','".$amount."','".$note."','pending','".$date_heure."','".$date_heure."')");
                      $id=DB::getPdo()->lastInsertId();
                   if($id > 0){
                     $withdrawals =DB::table('withdrawals')
                         ->select('*')
                         ->where('id',$id)
                         ->first();

                          $row['widrawals_statut'] = $withdrawals->statut;
                          $row['widrawals_amount'] = $withdrawals->amount;


                          $response['success']= 'success';
                          $response['error']= null;
                          $response['message']= 'amount Withdrawals successfully';
                          $response['data'] = $row;

                  }

                  else{
                      $response['success']= 'Failed';
                      $response['error']= 'Failed to withdrawals';
                  }
                }
                else{
                  $response['success']= 'Failed';
                  $response['error']= 'Unsufficient Balance';
                }


            }

            else{
                $response['success']= 'Failed';
                $response['error']= 'Driver Not Found';
            }
            }

        else{
            $response['success']= 'Failed';
            $response['error']= 'Some fields not found';
        }


    return response()->json($response);
  }

}
