<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\Commission;
use Illuminate\Http\Request;
use DB;
class SettingsController extends Controller
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

    $sql = DB::table('tj_settings')
    ->get();

    foreach($sql as $row){

      $get_currency = DB::table('tj_currency')
      ->select('*')
      ->where('statut', '=', 'yes')
      ->get();
      foreach ($get_currency as $row_currency) {

          $row->currency = $row_currency->symbole;
          $row->decimal_digit = $row_currency->decimal_digit;
      }

      $get_tax = DB::table('tj_tax')
      ->select('*')
      ->where('statut', '=', 'yes')
      ->get();
      foreach ($get_tax as $row_tax) {
        $row->tax_name = $row_tax->libelle;
          $row->tax_type = $row_tax->type;
          $row->tax_value = $row_tax->value;
      }
        if(!empty($sql)){
          $response['success']= 'success';
          $response['error']= null;
          $response['message']= 'successfully';
          $response['data']= $row;
        }else{
          $response['success']= 'Failed';
          $response['error']= 'Failed to fetch data';
          $response['message']= null;
        }
        return response()->json($response);

    }

  }

}
