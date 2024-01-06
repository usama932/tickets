<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Requests;
use Illuminate\Http\Request;
use DB;

class RequeteBookController extends Controller
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

        $id_driver = $request->get('id_driver');
        if (!empty($id_driver)) {
            $sql = DB::table('tj_requete_book')
                ->crossJoin('tj_user_app')
                ->crossJoin('tj_conducteur')
                ->crossJoin('tj_payment_method')
                ->select('tj_requete_book.id', 'tj_requete_book.id_user_app', 'tj_requete_book.depart_name', 'tj_requete_book.destination_name', 'tj_requete_book.latitude_depart', 'tj_requete_book.longitude_depart', 'tj_requete_book.latitude_arrivee', 'tj_requete_book.longitude_arrivee', 'tj_requete_book.heure_retour', 'tj_requete_book.statut_round', 'tj_requete_book.number_poeple', 'tj_requete_book.place', 'tj_requete_book.statut', 'tj_requete_book.id_conducteur', 'tj_requete_book.creer', 'tj_requete_book.trajet', 'tj_user_app.nom', 'tj_user_app.prenom', 'tj_requete_book.distance', 'tj_user_app.phone', 'tj_conducteur.nom as nomConducteur', 'tj_conducteur.prenom as prenomConducteur', 'tj_conducteur.phone as driverPhone', 'tj_requete_book.montant', 'tj_requete_book.duree', 'tj_requete_book.statut_paiement', 'tj_requete_book.date_book', 'tj_requete_book.nb_day', 'tj_requete_book.heure_depart', 'tj_requete_book.cu', 'tj_payment_method.libelle as payment', 'tj_payment_method.image as payment_image')
                ->where('tj_requete_book.id_user_app', '=', DB::raw('tj_user_app.id'))
                ->where('tj_requete_book.id_payment_method', '=', DB::raw('tj_payment_method.id'))
                ->where('tj_requete_book.id_conducteur', '=', DB::raw($id_driver))
                ->where('tj_requete_book.statut', '=', 'new')
                ->where('tj_requete_book.id_conducteur', '=', DB::raw('tj_conducteur.id'))
                ->orderBy('tj_requete_book.id', 'desc')
                ->get();

            // output data of each row
            foreach ($sql as $row) {
                $id_user_app = $row->id_user_app;

                if ($id_user_app != 0) {

                    // Conducteur
                    $sql_cond = DB::table('tj_conducteur')
                        ->select('nom as nomConducteur', 'prenom as prenomConducteur')
                        ->where('id', '=', DB::raw($id_driver))
                        ->get();

                    foreach ($sql_cond as $row_cond)


                        // Nb avis conducteur
                        $sql_nb_avis = DB::table('tj_note')
                            ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau) as somme"))
                            ->where('id_conducteur', '=', DB::raw($id_driver))
                            ->get();
                    if (!empty($sql_nb_avis)) {
                        foreach ($sql_nb_avis as $row_nb_avis) {
                            $somme = $row_nb_avis->somme;
                            $nb_avis = $row_nb_avis->nb_avis;
                        }
                        if ($nb_avis != "0")
                            $moyenne = $somme / $nb_avis;
                        else
                            $moyenne = "0";
                    } else {
                        $somme = "0";
                        $nb_avis = "0";
                        $moyenne = "0";
                    }

                    // Note conducteur
                    $sql_note = DB::table('tj_note')
                        ->select('niveau')
                        ->where('id_user_app', '=', DB::raw($id_user_app))
                        ->where('id_conducteur', '=', DB::raw($id_driver))
                        ->get();
                    foreach ($sql_note as $row_note) {
                        if (!empty($sql_note))
                            $row->niveau = $row_note->niveau;
                        else
                            $row->niveau = "";
                        $row->moyenne = $moyenne;

                    }
                    $sql_phone = DB::table('tj_conducteur')
                        ->select('phone')
                        ->where('id', '=', DB::raw($id_driver))
                        ->get();

                    // output data of each row
                    foreach ($sql_phone as $row_phone) {
                        $row->driver_phone = $row_phone->phone;
                    }

                    $row->nomConducteur = $row_cond->nomConducteur;
                    $row->prenomConducteur = $row_cond->prenomConducteur;
                    $row->nb_avis = $row_nb_avis->nb_avis;


                } else {
                    $row->nomConducteur = "";
                    $row->prenomConducteur = "";
                    $row->nb_avis = "";
                    $row->niveau = "";
                    $row->moyenne = "";
                    $row->driver_phone = "";
                }

                $row->creer = date("d", strtotime($row->creer)) . " " . $months[date("F", strtotime($row->creer))] . ". " . date("Y", strtotime($row->creer));
                if ($row->trajet != '') {
                    if (file_exists('images/recu_trajet_course' . '/' . $row->trajet)) {
                        $image_user = asset('images/recu_trajet_course') . '/' . $row->trajet;
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');

                    }
                    $row->trajet = $image_user;
                }
                if ($row->payment_image != '') {
                    if (file_exists('assets/images/payment_method' . '/' . $row->payment_image)) {
                        $image = asset('assets/images/payment_method') . '/' . $row->payment_image;
                    } else {
                        $image = asset('assets/images/placeholder_image.jpg');

                    }
                    $row->payment_image = $image;
                }
                $output[] = $row;
            }
            if (!empty($row)) {
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'successfully';
                $response['data'] = $output;

            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to fetch data';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Id is required';

        }
        return response()->json($response);


    }

    public function driverRideDetails(Request $request)
    {
        $months = array("January" => 'Jan', "February" => 'Feb', "March" => 'Mar', "April" => 'Apr', "May" => 'May', "June" => 'Jun', "July" => 'Jul', "August" => 'Aug', "September" => 'Sep', "October" => 'Oct', "November" => 'Nov', "December" => 'Dec');

        $id_driver = $request->get('id_driver');
        if (!empty($id_driver)) {
            $sql = DB::table('tj_requete')
                ->Join('tj_user_app', 'tj_user_app.id', '=', 'tj_requete.id_user_app')
                ->Join('tj_conducteur', 'tj_conducteur.id', '=', 'tj_requete.id_conducteur')
                // ->Join('tj_payment_method', 'tj_payment_method.id', '=', 'tj_requete.id_payment_method')
                ->select('tj_requete.id', 'tj_requete.id_user_app', 'tj_requete.distance_unit',
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
                    // 'tj_requete.statut_paiement', 'tj_payment_method.libelle as payment',
                    'tj_requete.trip_objective',
                    'tj_requete.age_children1', 'tj_requete.age_children2', 'tj_requete.age_children3')
                ->where('tj_requete.id_user_app', '=', DB::raw('tj_user_app.id'))
                // ->where('tj_requete.id_payment_method', '=', DB::raw('tj_payment_method.id'))
                ->where('tj_requete.id_conducteur', '=', DB::raw($id_driver))
                ->where('tj_requete.id_conducteur', '=', DB::raw('tj_conducteur.id'))
                ->where(function ($query) {
                    $query->whereIn('tj_requete.statut', ['rejected', 'completed']);
                })
                ->orderBy('tj_requete.id', 'desc')
                ->get();
            if (empty($sql)) {
                $response['success'] = 'Failed';
                $response['error'] = 'No data found';
                return response()->json($response);
            }
            // output data of each row
            foreach ($sql as $row) {
                if ($row->photo_path != '') {
                    if (file_exists('assets/images/users' . '/' . $row->photo_path)) {
                        $image_user = asset('assets/images/users') . '/' . $row->photo_path;
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');
                    }
                    $row->photo_path = $image_user;
                }
                $id_user_app = $row->id_user_app;

                if ($id_user_app != 0) {

                    // Conducteur
                    $sql_cond = DB::table('tj_conducteur')
                        ->select('nom as nomConducteur', 'prenom as prenomConducteur')
                        ->where('id', '=', DB::raw($id_driver))
                        ->get();

                    foreach ($sql_cond as $row_cond)
                        // Nb avis conducteur
                        $sql_nb_avis = DB::table('tj_note')
                            ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau) as somme"))
                            ->where('id_conducteur', '=', DB::raw($id_driver))
                            ->get();
                    if (!empty($sql_nb_avis)) {
                        foreach ($sql_nb_avis as $row_nb_avis) {
                            $somme = $row_nb_avis->somme;
                            $nb_avis = $row_nb_avis->nb_avis;
                        }
                        if ($nb_avis != "0")
                            $row->moyenne_driver = $somme / $nb_avis;
                        else
                            $row->moyenne_driver = "0";
                    } else {
                        $somme = "0";
                        $nb_avis = "0";
                        $row->moyenne_driver = "0";
                    }

                    foreach ($sql as $data) {
                        $sql_nb_avis = DB::table('tj_user_note')
                            ->select(DB::raw("COUNT(id) as niveau_driver"), DB::raw("SUM(niveau_driver) as somme"))
                            ->where('id_user_app', '=', DB::raw($data->id_user_app))
                            ->get();
                            if (!is_null($sql_nb_avis[0]->somme)) {
                                $row->moyenne_user = $sql_nb_avis[0]->somme / $sql_nb_avis[0]->niveau_driver;

                        } else {
                            $row->moyenne_user = "0";

                        }
                    }

                    // Note conducteur
//                    $sql_note = DB::table('tj_note')
//                        ->select('niveau')
//                        ->where('id_user_app','=',DB::raw($id_user_app))
//                        ->where('id_conducteur','=',DB::raw($id_driver))
//                        ->get();
//                    foreach($sql_note as $row_note)
//                    {
//                        if(!empty($sql_note))
//                            $row->niveau = $row_note->niveau;
//                        else
//                            $row->niveau = "";
//                        $row->moyenne_driver = $moyenne;
//
//                    }
                    $sql_phone = DB::table('tj_conducteur')
                        ->select('phone')
                        ->where('id', '=', DB::raw($id_driver))
                        ->get();

                    // output data of each row
                    foreach ($sql_phone as $row_phone) {
                        $row->driver_phone = $row_phone->phone;
                    }

                    $row->nomConducteur = $row_cond->nomConducteur;
                    $row->prenomConducteur = $row_cond->prenomConducteur;
                    $row->nb_avis = $row_nb_avis->nb_avis;


                } else {
                    $row->nomConducteur = "";
                    $row->prenomConducteur = "";
                    $row->nb_avis = "";
                    $row->niveau = "";
                    $row->moyenne = "";
                    $row->driver_phone = "";
                }

                $row->creer = date("d", strtotime($row->creer)) . " " . $months[date("F", strtotime($row->creer))] . ". " . date("Y", strtotime($row->creer));
                if ($row->trajet != '') {
                    if (file_exists('images/recu_trajet_course' . '/' . $row->trajet)) {
                        $image_user = asset('images/recu_trajet_course') . '/' . $row->trajet;
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');

                    }
                    $row->trajet = $image_user;
                }
//                if($row->payment_image != ''){
//                    if(file_exists('assets/images/payment_method'.'/'.$row->payment_image ))
//                    {
//                        $image = asset('assets/images/payment_method').'/'. $row->payment_image;
//                    }
//                    else
//                    {
//                        $image =asset('assets/images/placeholder_image.jpg');
//
//                    }
//                    $row->payment_image = $image;
//                }
                $output[] = $row;
            }
            if (!empty($row)) {
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'successfully';
                $response['data'] = $output;

            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to fetch data';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Id is required';

        }
        return response()->json($response);


    }


}
