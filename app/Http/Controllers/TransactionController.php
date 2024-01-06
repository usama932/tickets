<?php

namespace App\Http\Controllers;
use App\Models\Currency;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{

    public function __construct()
    {
       $this->middleware('auth');
    }


    /*public function index()
    {
        return view('transactions.index');
    }*/
    public function index(Request $request,$id='')
    {
        if($id){
            if ($request->has('search') && $request->search != '' && $request->selected_search=='transaction_id') {

                $search = $request->input('search');

                $transaction = DB::table('tj_transaction')
                ->join('tj_user_app', 'tj_transaction.id_user_app', '=', 'tj_user_app.id')
                ->select('tj_user_app.id as userId','tj_user_app.nom as lastname','tj_user_app.prenom as firstname')
                ->addSelect('tj_transaction.*')
                ->where('tj_transaction.id','LIKE','%'.$search.'%')
                ->where('tj_transaction.id_user_app','=',$id)
                ->paginate(20);
              }elseif($request->has('payment_status') && $request->payment_status != '' && $request->selected_search=='payment_status'){
                $search = $request->input('payment_status');

                $transaction = DB::table('tj_transaction')
                ->join('tj_user_app', 'tj_transaction.id_user_app', '=', 'tj_user_app.id')
                ->select('tj_user_app.id as userId','tj_user_app.nom as lastname','tj_user_app.prenom as firstname')
                ->addSelect('tj_transaction.*')
                ->where('tj_transaction.payment_status','LIKE','%'.$search.'%')
                ->where('tj_transaction.id_user_app','=',$id)
                ->paginate(20);
              }
              else{




              $transaction = DB::table('tj_transaction')
              ->join('tj_user_app', 'tj_transaction.id_user_app', '=', 'tj_user_app.id')
              ->select('tj_user_app.id as userId','tj_user_app.nom as lastname','tj_user_app.prenom as firstname')
              ->addSelect('tj_transaction.*')
              ->where('tj_transaction.id_user_app','=',$id)
              ->paginate(20);

              }
        }
        else{
            if ($request->has('search') && $request->search != '' && $request->selected_search=='transaction_id') {

                $search = $request->input('search');

                $transaction = DB::table('tj_transaction')
                ->join('tj_user_app', 'tj_transaction.id_user_app', '=', 'tj_user_app.id')
                ->select('tj_user_app.id as userId','tj_user_app.nom as lastname','tj_user_app.prenom as firstname')
                ->addSelect('tj_transaction.*')
                ->where('tj_transaction.id','LIKE','%'.$search.'%')
                ->paginate(20);
              }elseif($request->has('payment_status') && $request->payment_status != '' && $request->selected_search=='payment_status'){
                $search = $request->input('payment_status');

                $transaction = DB::table('tj_transaction')
                ->join('tj_user_app', 'tj_transaction.id_user_app', '=', 'tj_user_app.id')
                ->select('tj_user_app.id as userId','tj_user_app.nom as lastname','tj_user_app.prenom as firstname')
                ->addSelect('tj_transaction.*')
                ->where('tj_transaction.payment_status','LIKE','%'.$search.'%')
                ->paginate(20);
              }
              else{




              $transaction = DB::table('tj_transaction')
              ->join('tj_user_app', 'tj_transaction.id_user_app', '=', 'tj_user_app.id')
              ->select('tj_user_app.id as userId','tj_user_app.nom as lastname','tj_user_app.prenom as firstname')
              ->addSelect('tj_transaction.*')
              ->paginate(20);

              }
        }
        $currency = Currency::where('statut', 'yes')->first();
        return view("transactions.index")->with('id',$id)->with('transaction',$transaction)->with('currency',$currency);
    }
}
