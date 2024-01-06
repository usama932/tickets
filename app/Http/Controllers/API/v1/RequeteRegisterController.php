<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\API\v1\GcmController;
use App\Http\Controllers\Controller;
use App\Models\Requests;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class RequeteRegisterController extends Controller
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

        $user_id = $request->get('user_id');
        $lat1 = $request->get('lat1');
        $lng1 = $request->get('lng1');
        $lat2 = $request->get('lat2');
        $lng2 = $request->get('lng2');
        $cout = $request->get('cout');
        $duree = $request->get('duree');
        $distance = $request->get('distance');
        $distance_unit = $request->get('distance_unit');
        $age_children1 = $request->get('age_children1');
        $age_children2 = $request->get('age_children2');
        $age_children3 = $request->get('age_children3');
        $trip_objective = $request->get('trip_objective');
        $trip_category = $request->get('trip_category');

        $id_conducteur = $request->get('id_conducteur');
        $id_payment = $request->get('id_payment');
        $depart_name = $request->get('depart_name');
        $destination_name = $request->get('destination_name');
        $image = $request->file('image');
        $place = $request->get('place');
        $place = str_replace("'", "\'", $place);
        $number_poeple = $request->get('number_poeple');
        $number_poeple = str_replace("'", "\'", $number_poeple);
        $statut_round = $request->get('statut_round');

        if (!empty($request->get('date_retour')))
            $date_retour = $request->get('date_retour');
        else
            $date_retour = date('Y-m-d');
        if (!empty($request->get('heure_retour')))
            $heure_retour = $request->get('heure_retour');
        else
            $heure_retour = date('H:i:s');
        $date_heure = date('Y-m-d H:i:s');

        if (!empty($image)) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'requete_images_' . $time;
            $file->move('images/recu_trajet_course/', $filename);
        } else {
            $filename = '';
        }
        if (!empty($id_payment)) {
            $tmsg = '';
            $terrormsg = '';
            $title = str_replace("'", "\'", "New ride");
            $msg = str_replace("'", "\'", "You have just received a request from a client");

            $tab[] = array();
            $tab = explode("\\", $msg);
            $msg_ = "";
            for ($i = 0; $i < count($tab); $i++) {
                $msg_ = $msg_ . "" . $tab[$i];
            }

            //$gcm = new GCM();

            $message = array("body" => $msg_, "title" => $title, "sound" => "mySound", "tag" => "ridenewrider");

            $query = DB::table('tj_conducteur')
                ->select('fcm_id')
                ->where('fcm_id', '<>', '')
                ->where('id', '=', DB::raw($id_conducteur))
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
            $date_heure = date('Y-m-d H:i:s');

            $insertdata = DB::insert("insert into tj_requete(date_retour,statut_round,heure_retour,number_poeple,place,id_payment_method,trajet,depart_name,destination_name,id_conducteur,id_user_app,latitude_depart,longitude_depart,latitude_arrivee,longitude_arrivee,statut,creer,distance,distance_unit,montant,duree,trip_objective,age_children1,age_children2,age_children3,feel_safe,tip_amount,statut_paiement,modifier,statut_course,id_conducteur_accepter,trip_category,feel_safe_driver)
             values('" . $date_retour . "','" . $statut_round . "','" . $heure_retour . "','" . $number_poeple . "','" . $place . "','" . $id_payment . "','" . $filename . "','" . $depart_name . "','" . $destination_name . "','" . $id_conducteur . "','" . $user_id . "','" . $lat1 . "','" . $lng1 . "','" . $lat2 . "','" . $lng2 . "','new','" . $date_heure . "','" . $distance . "', '".$distance_unit."', '" . $cout . "','" . $duree . "','" . $trip_objective . "','" . $age_children1 . "','" . $age_children2 . "','" . $age_children3 . "',0,0,'','" . $date_heure . "','',0,'',0)");
            $id = DB::getPdo()->lastInsertId();

            if(count($tokens) > 0)
            {
                $data = DB::table('tj_requete')
                    ->crossjoin('tj_user_app')
                    ->select('tj_requete.distance',
                        'tj_requete.destination_name','tj_requete.montant','tj_requete.depart_name',
                        'tj_requete.id_user_app','tj_requete.latitude_depart','tj_requete.duree','tj_requete.id',
                        'tj_requete.distance_unit','tj_requete.longitude_depart','tj_requete.latitude_arrivee',
                        'tj_requete.longitude_arrivee','tj_requete.id_conducteur','tj_requete.tip_amount','tj_requete.statut',
                        'tj_user_app.nom','tj_user_app.prenom','tj_user_app.photo_path'
                    )
                    ->where('tj_requete.id_user_app','=',DB::raw('tj_user_app.id'))
                    ->where('tj_requete.id','=',DB::raw($id))
                    ->first();
                GcmController::send_notification($tokens,$message,$data,'ride');
            }
            if ($id > 0) {
                $get_user = Requests::where('id', $id)->first();
                $row = $get_user->toArray();
                if ($row['trajet'] != '') {
                    if (file_exists('images/recu_trajet_course/' . '/' . $row['trajet'])) {
                        $image_user = asset('images/recu_trajet_course/') . '/' . $row['trajet'];
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');

                    }
                    $row['trajet'] = $image_user;
                }

                $output[] = $row;
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'Successfully created';
                $response['data'] = $output;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'Failed';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field required';
        }


        return response()->json($response);
    }


}
