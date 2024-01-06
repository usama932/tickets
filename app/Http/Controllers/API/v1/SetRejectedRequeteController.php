<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Requests;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\API\v1\GcmController;
use DB;

class SetRejectedRequeteController extends Controller
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
    public function rejectedRequest(Request $request)
    {

        $id_requete = $request->get('id_ride');
        $id_user = $request->get('id_user');
        $driver_name = $request->get('name');
        $from_id = $request->get('from_id');
        $reason = $request->get('reason');
        $user_cat = $request->get('user_cat');
        if (!empty($id_requete) && !empty($from_id) && !empty($driver_name) && !empty($id_user)) {

            $sql = Requests::where('id', $id_requete)->first();
            $row_sql = $sql->toArray();
            if ($row_sql['trajet'] != '') {
                if (file_exists('images/recu_trajet_course' . '/' . $row_sql['trajet'])) {
                    $image_user = asset('images/recu_trajet_course') . '/' . $row_sql['trajet'];
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $row_sql['trajet'] = $image_user;
            }
            if ($user_cat == 'driver') {
                $tmsg = '';
                $terrormsg = '';

                $title = str_replace("'", "\'", "Rejection of your ride");
                /*$msg=str_replace("'","\'",$driver_name." rejected your ride");*/
                $msg = str_replace("'", "\'", $driver_name . " is cancelled your ride. Please try to book again.");
                $reasons = str_replace("'", "\'", "$reason");
                $type = 'driver rejection';

                $tab[] = array();
                $tab = explode("\\", $msg);
                $msg_ = "";
                for ($i = 0; $i < count($tab); $i++) {
                    $msg_ = $msg_ . "" . $tab[$i];
                }
                $message = array("body" => $msg_, "reasons" => $reasons, "title" => $title, "sound" => "mySound", "tag" => "riderejected");

                $query = DB::table('tj_user_app')
                    ->select('fcm_id')
                    ->where('fcm_id', '<>', '')
                    ->where('id', '=', DB::raw($id_user))
                    ->get();

                $lat = $row_sql['latitude_depart'];
                $long = $row_sql['longitude_depart'];
                $driver_id = $row_sql['id_conducteur'];
                // print_r($driver_id);
                // exit;
                $vehicleType = DB::table('tj_vehicule')->select('id_type_vehicule')->where('id_conducteur', $driver_id)->first();

                $data = DB::table("tj_conducteur")
                    ->join('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
                    ->select("tj_conducteur.id"
                        , DB::raw("3959  * acos(cos(radians(" . $lat . "))
                * cos(radians(tj_conducteur.latitude))
                * cos(radians(tj_conducteur.longitude) - radians(" . $long . "))
                + sin(radians(" . $lat . "))
                * sin(radians(tj_conducteur.latitude))) AS distance"))
                    ->having('distance', '<=', 10)
                    ->orderBy('distance', 'asc')
                    ->where('tj_conducteur.id', '!=', $driver_id)
                    ->where('id_type_vehicule', '=', $vehicleType->id_type_vehicule)
                    ->get();
                // $row = $data->toArray();
                if ($data->count() > 0) {
                    foreach ($data as $val) {
                        $id = $val->id;
                        $title = str_replace("'", "\'", "New ride");
                        $msg = str_replace("'", "\'", "You have just received a request from a client");

                        $tab[] = array();
                        $tab = explode("\\", $msg);
                        $msg_ = "";
                        for ($i = 0; $i < count($tab); $i++) {
                            $msg_ = $msg_ . "" . $tab[$i];
                        }

                        $message = array("body" => $msg_, "title" => $title, "sound" => "mySound", "tag" => "ridenewrider");

                        $query = DB::table('tj_conducteur')
                            ->select('fcm_id')
                            ->where('fcm_id', '<>', '')
                            ->where('id', '=', DB::raw($id))
                            ->get();

                        $tokens = array();
                        if ($query->count() > 0) {
                            foreach ($query as $user) {
                                if (!empty($user->fcm_id)) {
                                    $tokens[] = $user->fcm_id;
                                }
                            }
                        }

                        $temp = array();
                        if (count($tokens) > 0) {
                            GcmController::send_notification($tokens, $message, $temp);
                        }
                        if ($id) {
                            $date_heure = date('Y-m-d H:i:s');

                            $updatedata = DB::update('update tj_requete set statut = ?,updated_at=?,id_conducteur = ? where id = ?', ['new', $date_heure, $id, $id_requete]);
                            $sql_update = Requests::orderBy('updated_at', 'DESC')->first();
                            $row = $sql_update->toArray();
                            // print_r($row_update);
                            // exit;
                        }
                    }
                } else {
                    $updatedata = DB::update('update tj_requete set statut = ? where id = ?', ['rejected', $id_requete]);

                }

            } elseif ($user_cat == 'user_app') {
                $updatedata = DB::update('update tj_requete set statut = ? where id = ?', ['cancelled', $id_requete]);

                $tmsg = '';
                $terrormsg = '';

                $title = str_replace("'", "\'", "Rejection of your ride");
                /*$msg=str_replace("'","\'",$driver_name." rejected your ride");*/
                $msg = str_replace("'", "\'", "you cancelled $driver_name's ride");
                $reasons = str_replace("'", "\'", "$reason");
                $type = 'user rejection';

                $tab[] = array();
                $tab = explode("\\", $msg);
                $msg_ = "";
                for ($i = 0; $i < count($tab); $i++) {
                    $msg_ = $msg_ . "" . $tab[$i];
                }


                $message = array("body" => $msg_, "reasons" => $reasons, "title" => $title, "sound" => "mySound", "tag" => "riderejected");

                $query = DB::table('tj_conducteur')
                    ->select('fcm_id')
                    ->where('fcm_id', '<>', '')
                    ->where('id', '=', DB::raw($id_user))
                    ->get();
            }
            $tokens = array();
            if (!empty($query)) {
                foreach ($query as $user) {
                    if (!empty($user->fcm_id)) {
                        $tokens[] = $user->fcm_id;
                    }
                }
            }
            $temp = array();
            if (count($tokens) > 0) {
                if ($user_cat == 'driver') {
                    $updatedata = DB::update('update tj_requete set statut = ? where id = ?', ['rejected', $id_requete]);
                    $data = DB::table('tj_requete')
                        ->crossjoin('tj_conducteur')
                        ->select('tj_requete.distance', 'tj_requete.destination_name', 'tj_requete.montant', 'tj_requete.depart_name',
                            'tj_requete.id_user_app', 'tj_requete.latitude_depart', 'tj_requete.duree', 'tj_requete.id', 'tj_requete.distance_unit', 'tj_requete.longitude_depart',
                            'tj_requete.latitude_arrivee', 'tj_requete.longitude_arrivee', 'tj_requete.id_conducteur'
                            , 'tj_requete.tip_amount', 'tj_requete.statut',
                            'tj_conducteur.nom', 'tj_conducteur.prenom', 'tj_conducteur.photo_path'
                        )
                        ->where('tj_conducteur.id', '=', DB::raw('tj_requete.id_conducteur'))
                        ->where('tj_requete.id', '=', DB::raw($id_requete))->first();
                    $msg = '';
                    $terrormsg = '';
                    $title = str_replace("'", "\'", "Rejection of your ride");
                    /*$msg=str_replace("'","\'",$driver_name." rejected your ride");*/
                    $msg = str_replace("'", "\'", $driver_name . " is cancelled your ride. Please try to book again.");
                    $reasons = str_replace("'", "\'", "$reason");
                    $type = 'driver rejection';

                    $tab[] = array();
                    $tab = explode("\\", $msg);
                    $msg_ = "";
                    for ($i = 0; $i < count($tab); $i++) {
                        $msg_ = $msg_ . "" . $tab[$i];
                    }
                    $message = array("body" => $msg_, "reasons" => $reasons, "title" => $title, "sound" => "mySound", "tag" => "riderejected");

                    $query = DB::table('tj_user_app')
                        ->select('fcm_id')
                        ->where('fcm_id', '<>', '')
                        ->where('id', '=', DB::raw($id_user))
                        ->get();
                    $tokens = array();
                    if (!empty($query)) {
                        foreach ($query as $user) {
                            if (!empty($user->fcm_id)) {
                                $tokens[] = $user->fcm_id;
                            }
                        }
                    }
                    GcmController::send_notification($tokens, $message, $data);
                }
                if ($user_cat == 'user_app') {
                    $data = DB::table('tj_requete')
                        ->crossjoin('tj_user_app')
                        ->select('tj_requete.distance', 'tj_requete.destination_name', 'tj_requete.montant', 'tj_requete.depart_name',
                            'tj_requete.id_user_app', 'tj_requete.latitude_depart', 'tj_requete.duree', 'tj_requete.id', 'tj_requete.distance_unit', 'tj_requete.longitude_depart',
                            'tj_requete.latitude_arrivee', 'tj_requete.longitude_arrivee', 'tj_requete.id_conducteur'
                            , 'tj_requete.tip_amount', 'tj_requete.statut',
                            'tj_user_app.nom', 'tj_user_app.prenom', 'tj_user_app.photo_path', 'tj_user_app.id'
                        )
                        ->where('tj_user_app.id', '=', DB::raw('tj_requete.id_user_app'))
                        ->where('tj_requete.id', '=', DB::raw($id_requete))->first();
                }
                GcmController::send_notification($tokens, $message, $data, $type);
                $date_heure = date('Y-m-d H:i:s');
                $from_id = $request->get('from_id');
                $to_id = $request->get('id_user');

                $insertdata = DB::insert("insert into tj_notification(titre,message,statut,creer,modifier,to_id,from_id,type)
            values('" . $title . "','" . $msg . "','yes','" . $date_heure . "','" . $date_heure . "','" . $to_id . "','" . $from_id . "','riderejected')");
                $sql_notification = Notification::orderby('id', 'desc')->first();
                $data = $sql_notification->toArray();
                $row['titre'] = $data['titre'];
                $row['message'] = $data['message'];
                $row['reason'] = $reason;
                $row['statut_notification'] = $data['statut'];
                $row['to_id'] = $data['to_id'];
                $row['from_id'] = $data['from_id'];
                $row['type'] = $data['type'];
            }
            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'status successfully updated';
            $response['data'] = $row;


        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some fields are missing';

        }
        return response()->json($response);
    }

    public function get_single_ride(Request $request){
        $vehicleType = DB::table('tj_requete')->select('statut')->where('id_user_app',$request->user_id)->orderBy('otp_created','DESC')->first();

        if($vehicleType != null ){
            $response['success'] = 'success';
            $response['error'] = 'false';
            $response['data'] =  $vehicleType;


        }
        else{
            $response['success'] = 'Failed';
            $response['error'] = 'Not Found';
        }
        return response()->json($response);
    }
}
