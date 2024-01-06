<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Requests;
use App\Models\UserApp;
use App\Models\Note;
use Illuminate\Http\Request;
use DB;

class DriverWalletHistoryController extends Controller
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
        $months = array("January" => 'Jan', "February" => 'Feb', "March" => 'Mar', "April" => 'Apr', "May" => 'May', "June" => 'Jun', "July" => 'Jul', "August" => 'Aug', "September" => 'Sep', "October" => 'Oct', "November" => 'Nov', "December" => 'Dec');
        $daily_ride = [];
        $monthly_ride = [];
        $yearly_ride = [];
        $weekly_ride = [];
        $id_diver = $request->get('id_diver');
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');
        $date_before_week = date('Y-m-d 00:00:00', strtotime('-7 days'));
        $month = date('m');
        $year = date('Y');
        $output = [];

        if (!empty($id_diver)) {

            $sql_total_earning = DB::table('tj_conducteur')
                ->select('amount')
                ->where('id', '=', DB::raw($id_diver))
                ->get();
            foreach ($sql_total_earning as $row_total_earning) {
                $total_earning = strval($row_total_earning->amount);

            }
            $sql = DB::table('tj_requete')
                ->crossJoin('tj_payment_method')
                ->select('tj_requete.id', 'tj_requete.montant', 'tj_requete.tax', 'tj_requete.tip_amount', 'tj_requete.discount', 'tj_requete.admin_commission', 'tj_requete.id_user_app', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.creer', 'tj_requete.id_payment_method', 'tj_payment_method.id', 'tj_payment_method.libelle')
                ->where('tj_requete.id_payment_method', '=', DB::raw('tj_payment_method.id'))
                ->where('tj_requete.statut', '=', 'completed')
//                ->where('tj_requete.statut_paiement', '=', 'yes')
                ->where('tj_requete.id_conducteur', '=', DB::raw($id_diver))
                ->orderBy('tj_requete.creer', 'desc')
                ->get();

            return response()->json($sql);

            foreach ($sql as $row) {
                $user_id = $row->id_user_app;
                $totalamount = floatval($row->montant);


                $totalamount = $totalamount - floatval($row->discount);


                $totalamount = $totalamount + floatval($row->tip_amount);

                $totalamount = $totalamount + floatval($row->tax) - floatval($row->admin_commission);

                $row->amount = strval($totalamount);

                $row->destination_name = $row->destination_name;

                $row->depart_name = $row->depart_name;

                $row->creer = date("d", strtotime($row->creer)) . " " . $months[date("F", strtotime($row->creer))] . ". " . date("Y", strtotime($row->creer));

                // Nb confirmed
                $sql_app_user = DB::table('tj_user_app')
                    ->select('nom', 'prenom', 'photo', 'photo_path')
                    ->where('id', '=', DB::raw($user_id))
                    ->get();
                foreach ($sql_app_user as $row_app_user) {
                    if (!empty($row_app_user)) {

                        $row->user_name = $row_app_user->nom . " " . $row_app_user->prenom;
                        $row->user_photo = '';
                        if ($row_app_user->photo_path != '') {
                            if (file_exists('assets/images/users' . '/' . $row_app_user->photo_path)) {
                                $image_user = asset('assets/images/users') . '/' . $row_app_user->photo_path;
                            } else {
                                $image_user = asset('my-assets/images/placeholder_image.jpg');

                            }
                            $row_app_user->photo_path = $image_user;
                        }
                        $row->user_photo_path = $row_app_user->photo_path;

                    } else {

                        $row->user_name = "";
                        $row->user_photo = "";
                        $row->user_photo_path = "";
                    }

                    $total_earnings = floatval($total_earning);


                    $output[] = $row;

                }

            }


            if (!empty($row)) {
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'Successfully';
                $response['data'] = $output;

                $response['total_earnings'] = $total_earning;


            } else {
                $response['success'] = 'Failed';
                $response['error'] = null;
                $response['message'] = 'No Data Found';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Id is required';

        }
        return response()->json($response);

    }


}
