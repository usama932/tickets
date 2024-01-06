<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\API\v1\GcmController;
use App\Http\Controllers\Controller;
use App\Models\Requests;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class RequeteController extends Controller
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

        $output = array();

        $settig_data = DB::table('tj_settings')->select('trip_accept_reject_driver_time_sec')->get();

        $trip_accept_reject_driver_time_sec = '';
        foreach ($settig_data as $row) {

            $trip_accept_reject_driver_time_sec = $row->trip_accept_reject_driver_time_sec;
        }


        $id_driver = $request->get('id_driver');
        if (!empty($id_driver)) {
            $sql = DB::table('tj_requete')
                ->leftJoin('tj_user_app','tj_user_app.id','=','tj_requete.id_user_app')
                ->leftJoin('tj_conducteur','tj_conducteur.id','=','tj_requete.id_conducteur')
                ->select('tj_requete.id', 'tj_requete.id_user_app','tj_requete.distance_unit',
                    'tj_requete.depart_name', 'tj_requete.destination_name',
                    'tj_requete.latitude_depart', 'tj_requete.longitude_depart',
                    'tj_requete.latitude_arrivee', 'tj_requete.longitude_arrivee',
                    'tj_requete.number_poeple', 'tj_requete.place', 'tj_requete.statut',
                    'tj_requete.id_conducteur', 'tj_requete.creer', 'tj_requete.trajet',
                    'tj_requete.feel_safe_driver', 'tj_user_app.nom', 'tj_user_app.prenom',
                    'tj_requete.distance', 'tj_user_app.phone', 'tj_user_app.photo_path',
                    'tj_conducteur.nom as nomConducteur', 'tj_conducteur.prenom as prenomConducteur',
                    'tj_conducteur.phone as driverPhone', 'tj_requete.date_retour', 'tj_requete.heure_retour',
                    'tj_requete.statut_round', 'tj_requete.montant', 'tj_requete.duree', 'tj_user_app.id as userId',
                    'tj_requete.age_children1', 'tj_requete.age_children2', 'tj_requete.age_children3')
                ->where('tj_requete.id_user_app', '=', DB::raw('tj_user_app.id'))
                ->where('tj_requete.id_conducteur', '=', DB::raw($id_driver))
                ->where('tj_requete.statut', '=', 'new')
                //->where('tj_requete.id_conducteur', '=', DB::raw('tj_conducteur.id'))
                ->orderBy('tj_requete.id', 'desc')
                ->get();

            // dd($sql);
            foreach($sql as $row) {

                $id_user_app = $row->id_user_app;
                $lat = $row->latitude_depart;
                $long = $row->longitude_depart;


               $ride_id = $row->id;
                if ($id_user_app != 0) {

                    $sql_cond = DB::table('tj_conducteur')
                        ->select('nom as nomConducteur', 'prenom as prenomConducteur')
                        ->where('id', '=', DB::raw($id_driver))
                        ->get();
                    foreach ($sql_cond as $row_cond) {
                        $row->nomConducteur = $row_cond->nomConducteur;
                        $row->prenomConducteur = $row_cond->prenomConducteur;
                    }

                    // Nb avis conducteur
                    $sql_nb_avis = DB::table('tj_note')
                        ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau) as somme"))
                        ->where('id_conducteur', '=', DB::raw($id_driver))
                        ->get();
                    if (!empty($sql_nb_avis)) {
                        foreach ($sql_nb_avis as $row_nb_avis) {
                            $somme = $row_nb_avis->somme;
                            $nb_avis = $row_nb_avis->nb_avis;
                            if ($nb_avis != "0")
                                $moyenne = $somme / $nb_avis;
                            else
                                $moyenne = 0;
                        }
                    } else {
                        $somme = "0";
                        $nb_avis = "0";
                        $moyenne = 0;
                    }

                    $sql_nb_avis_driver = DB::table('tj_user_note')
                        ->select(DB::raw("COUNT(id) as nb_avis_driver"), DB::raw("SUM(niveau_driver) as somme_driver"))
                        ->where('id_user_app', '=', DB::raw($id_user_app))
                        ->get();
                    if (!empty($sql_nb_avis_driver)) {
                        foreach ($sql_nb_avis_driver as $row_nb_avis_driver) {
                            $somme_driver = $row_nb_avis_driver->somme_driver;
                            $nb_avis_driver = $row_nb_avis_driver->nb_avis_driver;
                            if ($nb_avis_driver != "0")
                                $moyenne_driver = $somme_driver / $nb_avis_driver;
                            else
                                $moyenne_driver = 0;
                        }
                    } else {
                        $somme_driver = "0";
                        $nb_avis_driver = "0";
                        $moyenne_driver = 0;
                    }

                    // Note conducteur
                    $sql_note = DB::table('tj_note')
                        ->select('niveau', 'comment')
                        ->where('id_user_app', '=', DB::raw($id_user_app))
                        ->where('id_conducteur', '=', DB::raw($id_driver))
                        ->get();
                    foreach ($sql_note as $row_note) {
                        if (!empty($row_note)) {
                            //$row->niveau = floatval($row_note->niveau);
                            $row->comment = $row_note->comment;
                        } else {
                            //$row->niveau = 0;
                            $row->comment = "";
                        }
                    }

                    // Note user
                    $sql_note_driver = DB::table('tj_user_note')
                        ->select('niveau_driver', 'comment')
                        ->where('id_user_app', '=', DB::raw($id_user_app))
                        ->where('id_conducteur', '=', DB::raw($id_driver))
                        ->get();
                    foreach ($sql_note_driver as $row_note_driver) {
                        if (!empty($row_note_driver)) {
                            //$row->niveau_driver = floatval($row_note_driver->niveau_driver);
                            $row->comment_driver = $row_note_driver->comment;
                        } else {
                            //$row->niveau_driver = 0;
                            $row->comment_driver = "";
                        }
                    }

                    $sql_phone = DB::table('tj_conducteur')
                        ->select('phone')
                        ->where('id', '=', DB::raw($id_driver))
                        ->get();
                    foreach ($sql_phone as $row_phone) {
                        $row->driver_phone = $row_phone->phone;
                    }
                    $row->moyenne = number_format((float)$moyenne, 1);
                    $row->moyenne_driver = number_format((float)$moyenne_driver, 1);
                } else {
                    $row->nomConducteur = "";
                    $row->prenomConducteur = "";
                    // $row->nb_avis = "";
                    // $row->niveau = 0;
                    $row->moyenne = 0;
                    $row->driver_phone = "";
                    $row->moyenne_driver = 0;
                    // $row->nb_avis_driver = "";
                    // $row->niveau_driver =  0;

                }

                $sql_vehicle = DB::table('tj_vehicule')
                    ->select('*')
                    ->where('id_conducteur', '=', DB::raw($id_driver))
                    ->get();
                foreach ($sql_vehicle as $row_vehicle) {
                    $row->idVehicule = $row_vehicle->id;
                    $row->brand = $row_vehicle->brand;
                    $row->model = $row_vehicle->model;
                    $row->car_make = $row_vehicle->car_make;
                    $row->milage = $row_vehicle->milage;
                    $row->km = $row_vehicle->km;
                    $row->color = $row_vehicle->color;
                    $row->numberplate = $row_vehicle->numberplate;
                    $row->passenger = $row_vehicle->passenger;
                }

                $currentDateTime = Carbon::now();

                if($trip_accept_reject_driver_time_sec != '') {
                    $date = Date("Y-m-d H:i:s", strtotime("$trip_accept_reject_driver_time_sec seconds", strtotime($row->creer)));

                    if ($currentDateTime > $date) {

                        $settings = Requests::find($row->id);

                        $settings->statut = "canceled";
                        $row->statut = "canceled";

                        $settings->save();

                        $title = str_replace("'", "\'", "Canceled your ride");
                        $msg = str_replace("'", "\'", $row->nomConducteur . " " . $row->prenomConducteur . " is Canceled your ride.");

                        $tab[] = array();
                        $tab = explode("\\", $msg);
                        $msg_ = "";
                        for ($i = 0; $i < count($tab); $i++) {
                            $msg_ = $msg_ . "" . $tab[$i];
                        }
                        $message = array("body" => $msg_, "title" => $title, "sound" => "mySound", "tag" => "ridecanceled");

                        $query = DB::table('tj_user_app')
                            ->select('fcm_id')
                            ->where('fcm_id', '!=', NULL)
                            ->where('id', '=', DB::raw($row->userId))
                            ->get();

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
                            GcmController::send_notification($tokens, $message, $temp);

                        }

                        $vehicleType=DB::table('tj_vehicule')->select('id_type_vehicule')->where('id_conducteur',$id_driver)->first();

                        $data = DB::table("tj_conducteur")
                          ->join('tj_vehicule','tj_vehicule.id_conducteur','=','tj_conducteur.id')
                          ->select("tj_conducteur.id"
                            ,DB::raw("3959  * acos(cos(radians(" . $lat . "))
                            * cos(radians(tj_conducteur.latitude))
                            * cos(radians(tj_conducteur.longitude) - radians(" . $long . "))
                            + sin(radians(" .$lat. "))
                            * sin(radians(tj_conducteur.latitude))) AS distance"))
                           ->having('distance','<=',10)
                           ->distinct('tj_conducteur.id')
                           ->orderBy('distance','asc')
                           ->where('tj_conducteur.id','!=',$id_driver)
                            ->where('id_type_vehicule','=',$vehicleType->id_type_vehicule)
                            ->get();
                           // $row = $data->toArray();
                           if($data->count() > 0){
                             foreach($data as $val)
                             {
                                 // print_r($val);
                                 // exit;
                                 $id = $val->id;

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
                             if($id)
                             {
                             $updatedata =  DB::update('update tj_requete set statut = ?,id_conducteur = ? where id = ?',['new',$id,$ride_id]);
                             }
                         }
                        }
                        else{
                          $updatedata =  DB::update('update tj_requete set statut = ? where id = ?',['rejected',$ride_id]);

                        }



                    }

                }


                $row->creer = date("d", strtotime($row->creer)) . " " . $months[date("F", strtotime($row->creer))] . ", " . date("Y", strtotime($row->creer));
                $row->date_retour = date("d", strtotime($row->date_retour)) . " " . $months[date("F", strtotime($row->date_retour))] . ", " . date("Y", strtotime($row->date_retour));
                if ($row->photo_path != '') {
                    if (file_exists('assets/images/users' . '/' . $row->photo_path)) {
                        $image_user = asset('assets/images/users') . '/' . $row->photo_path;
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');

                    }
                    $row->photo_path = $image_user;
                }
                // if ($row->payment_image != '') {
                //     if (file_exists('assets/images/payment_method' . '/' . $row->payment_image)) {
                //         $image = asset('assets/images/payment_method') . '/' . $row->payment_image;
                //     } else {
                //         $image = asset('assets/images/placeholder_image.jpg');

                //     }
                //     $row->payment_image = $image;
                // }

                if ($row->statut == "new") {
                    $output[] = $row;
                }

            }

            if (!empty($output)) {

                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'successfully';
                $response['data'] = $output;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'Failed to fetch data';
            }

        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Some Fields are missing';
        }
        return response()->json($response);


    }
}
