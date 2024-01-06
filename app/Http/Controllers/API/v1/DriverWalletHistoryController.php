<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Requests;
use App\Models\Tax;
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
            $sql = DB::table('tj_requete')
                ->crossJoin('tj_payment_method')
                ->select('tj_requete.id', 'tj_requete.montant', 'tj_requete.tax',
                    'tj_requete.tip_amount', 'tj_requete.discount', 'tj_requete.admin_commission',
                    'tj_requete.id_user_app', 'tj_requete.depart_name', 'tj_requete.destination_name',
                    'tj_requete.creer', 'tj_requete.id_payment_method', 'tj_payment_method.id', 'tj_payment_method.libelle')
                ->where('tj_requete.id_payment_method', '=', DB::raw('tj_payment_method.id'))
                ->where('tj_requete.statut', '=', 'completed')
                ->where('tj_requete.id_conducteur', '=', DB::raw($id_diver))
                ->orderBy('tj_requete.creer', 'desc')
                ->get();
            $total_earning = 0;
            $tax1 = array();
            $commission1 = array();
            if (!empty($sql)) {
                foreach ($sql as $row) {
                    $user_id = $row->id_user_app;
                    $tax = !is_null(Tax::where('statut', 'yes')->first()) ? Tax::where('statut', 'yes')->first()->value : 0;
                    $commission = !is_null(Commission::where('statut', 'yes')->first()) ? Commission::where('statut', 'yes')->first()->value : 0;
                    $earn = floatval($row->montant) - ($commission != 0 ? ($row->montant * (intval($commission) / 100)) : 0);
                    $withTax = floatval($earn) - ($tax != 0 ? ($earn * (intval($commission) / 100)) : 0);
//                    $total_earning = $total_earning + $withTax + - floatval($row->tip_amount) - floatval($row->discount);
                    $total_earning = $total_earning + intval($row->montant);

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
                                    $image_user = asset('assets/images/placeholder_image.jpg');

                                }
                                $row_app_user->photo_path = $image_user;
                            }
                            $row->user_photo_path = $row_app_user->photo_path;

                        } else {

                            $row->user_name = "";
                            $row->user_photo = "";
                            $row->user_photo_path = "";
                        }

                        $output[] = $row;

                    }

                }
            }


            if (!empty($sql)) {
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
