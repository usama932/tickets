<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\VehicleType;
use DB;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->limit = 20;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData(Request $request)
    {
        $months = array("January" => 'Jan', "February" => 'Fev', "March" => 'Mar', "April" => 'Avr', "May" => 'Mai', "June" => 'Jun', "July" => 'Jul', "August" => 'Aou', "September" => 'Sep', "October" => 'Oct', "November" => 'Nov', "December" => 'Dec');

        $id_user_app = $request->get('id_user_app');

        if (!empty($id_user_app)) {
            $sql = DB::table('tj_transaction')
                ->where('tj_transaction.id_user_app', '=', DB::raw($id_user_app))
              
                ->orderBy('tj_transaction.id', 'desc')
                ->get();

            foreach ($sql as $row) {
                $row->creer = date("d", strtotime($row->creer)) . " " . $months[date("F", strtotime($row->creer))] . ". " . date("Y", strtotime($row->creer));
                $ride_id = $row->ride_id;

                $ride = DB::table('tj_requete')
                ->select('tj_requete.transaction_id')
                ->where('id','=', $ride_id)
                ->get();
                foreach ($ride as $row_ride) {
                    $row->transaction_id = $row_ride->transaction_id;
                }

                $output[] = $row;


                if (!empty($row)) {

                    $response['success'] = 'success';
                    $response['error'] = null;
                    $response['message'] = 'Sucessfully';
                    $response['data'] = $output;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Failed to fetch data';
                    $response['message'] = null;
                }

            }
            if (empty($row)) {
                $response['success'] = 'Failed';
                $response['error'] = 'No Data Found';
                $response['message'] = null;
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Id Required';
        }
        return response()->json($response);

    }

}
