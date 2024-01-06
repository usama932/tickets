<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\Driver;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Validator;

class PayoutRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   public function payout($id=null){
     $currency = Currency::where('statut', 'yes')->first();
            if($id!=null || $id!=''){
                $withdrawal=DB::table('withdrawals')->join('tj_conducteur','tj_conducteur.id','=','withdrawals.id_conducteur')
                    ->select('withdrawals.*','tj_conducteur.nom','tj_conducteur.prenom')
                    ->where('withdrawals.id_conducteur','=',$id)->paginate(20);
            }
            else{
                $withdrawal=DB::table('withdrawals')->join('tj_conducteur','tj_conducteur.id','=','withdrawals.id_conducteur')
                    ->select('withdrawals.*','tj_conducteur.nom','tj_conducteur.prenom')->
                where('withdrawals.statut','=','pending')->paginate(20);
            }
        return view("payoutRequest.index")->with("withdrawal", $withdrawal)->with('currency',$currency);

   }
   public function getBankDetails(Request $request){
     $id=$request->input('id');
    $bankDetails= DB::table('tj_conducteur')->select('*')->where('id','=',$id)->get();

    $bankName=$bankDetails[0]->bank_name;
    $branchName=$bankDetails[0]->branch_name;
    $accNo=$bankDetails[0]->account_no;
    $other_info=$bankDetails[0]->other_info;
    $holderName=$bankDetails[0]->holder_name;
    $data=array('bankName'=>$bankName,'branchName'=>$branchName,'accNo'=>$accNo,'other_info'=>$other_info,'holderName'=>$holderName);
     echo json_encode($data);
   }
  public function acceptWithdrawal(Request $request){
    $id=$request->input('id');
    $withdrawal=Withdrawal::find($id);
    $driver_id=$withdrawal->id_conducteur;
    $withdraw_amount=$withdrawal->amount;
    $driver=DB::table('tj_conducteur')->select('amount')->where('id','=',$driver_id)->first();
    $newDriverAmount=$driver->amount-$withdraw_amount;
    DB::table('tj_conducteur')->where('id','=',$driver_id)->update(['amount' => $newDriverAmount]);
    if($withdrawal){
      $withdrawal->statut='success';
    }

    $withdrawal->save();
  }
  public function rejectWithdrawal(Request $request){
    $id=$request->input('id');
    $withdrawal=Withdrawal::find($id);
    if($withdrawal){
      $withdrawal->statut='rejected';
    }
    $withdrawal->save();
  }

}
