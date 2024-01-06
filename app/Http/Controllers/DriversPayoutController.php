<?php

namespace App\Http\Controllers;
use App\Models\Driver;
use App\Models\Currency;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Session;
class DriversPayoutController extends Controller
{

   public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
      
      if ($request->has('search') && $request->search != '' && $request->selected_search == 'note') {

          $search = $request->input('search');
          $withdrawal = Withdrawal::join('tj_conducteur','tj_conducteur.id','=','withdrawals.id_conducteur')
          ->select('tj_conducteur.nom','tj_conducteur.prenom','withdrawals.*')
          ->where('note', 'LIKE', '%' . $search . '%')->where('withdrawals.statut','=','success')->paginate(20);
      }
      else{
        $withdrawal=Withdrawal::join('tj_conducteur','tj_conducteur.id','=','withdrawals.id_conducteur')
        ->select('tj_conducteur.nom','tj_conducteur.prenom','withdrawals.*')
        ->where('withdrawals.statut','=','success')->paginate(20);
      }

       return view("drivers_payouts.index")->with('withdrawal',$withdrawal)->with('currency',$currency);
    }

    public function create()
    {

      $driver=Driver::all();
       return view("drivers_payouts.create")->with('driver',$driver);
    }

    public function store(Request $request){
      $validator = Validator::make($request->all(), $rules = [
          'driverId' => 'required',
          'payout' => 'required',
          'note' => 'required',

      ], $messages = [
          'driverId.required' => 'The Driver field is required!',
          'payout.required' => 'The amount field is required!',
          'note.required' => 'The note field is required!',
      ]);
      if ($validator->fails()) {
          return redirect()->back()
              ->withErrors($validator)->with(['message' => $messages])
              ->withInput();
      }
      $amount=$request->input('payout');
      $driverId=$request->input('driverId');
      $driver = Driver::find($driverId);

      if($driver->amount<0 || $driver->amount<$amount ){
        Session::flash('msg', 'Unsufficient Balance');
            return redirect()->back();
      }else{

        $driver->amount=intval($driver->amount)-intval($amount);
        $driver->save();

        $withdrawal = new Withdrawal;
        $withdrawal->id_conducteur=$driverId;
        $withdrawal->amount=$amount;
        $withdrawal->note=$request->input('note');
        $withdrawal->statut='success';
        $withdrawal->creer=date('Y-m-d H:i:s');
        $withdrawal->save();
        return redirect()->back();
}

    }

}
