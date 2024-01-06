<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Driver;
use App\Models\Requests;
use App\Models\Rides;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class RidesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // if($fromDate){
    //       ->whereDate('tj_requete.creer','>=',$fromDate)
    //       }
    //       if($toDate){
    //       ->whereDate('tj_requete.creer','<=',$toDate)
    //       }

    public function all(Request $request,$id=null)
    {
      
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');

              $rides = Requests::query()
                  ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->orderBy('tj_requete.creer', 'DESC')
                  ->whereDate('tj_requete.creer', '>=', $fromDate)
                  ->whereDate('tj_requete.creer', '<=', $toDate)
                  ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

                 $rides=$rides->paginate(20);

        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');

                $rides = DB::table('tj_requete')
                    ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                    ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                    ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                      ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                    ->orderBy('tj_requete.creer', 'DESC')
                    ->whereDate('tj_requete.creer', '>=', $fromDate)
                    ->where('tj_requete.deleted_at', '=', NULL);
                    if($id!='' || $id!=null){
                      $rides->where('tj_requete.id_conducteur','=',$id);
                    }

                   $rides=$rides->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');

              $rides = DB::table('tj_requete')
                  ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->orderBy('tj_requete.creer', 'DESC')
                  ->whereDate('tj_requete.creer', '<=', $toDate)
                  ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

                 $rides=$rides->paginate(20);
        } else if ($request->selected_search == 'userName' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            //$searchs = explode(" ", $search);
              $rides = DB::table('tj_requete')
                  ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->orderBy('tj_requete.creer', 'DESC');
                  if($id!='' || $id!=null){
                    $rides->where('tj_user_app.prenom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                  }
                  else{
                    $rides->where('tj_user_app.prenom', 'LIKE', '%' . $search . '%');
                    $rides->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%');
                    $rides->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
  
                  }
                  $rides->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

                 $rides=$rides->paginate(20);
        }
        else if ($request->selected_search == 'driverName' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            //$searchs = explode(" ", $search);
              $rides = DB::table('tj_requete')
                  ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->orderBy('tj_requete.creer', 'DESC');
                  if($id!='' || $id!=null){
                    $rides->where('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                    $rides->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')->where('tj_requete.id_conducteur','=',$id);
                }
                else{
                    $rides->where('tj_conducteur.prenom', 'LIKE', '%' . $search . '%');
                    $rides->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%');
                    $rides->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

                }
                $rides->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

                 $rides=$rides->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');

              $rides = DB::table('tj_requete')
                  ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                  ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                  ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                  ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                  ->orderBy('tj_requete.creer', 'DESC')
                  ->where('tj_requete.statut', 'LIKE', '%' . $search . '%')
                  ->where('tj_requete.deleted_at', '=', NULL);
                  if($id!='' || $id!=null){
                    $rides->where('tj_requete.id_conducteur','=',$id);
                  }

                 $rides=$rides->paginate(20);
        }
         else {

            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.deleted_at', '=', NULL);
                if($id!='' || $id!=null){
                  $rides->where('tj_requete.id_conducteur','=',$id);
                }

               $rides=$rides->paginate(20);

        }

        return view("rides.all")->with("rides", $rides)->with('currency', $currency)->with('id',$id);
    }

    public function new(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_user_app.id as id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        //->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                      //  ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
               ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_user_app.id as id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');
                        //->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
               ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
            }
            else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
                $search = $request->input('ride_status');
                $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_user_app.id as id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');
                        //->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        //->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')
                        //->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
               ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
                }
            else {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount','tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'new')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }

        // $newride = DB::table('tj_requete')
        // ->select('id')
        // ->where('deleted_at','!=','0000-00-00 00:00:00')
        // ->get();

        return view("rides.new")->with("rides", $rides)->with('currency', $currency);
    }

    public function confirmed(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'confirmed')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }

        return view("rides.confirmed")->with("rides", $rides)->with('currency', $currency);
    }


    public function onRide(Request $request)
    {

      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                       ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                       ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'on ride')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        return view("rides.onride")->with("rides", $rides)->with('currency', $currency);
    }

    public function rejected(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        //->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        //->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');
                        //->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app','tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        else {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app','tj_requete.id_conducteur','tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->Where(function ($query) {
                    $query->where('tj_requete.statut', 'rejected')
                        ->orwhere('tj_requete.statut', 'canceled');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }
        return view("rides.rejected")->with("rides", $rides)->with('currency', $currency);
    }

    public function completed(Request $request)
    {
      $currency = Currency::where('statut', 'yes')->first();
        if ($request->has('datepicker_from') && $request->datepicker_from != '' && $request->has('datepicker_to') && $request->datepicker_to != '') {
            $fromDate = $request->input('datepicker_from');
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_from') && $request->datepicker_from != '') {
            $fromDate = $request->input('datepicker_from');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('datepicker_to') && $request->datepicker_to != '') {
            $toDate = $request->input('datepicker_to');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->whereDate('tj_requete.creer', '<=', $toDate)
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->selected_search == 'userPrenom' && $request->has('search') && $request->search != '') {

            $search = $request->input('search');
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app', 'tj_requete.id_conducteur')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->where(function ($query) use ($search) {
                    $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                       // ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                        //->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                        //->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                        ->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                       // ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%')
                        ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%');
                })
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);
        }else if ($request->selected_search == 'driverPrenom' && $request->has('search') && $request->search != '') {
            $search = $request->input('search');
            $rides = DB::table('tj_requete')
            ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app', 'tj_requete.id_conducteur')
            ->orderBy('tj_requete.creer', 'DESC')
            ->where('tj_requete.statut', 'completed')
            ->where(function ($query) use ($search) {
                $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                   // ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%')
                    ->orWhere('tj_conducteur.prenom', 'LIKE', '%' . $search . '%')
                    ->orwhere('tj_conducteur.nom', 'LIKE', '%' . $search . '%')
                    //->orwhere('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                    //->orwhere('tj_user_app.nom', 'LIKE', '%' . $search . '%')
                    ->orWhere(DB::raw('CONCAT(tj_conducteur.prenom, " ",tj_conducteur.nom)'), 'LIKE', '%' . $search . '%');

            })
            ->where('tj_requete.deleted_at', '=', NULL)
            ->paginate(20);
        }
        else if ($request->selected_search == 'status' && $request->has('ride_status') && $request->ride_status != '') {
            $search = $request->input('ride_status');
            $rides = DB::table('tj_requete')
            ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image','tj_requete.id_user_app', 'tj_requete.id_conducteur')
            ->orderBy('tj_requete.creer', 'DESC')
            ->where('tj_requete.statut', 'completed')
            ->where(function ($query) use ($search) {
                $query->where('tj_requete.depart_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('tj_requete.destination_name', 'LIKE', '%' . $search . '%')
                    ->orwhere('tj_requete.statut', 'LIKE', '%' . $search . '%');

            })
            ->where('tj_requete.deleted_at', '=', NULL)
            ->paginate(20);
        }
         else {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut','tj_requete.tip_amount','tj_requete.admin_commission','tj_requete.tax','tj_requete.discount', 'tj_requete.id_user_app', 'tj_requete.id_conducteur', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
                ->orderBy('tj_requete.creer', 'DESC')
                ->where('tj_requete.statut', 'completed')
                ->where('tj_requete.deleted_at', '=', NULL)
                ->paginate(20);

        }
        return view("rides.completed")->with("rides", $rides)->with('currency', $currency);
    }

    public function filterRides(Request $request)
    {
        $page = $request->input('pageName');
        $fromDate = $request->input('datepicker-from');
        $toDate = $request->input('datepicker-to');

        if ($page == "allpage") {
            $rides = DB::table('tj_requete')
                ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
                ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
                ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
                ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle')
                ->orderBy('tj_requete.creer', 'DESC')
                ->whereDate('tj_requete.creer', '>=', $fromDate)
                ->paginate(10);
            return view("rides.all")->with("rides", $rides);
        } else {

        }

    }





    // public function edit($id)
    // {
    //      $driver = Driver::where('id',"=", $id)->first();
    //      $vehicle = Vehicle::where('id_conducteur',"=", $id)->first();

    //     $earnings = DB::select("SELECT sum(montant) as montant, count(id) as rides

    //     FROM tj_requete WHERE statut='completed' AND id_conducteur=$id");

    // 	return view('drivers.edit')->with('driver', $driver)->with("vehicle",$vehicle)->with("earnings",$earnings);
    // }

    public function deleteRide($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $user = Requests::find($id[$i]);
                    $user->delete();
                }

            } else {
                $user = Requests::find($id);
                $user->delete();
            }

        }

        return redirect()->back();
    }

    public function show($id)
    {

        $currency = Currency::where('statut', 'yes')->first();

        $ride = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->join('tj_vehicule', 'tj_requete.id_conducteur', '=', 'tj_vehicule.id_conducteur')
            //->join('tj_vehicle_images', 'tj_requete.id_conducteur', '=', 'tj_vehicle_images.id_driver')
            ->select('tj_requete.*')
            ->addSelect('tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_conducteur.phone as driver_phone', 'tj_conducteur.email as driver_email', 'tj_conducteur.photo_path')
            ->addSelect('tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_user_app.phone as user_phone', 'tj_user_app.email as user_email')
            ->addSelect('tj_payment_method.libelle', 'tj_payment_method.image', 'tj_payment_method.libelle', 'tj_payment_method.image')
            ->addSelect('tj_vehicule.brand', 'tj_vehicule.model', 'tj_vehicule.car_make', 'tj_vehicule.numberplate')
            //->addSelect('tj_vehicle_images.image_path as car_image')
            ->where('tj_requete.id', $id)->first();

		 $customer_review = DB::table('tj_note')->where('tj_note.ride_id',$id)->value('comment');
		 $driver_review = DB::table('tj_user_note')->where('tj_user_note.ride_id',$id)->value('comment');

        return view("rides.show")->with("ride", $ride)->with("currency", $currency)->with("customer_review", $customer_review)->with("driver_review", $driver_review);
    }

    public function updateRide(Request $request, $id)
    {

        $rides = Rides::find($id);
        if ($rides) {
            $rides->statut = $request->input('order_status');
            $rides->save();
        }

        return redirect()->back();

    }

}
