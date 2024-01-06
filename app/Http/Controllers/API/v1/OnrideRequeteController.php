<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use App\Models\Vehicle;
use App\Models\Requests;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;

class OnrideRequeteController extends Controller
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


    public function register(Request $request)
    {
        $id_requete = $request->get('id_ride');
        $id_user = $request->get('id_user');
        $use_name = $request->get('use_name');
        $from_id = $request->get('from_id');
        $date_heure = date('Y-m-d H:i:s');

        Requests::where('id', $id_requete)->update(['statut' => 'on ride']);
        $updatedata = Requests::where('id', $id_requete)->first();
        if (!empty($updatedata)) {

            $sql = Requests::where('id', $id_requete)->first();
            $row = $sql->toArray();
            if ($row['trajet'] != '') {
                if (file_exists('images/recu_trajet_course' . '/' . $row['trajet'])) {
                    $image_user = asset('images/recu_trajet_course') . '/' . $row['trajet'];
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $row['trajet'] = $image_user;
            }
            $tmsg = '';
            $terrormsg = '';

            $title = str_replace("'", "\'", "Beginning of your ride");
            $msg = str_replace("'", "\'", $use_name . " is started your ride.");
            $type = 'on-ride';

            $tab[] = array();
            $tab = explode("\\", $msg);
            $msg_ = "";
            for ($i = 0; $i < count($tab); $i++) {
                $msg_ = $msg_ . "" . $tab[$i];
            }
            $message = array("body" => $msg_, "title" => $title, "sound" => "mySound", "tag" => "rideonride");

            $query = DB::table('tj_user_app')
                ->select('fcm_id')
                ->where('fcm_id', '<>', '')
                ->where('id', '=', DB::raw($id_user))
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
                $data = DB::table('tj_requete')
                    ->crossjoin('tj_conducteur')
                    ->select('tj_requete.distance','tj_requete.destination_name','tj_requete.montant','tj_requete.depart_name',
                        'tj_requete.id_user_app','tj_requete.latitude_depart','tj_requete.duree','tj_requete.id','tj_requete.distance_unit','tj_requete.longitude_depart',
                        'tj_requete.latitude_arrivee','tj_requete.longitude_arrivee','tj_requete.id_conducteur'
                        ,'tj_requete.tip_amount','tj_requete.statut',
                        'tj_conducteur.nom','tj_conducteur.prenom','tj_conducteur.photo_path'
                    )
                    ->where('tj_conducteur.id','=',DB::raw('tj_requete.id_conducteur'))
                    ->where('tj_requete.id','=',DB::raw($id_requete))->first();

                if(!empty($data->photo_path))
                {
                    if (file_exists('assets/images/driver' . '/' . $data->photo_path)) {
                        $image_user = asset('my-assets/images/driver') . '/' . $data->photo_path;
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');

                    }
                    $data->photo_path = $image_user;
                }
                GcmController::send_notification($tokens, $message, $data,$type);

                // echo "<pre>";print_r($notifications);exit;
                $date_heure = date('Y-m-d H:i:s');
                $from_id = $request->get('from_id');
                $to_id = $request->get('id_user');
                $insertdata = DB::insert("insert into tj_notification(titre,message,statut,creer,modifier,to_id,from_id,type)
            values('" . $title . "','" . $msg . "','yes','$date_heure','$date_heure','" . $to_id . "','" . $from_id . "','rideonride')");

                $sql_notification = Notification::where('to_id', $to_id)->first();
                $data = $sql_notification->toArray();
                $row['titre'] = $data['titre'];
                $row['message'] = $data['message'];
                $row['statut_notification'] = $data['statut'];
                $row['to_id'] = $data['to_id'];
                $row['from_id'] = $data['from_id'];
                $row['type'] = $data['type'];


            }

            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'status update successfully';
            $response['data'] = $row;
        } else {
            $response['success'] = 'failed';
            $response['error'] = 'failed to update';
        }


        return response()->json($response);
    }
}
