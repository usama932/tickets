<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Currency;
use App\Models\Driver;
use App\Models\Requests;
use App\Models\Settings;
use App\Models\UserApp;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //  dd('sadsad');
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');

        $currency = Currency::where('statut', 'yes')->first();

        $total_users = UserApp::count();
        // $total_drivers = Driver::join('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
        // ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')->count();
        $total_drivers = Driver::leftJoin('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
        ->leftJoin('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')->count();

        //$total_rides = Requests::where('statut','completed')->count();

        $today_users = UserApp::whereBetween('creer', [$date_start, $date_end])->count('id');
        $today_drivers = Driver::join('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
        ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')
        ->whereBetween('tj_conducteur.creer', [$date_start, $date_end])->count();
        // $today_rides = Requests::where('statut','completed')->whereBetween('creer', [$date_start, $date_end])->count('id');

        $new_rides = Requests::where('statut', 'new')->count('id');
        $on_rides = Requests::where('statut', 'on ride')->count('id');

        $confirmed_rides = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
        ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
        ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
        ->where('tj_requete.statut', 'confirmed')
        ->where('tj_requete.deleted_at', '=', NULL)
        ->count('tj_requete.id');

        $today_confirmed_rides = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
        ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
        ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
        ->where('tj_requete.deleted_at', '=', NULL)
        ->where('tj_requete.statut', 'confirmed')->whereBetween('tj_requete.creer', [$date_start, $date_end])->count('tj_requete.id');

        $completed_rides = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
        ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
        ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
        ->where('tj_requete.deleted_at', '=', NULL)
        ->where('tj_requete.statut', 'completed')->count('tj_requete.id');

        $today_completed_rides = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
        ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
        ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
        ->where('tj_requete.deleted_at', '=', NULL)
        ->where('tj_requete.statut', 'completed')->whereBetween('tj_requete.creer', [$date_start, $date_end])->count('tj_requete.id');

        $canceled_rides = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
          ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
          ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
          ->where('tj_requete.statut', 'canceled')
          ->orwhere('tj_requete.statut', 'rejected')
          ->where('tj_requete.deleted_at', '=', NULL)->count('tj_requete.id');

        $today_canceled_rides = Requests::join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
          ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
          ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
          ->where('tj_requete.deleted_at', '=', NULL)
          ->whereIn('tj_requete.statut', ['canceled','rejected'])->whereBetween('tj_requete.creer', [$date_start, $date_end])->count('tj_requete.id');

        $total_admin_commission = Requests::where('statut', 'completed')->sum('admin_commission');

        $today_admin_commission = Requests::where('statut', 'completed')->whereBetween('creer', [$date_start, $date_end])->sum('admin_commission');

        $saletoday = Requests::where('statut', 'completed')->whereBetween('creer', [$date_start, $date_end])->count('id');
        $commitionfortoday = Commission::where('statut', 'yes')->whereBetween('creer', [$date_start, $date_end])->sum('value');

        $day = date('w');
        $week_start = date('Y-m-d', strtotime('-' . $day . ' days'));
        $week_end = date('Y-m-d', strtotime('+' . (6 - $day) . ' days'));
        $week_start = date('Y-m-d', strtotime($week_start . ' +1 day'));
        $week_end = date('Y-m-d', strtotime($week_end . ' +1 day'));
        $commitionforweek = Commission::where('statut', 'yes')->whereBetween('creer', [$week_start, $week_end])->sum('value');

        $date_heure = date('Y-m-d');
        $date_start = date("Y-m-d", strtotime(date('Y-m-1')));
        $date_end = date("Y-m-t", strtotime($date_heure));
        $commitionformonth = Commission::where('statut', 'yes')->whereBetween('creer', [$date_start, $date_end])->sum('value');

        $drivers = Driver::where('statut', '=', 'no')->get();
        $active_drivers = Driver::where('statut', '=', 'yes')->inRandomOrder()->limit(10)->get();

        $latest_rides = Requests::
        join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
            ->where('tj_requete.statut', 'completed')->inRandomOrder()->limit(10)->get();

        $total_earnings = $this->getTotalEarnings();
        //$total_drivers_earnings = $this->getEarnings('','driver');

        $today_earnings = $this->getTotalEarnings('today');
        //$today_drivers_earnings = $this->getEarnings('today','driver');

        $admin_commision = $currency->symbole ?? '$';
        //DB::enableQueryLog();

        $vehicles = Vehicle::leftjoin('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')->where('statut', 'yes')->groupBy('brand')->inRandomOrder()->limit(10)->get();

        if (@$_REQUEST['dev']) {
            echo '<pre>';
            print_r($latest_rides);
            echo '</pre>';
            die;
        }


        return view('home')->with("total_users", $total_users)
            ->with("total_drivers", $total_drivers)
            ->with("today_users", $today_users)
            ->with("today_drivers", $today_drivers)
            ->with("vehicles", $vehicles)
            ->with("new_rides", $new_rides)
            ->with("on_rides", $on_rides)
            ->with("confirmed_rides", $confirmed_rides)
            ->with("today_confirmed_rides", $today_confirmed_rides)
            ->with("completed_rides", $completed_rides)
            ->with("todays_completed_ride", $today_completed_rides)
            ->with("canceled_rides", $canceled_rides)
            ->with("today_canceled_rides", $today_canceled_rides)
            ->with("saletoday", $saletoday)
            ->with("commitionfortoday", $commitionfortoday)
            ->with("commitionforweek", $commitionforweek)
            ->with("commitionformonth", $commitionformonth)
            ->with("currency", $currency)
            ->with("drivers", $drivers)
            ->with("active_drivers", $active_drivers)
            ->with("total_earnings", $total_earnings)
            ->with("today_earnings", $today_earnings)
            ->with("latest_rides", $latest_rides)
            ->with("admin_commision", $admin_commision)
            ->with("today_admin_commission", $today_admin_commission)
            ->with('total_admin_commission', $total_admin_commission);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
       // dd('sadsad');
        return view('index');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function users()
    {
        return view('users');
    }

    public function updateDriverStatus(Request $request, $id)
    {
        $driver = Driver::find($id);
        if ($driver) {
            $driver->statut = 'yes';
        }
        $driver->save();
        return redirect()->back();
    }

    public function getTotalEarnings($type = null)
    {
        $currency = Currency::where('statut', 'yes')->value('symbole');
        $date_start = date('Y-m-d 00:00:00');
        $date_end = date('Y-m-d 23:59:59');
        $trip = Requests::where('statut', 'completed');
        if ($type == "today") {
            $trip->whereBetween('tj_requete.creer', [$date_start, $date_end]);
        }
        $trip = $trip->get();
//echo"<pre>";print_r($trip);
        $total_earning = 0;
        $admin_commission = 0;
        foreach ($trip as $value) {
            $total_earning = $total_earning + intval($value->montant);
            $total_earning = $total_earning - intval($value->discount);
            $total_earning = $total_earning + intval($value->tax);
        }
        return $total_earning;


    }

    /*	public function getEarnings($type='',$user_type=''){

            $currency = Currency::where('statut', 'yes')->value('symbole');


            $date_start = date('Y-m-d 00:00:00');

            $date_end = date('Y-m-d 23:59:59');

            $percent_amount = Commission::where('type','Percentage')->where('statut', 'yes')->value('value');

            $fixed_amount = Commission::where('type','Fixed')->where('statut', 'yes')->value('value');

            if($user_type == "driver"){
                $query = Requests::join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id');
                $query->where('tj_conducteur.statut','yes');
            }else{
                $query = Requests::leftjoin('tj_user_app','tj_requete.id_user_app', '=', 'tj_user_app.id')->leftjoin('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id');
            }

            if($type == "today"){
                $query->whereBetween('tj_requete.creer',[$date_start,$date_end]);
            }

            if(@$_REQUEST['devsql']){
                echo $query->toSql(); die;
            }

            $amounts = $query->pluck('montant')->toArray();

            $earning = 0;

            if(count($amounts) > 0){

                if($percent_amount){

                    foreach($amounts as $amount){
                         $cu = $amount;
                        $cu = ($cu - $fixed_amount) * $percent_amount;
                        $earning = (Float)$earning + ((Float)$cu + (Float)$fixed_amount);
                     }

                }else if($fixed_amount){

                    foreach($amounts as $amount){
                         $cu = $amount;
                        $earning = (Float)$earning + (Float)$fixed_amount;
                     }
                }
            }

            return $earning;
        }*/

    public function getSalesOverview()
    {
        $v01 = 0;
        $v02 = 0;
        $v03 = 0;
        $v04 = 0;
        $v05 = 0;
        $v06 = 0;
        $v07 = 0;
        $v08 = 0;
        $v09 = 0;
        $v10 = 0;
        $v11 = 0;
        $v12 = 0;
        $currentYear = date('Y');
        $currentMonth = date('m');


        $order = Requests::where('statut', 'completed')->get();

        foreach ($order as $key => $value) {
            $price = 0;
            $orderMonth = date('m', strtotime($value->creer));
            $orderYear = date('Y', strtotime($value->creer));
            $price = intval($value->montant);
            $price = $price - intval($value->discount);
            $price = $price + intval($value->tax);
            if ($currentYear == $orderYear) {
                switch ($orderMonth) {
                    case "01":
                        $v01 = intval($v01) + $price;
                        break;
                    case "02":
                        $v02 = intval($v02) + $price;
                        break;
                    case "03":
                        $v03 = intval($v03) + $price;
                        break;
                    case "04":
                        $v04 = intval($v04) + $price;
                        break;
                    case "05":
                        $v05 = intval($v05) + $price;
                        break;
                    case "06":
                        $v06 = intval($v06) + $price;
                        break;
                    case "07":
                        $v07 = intval($v07) + $price;
                        break;
                    case "08":
                        $v08 = intval($v08) + $price;
                        break;
                    case "09":
                        $v09 = intval($v09) + $price;
                        break;
                    case "10":
                        $v10 = intval($v10) + $price;
                        break;
                    case "11":
                        $v11 = intval($v11) + $price;
                        break;
                    default :
                        $v12 = intval($v12) + $price;
                        break;
                }
            }

        }
        $data['v1'] = $v01;
        $data['v2'] = $v02;
        $data['v2'] = $v03;
        $data['v4'] = $v04;
        $data['v5'] = $v05;
        $data['v6'] = $v06;
        $data['v7'] = $v07;
        $data['v8'] = $v08;
        $data['v9'] = $v09;
        $data['v10'] = $v10;
        $data['v11'] = $v11;
        $data['v12'] = $v12;
        echo json_encode($data);

    }
}
