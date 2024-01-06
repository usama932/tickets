<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\DeliveryCharges;
use Illuminate\Http\Request;
use DB;

class DriverController extends Controller
{

    // public function __construct()
    // {
    //     $this->limit = 20;
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $users = Driver::all();
        $users = Driver::paginate($this->limit);
        return response()->json($users);
    }

    public function getData(Request $request)
    {

        $lat1 = $request->get('lat1');
        $lng1 = $request->get('lng1');
        $lat2 = $request->get('lat2');
        $lng2 = $request->get('lng2');
        $sql = DB::table('tj_type_vehicule')
            ->crossJoin('tj_vehicule')
            ->crossJoin('delivery_charges')
            // ->leftJoin('brands', 'brands.id', '=', 'tj_vehicule.brand')
            // ->leftJoin('remaining_tokens', 'remaining_tokens.user_id', '=', 'brands.id')
            ->crossJoin('tj_conducteur')
            ->leftJoin('remaining_tokens', 'remaining_tokens.user_id', '=', 'tj_conducteur.id')
            ->select('tj_conducteur.id', 'tj_conducteur.nom', 'tj_conducteur.wheel_chair', 'tj_type_vehicule.libelle', 'tj_type_vehicule.status', 'tj_type_vehicule.currency',
                'tj_type_vehicule.prix', 'tj_conducteur.prenom', 'tj_conducteur.phone', 'tj_conducteur.email',
                'tj_conducteur.online', 'tj_conducteur.photo_path as photo', 'tj_conducteur.latitude', 'tj_conducteur.longitude','delivery_charges.flag_day_rate','delivery_charges.overnight_charges_per_km','delivery_charges.flag_overnight_rate','delivery_charges.peak_charges_km','delivery_charges.flag_peak_rate',
                'tj_vehicule.id as idVehicule', 'tj_vehicule.brand_name', 'tj_vehicule.model_name','tj_vehicule.car_category', 'tj_vehicule.color', 'tj_vehicule.numberplate','delivery_charges.day_charges_per_km',
                'tj_vehicule.passenger', 'tj_type_vehicule.libelle as typeVehicule')
            ->where('tj_vehicule.id_type_vehicule', '=', DB::raw('tj_type_vehicule.id'))
            ->where('delivery_charges.id_vehicle_type', '=', DB::raw('tj_vehicule.id_type_vehicule'))
            ->where('tj_vehicule.id_conducteur', '=', DB::raw('tj_conducteur.id'))
            ->where('tj_vehicule.statut', '=', 'yes')->where('tj_conducteur.statut', '=', 'yes')
            ->where('tj_conducteur.is_verified', '=', '1')->where('tj_conducteur.online', '!=', 'no')
            ->where('tj_type_vehicule.status', '=', 'yes')
            ->where('tj_conducteur.latitude', '!=', '')->where('tj_conducteur.longitude', '!=', '')
            ->where('remaining_tokens.tokens', '>', 0)
            //->groupBy('tj_conducteur.id')
            ->get();

//		}
        //dd($sql);
        $allDistance = array();
        if ($sql->count() > 0) {
            $output = array();
            foreach ($sql as $row) {

                $id_conducteur = $row->id;
                if ($row->latitude != '' && $row->longitude != '')
                    $row->distance = DriverController::distance($row->latitude, $row->longitude, $lat1, $lng1);
                $row->destinationDistance = DriverController::distance($lat1, $lng1, $lat2, $lng2);
                $row->unit = 'KM';
                $allDistance[] = $row->distance;
                $sql_nb_avis = DB::table('tj_note')->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau) as somme"))->where('id_conducteur', '=', DB::raw($row->idVehicule))->get();
                $row->price = round($row->destinationDistance * floatval($row->prix), 0);
                if (!empty($sql_nb_avis)) {

                    foreach ($sql_nb_avis as $row_nb_avis) {

                        $somme = $row_nb_avis->somme;
                        $nb_avis = $row_nb_avis->nb_avis;

                        if ($nb_avis != 0) {
                            $moyenne = $somme / $nb_avis;
                        } else {
                            $moyenne = 0;
                        }
                    }
                } else {
                    $somme = 0;
                    $nb_avis = 0;
                    $moyenne = 0;
                }

                $row->moyenne = $moyenne;

                $sql_total = DB::table('tj_requete')->select(DB::raw("COUNT(id) as total_completed_ride"))->where('id_conducteur', '=', DB::raw($id_conducteur))->where('statut', '=', 'completed')->get();

                foreach ($sql_total as $row_total) {
                    $row->total_completed_ride = $row_total->total_completed_ride;
                }

                if ($row->photo != '') {

                    if ($row->photo) {
                        $image_user = asset('assets/images/driver') . '/' . $row->photo;
                    } else {
                        $image_user = asset('assets/images/placeholder_image.jpg');

                    }
                    $row->photo = $image_user;
                }
                if ($row->distance <= 20) {
                    $output[] = $row;
                }

            }

            function cmp($a, $b)
            {
                if ($a->distance == $b->distance)
                    return 0;
                return ($a->distance < $b->distance) ? -1 : 1;
            }

            if (!is_null($output)) {
                usort($output, 'App\Http\Controllers\API\v1\cmp');
            }
            if (count($output) > 0) {
                $response['success'] = 'Success';
                $response['error'] = null;
                $response['message'] = 'Successfully fetched data';
                $response['data'] = $output;
                return response()->json($response);
            }else {
                $response['success'] = 'Success';
                $response['error'] = null;
                $response['message'] = 'No driver found';
                $response['data'] = $output;
                return response()->json($response);
            }
        } else {
            $response['success'] = 'Success';
            $response['error'] = null;
            $response['message'] = 'No vehicle currently available in your area';
            $response['data'] = null;
            return response()->json($response, 422);
        }

    }

    // public static function cmp($a,$b){
    //   if ($a["distance"]==$b["distance"])
    //       return 0;
    //       return ($a["distance"] < $b["distance"])?-1:1;
    // }

    public static function distance($lat1, $lng1, $lat2, $lng2)
    {
        $rad = M_PI / 180;
        return acos(sin($lat2 * $rad) * sin($lat1 * $rad) + cos($lat2 * $rad) * cos($lat1 * $rad)
                * cos($lng2 * $rad - $lng1 * $rad)) * 6371;// Kilometers
    }

    public function changeStatus(Request $request)
    {
        $table = DB::table('tj_conducteur')->where('id', '=', $request->get('tj_conducteur'))->first();
        if ($table->online == 'yes') {
            DB::table('tj_conducteur')->where('id', '=', $request->get('tj_conducteur'))->update(['online' => 'no']);
            $message = 'Your status is active now';
        } else if ($table->online == 'no') {
            DB::table('tj_conducteur')->where('id', '=', $request->get('tj_conducteur'))->update(['online' => 'yes']);
            $message = 'Your status is inactive';
        }
        return response()->json(['status' => 200, 'message' => $message, 'data' => $table = DB::table('tj_conducteur')->where('id', '=', $request->get('tj_conducteur'))->first()]);
    }
    public function destination(Request $request){

        $lat1 = $request->get('lat1');
        $lng1 = $request->get('lng1');
        $lat2 = $request->get('lat2');
        $lng2 = $request->get('lng2');

        $destinationDistance = DriverController::distance($lat1, $lng1, $lat2, $lng2);
        return response()->json(['status' => 200, 'message' => 'this is destination distance', 'data' => $destinationDistance]);
    }
    public function get_statut(Request $request){
        $sql = DB::table('tj_conducteur')->where('id',$request->user_id)->first();
        if(!empty($sql)){
            $status = $sql->statut;
        }
        else{
            $status = "driver is not found";

        }
        return response()->json(['status' => 200, 'message' => "Statut get", 'data' =>  $status]);
    }
}
