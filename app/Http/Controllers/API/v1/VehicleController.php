<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\DriverModel;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use DB;

class VehicleController extends Controller
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
    public function index()
    {

        $driver = Vehicle::all();
        $driver = Vehicle::paginate($this->limit);
        return response()->json($driver);
    }

    /*Register Vehicle */
    public function register(Request $request)
    {

        $brand = $request->get('brand_name');
        // $prenom = str_replace("'", "\'", $brand);
        $model = $request->get('model_name');
        $car_category = $request->get('car_category');
        $color = $request->get('color');
        $numberplate = $request->get('carregistration');
        $passenger = $request->get('passenger');

        $package_weight = $request->get('package_weight') ?? '0';
        $package_size = $request->get('package_size') ?? '0';
        $num_of_luggage = $request->get('num_of_luggage') ?? '0';
        $num_of_pets = $request->get('num_of_pets') ?? '0';
        $id_driver = $request->get('id_driver');
        $id_categorie_vehicle = $request->get('id_categorie_vehicle');
        $date_heure = date('Y-m-d H:i:s');
        $car_make = $request->get('car_make')  ?? '';
        $milage = $request->get('milage') ?? '';
        $km = $request->get('km_driven') ?? '';
        $chkdriver = Driver::where('id', $id_driver)->first();
        if (!empty($chkdriver)) {
            $chkid = Vehicle::where('id_conducteur', $id_driver)->first();
            if (!is_null(DriverModel::where('model', $model)->first())) {
                $vehicleModel = DriverModel::where('model', $model)->first();
            } else {
                $vehicleModel = DriverModel::create([
                    'model' => $model,
                    'id_conducteur' => $id_driver
                ]);
            }
            if (!empty($chkid)) {
//            DB::update('update tj_conducteur set model=?',[$vehicleModel->id]);
                $row = $chkid->toArray();
                $id_vehicule = $row['id'];
                $updatedata = DB::update('update tj_vehicule set brand_name = ?,model_name = ?,car_category = ?,passenger = ?,$package_size = ?,$package_weight = ?,$num_of_pets = ?,$num_of_luggage = ?,num_of_petscolor = ?,numberplate = ?,modifier = ?,id_type_vehicule = ?,car_make = ?,
                       km = ?,milage = ? where id = ?', [$brand, $vehicleModel->id, $passenger, $color, $numberplate, $date_heure, $id_categorie_vehicle, $car_make, $km, $milage, $id_vehicule]);

                if (!empty($updatedata)) {
                    $response['success'] = 'Success';
                    $response['error'] = null;
                    $response['message'] = 'Vehicle updated successfully';

                    $get_vehicule = Vehicle::where('id', $id_vehicule)->first();
                    $row = $get_vehicule->toArray();
                    $response['data'] = $row;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Error while updating';
                }
            } else {
                if (!is_null(DriverModel::where('model', $model)->first())) {
                    $vehicleModel = DriverModel::where('model', $model)->first();
                } else {
                    $vehicleModel = DriverModel::create([
                        'model' => $model,
                        'id_conducteur' => $id_driver
                    ]);
                }
//                DB::update('update tj_conducteur set model=?',[$vehicleModel->id]);
                $insertdata = DB::insert("insert into tj_vehicule(passenger,package_size,package_weight,num_of_luggage,num_of_pets,brand_name,model_name,car_category,color,numberplate,id_conducteur,statut,creer,updated_at,id_type_vehicule,car_make,milage,km)
	        values('" . $passenger . "','" . $package_size . "','" .$package_weight. "','".$num_of_luggage."','".$num_of_pets."','" . $brand . "','" . $model . "','" . $car_category . "','" . $color . "','" . $numberplate . "','" . $id_driver . "','yes','" .
                    $date_heure . "','" . $date_heure . "','" . $id_categorie_vehicle . "','" . $car_make . "','" . $milage . "','" . $km . "')");
                $id = DB::getPdo()->lastInsertId();
                if ($id > 0) {
                    $response['success'] = 'success';
                    $response['error'] = null;
                    $response['message'] = 'Vehicle Added successfully';


                    $get_vehicule = Vehicle::where('id', $id)->first();
                    $row = $get_vehicule->toArray();

                    $response['data'] = $row;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Error while Add data';
                }
                $updatedata = DB::update('update tj_conducteur set statut_vehicule = ? where id = ?', ['yes', $id_driver]);

            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Driver Not Found';
        }

        return response()->json($response);
    }

    /*Update Vehicle NumberPlate */

    public function updateVehicle(Request $request)
    {
        $id_user = $request->get('id_conducteur');
        $numberplate = $request->get('numberplate');
        $numberplate = str_replace("'", "\'", $numberplate);
        $date_heure = date('Y-m-d H:i:s');
        if (!empty($id_user) && !empty($numberplate)) {
            $updatedata = DB::update('update tj_vehicule set numberplate = ?, modifier = ? where id_conducteur = ?', [$numberplate, $date_heure, $id_user]);

            if (!empty($updatedata)) {
                $sql = Vehicle::where('id_conducteur', $id_user)->first();
                $row = $sql->toArray();
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'status successfully updated';
                $response['data'] = $row;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to update';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field are missing';
        }
        return response()->json($response);

    }

    /*Update Vehicle color */

    public function updateVehicleColor(Request $request)
    {
        $id_user = $request->get('id_conducteur');
        $color = $request->get('color');
        $color = str_replace("'", "\'", $color);
        $date_heure = date('Y-m-d H:i:s');
        if (!empty($id_user) && !empty($color)) {
            $updatedata = DB::table('tj_vehicule')
                ->where('id_conducteur', $id_user)
                ->update(['color' => $color, 'modifier' => $date_heure]);
            if (!empty($updatedata)) {
                $sql = Vehicle::where('id_conducteur', $id_user)->first();
                $row = $sql->toArray();
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'status successfully updated';
                $response['data'] = $row;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to update';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field are missing';
        }

        return response()->json($response);

    }

    /*Update Vehicle Brand */

    public function updateVehicleBrand(Request $request)
    {
        $id_user = $request->get('id_conducteur');
        $brand = $request->get('brand');
        // $brand = str_replace("'","\'",$brand);
        $date_heure = date('Y-m-d H:i:s');
        if (!empty($id_user) && !empty($brand)) {
            $driver = Driver::where('id',$id_user)->first();
            $driver->statut = 'no';
            $driver->save;
            $updatedata = DB::table('tj_vehicule')
                ->where('id_conducteur', $id_user)
                ->update(['brand_name' => $brand, 'modifier' => $date_heure]);
            if (!empty($updatedata)) {
                $sql = Vehicle::where('id_conducteur', $id_user)->first();
                $row = $sql->toArray();
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'status successfully updated';
                $response['data'] = $row;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to update';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field are missing';
        }
        return response()->json($response);

    }
    public function updateVehicleCat(Request $request)
    {
        $id_user = $request->get('id_conducteur');
        $car_category = $request->get('car_category');

        $date_heure = date('Y-m-d H:i:s');
        if (!empty($id_user) && !empty($car_category)) {
            $driver = Driver::where('id',$id_user)->first();
            $driver->statut = 'no';
            $driver->save;
            $updatedata = DB::table('tj_vehicule')
                ->where('id_conducteur', $id_user)
                ->update(['car_category' => $car_category, 'modifier' => $date_heure]);
            if (!empty($updatedata)) {
                $sql = Vehicle::where('id_conducteur', $id_user)->first();
                $row = $sql->toArray();
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'status successfully updated';
                $response['data'] = $row;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to update';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field are missing';
        }
        return response()->json($response);

    }

    /*Update Vehicle Model */
    public function updateVehicleModel(Request $request)
    {
        $id_user = $request->get('id_conducteur');
        $model = $request->get('model');
        // $brand = str_replace("'","\'",$brand);
        $date_heure = date('Y-m-d H:i:s');
        if (!empty($id_user) && !empty($model)) {
            $driver = Driver::where('id',$id_user)->first();
            $driver->statut = 'no';
            $driver->save;
            $updatedata = DB::table('tj_vehicule')
                ->where('id_conducteur', $id_user)
                ->update(['model_name' => $model, 'modifier' => $date_heure]);
            if (!empty($updatedata)) {
                $sql = Vehicle::where('id_conducteur', $id_user)->first();
                $row = $sql->toArray();
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'status successfully updated';
                $response['data'] = $row;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to update';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field are missing';
        }
        return response()->json($response);

    }

    /*Update Vehicle type */
    public function updateVehicleType(Request $request)
    {
        $id_user = $request->get('id_conducteur');

        $id_vehicle_type = $request->get('id_vehicle_type');
        $date_heure = date('Y-m-d H:i:s');
        if (!empty($id_user) && !empty($id_vehicle_type)) {
            $updatedata = DB::update('update tj_vehicule set id_type_vehicule = ?, modifier = ? where id_conducteur = ?', [$id_vehicle_type, $date_heure, $id_user]);

            if (!empty($updatedata)) {
                $sql = Vehicle::where('id_conducteur', $id_user)->first();
                $row = $sql->toArray();
                $response['success'] = 'success';
                $response['error'] = null;
                $response['message'] = 'status successfully updated';
                $response['data'] = $row;
            } else {
                $response['success'] = 'Failed';
                $response['error'] = 'failed to update';
            }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'some field are missing';
        }
        return response()->json($response);

    }

    /*get Vehicle data */

    public function getVehicleData(Request $request)
    {

        $sql = DB::table('tj_type_vehicule_rental')
            ->select('tj_type_vehicule_rental.*')
            ->where('status', '=', 'yes')
            ->get();
        $output = [];
        foreach ($sql as $row) {
            $id_vehicule = $row->id;

            $sql_nb = DB::table('tj_location_vehicule')
                ->select(DB::raw("COUNT(id) as nb"))
                ->where('id_vehicule_rental', '=', DB::raw($id_vehicule))
                ->where('statut', '=', 'accept')
                ->get();

            $nb = 0;
            foreach ($sql_nb as $row_nb) {
                $nb = $row_nb->nb;
            }
            $row->nb_reserve = $nb;
            if ($row->image != '') {
                if (file_exists('assets/images/type_vehicle_rental' . '/' . $row->image)) {
                    $image_user = asset('assets/images/type_vehicle_rental') . '/' . $row->image;
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $row->image = $image_user;
            }
            $output[] = $row;

        }
        if (!empty($sql)) {
            $response['success'] = 'success';
            $response['error'] = null;
            $response['message'] = 'successfully';
            $response['data'] = $output;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Failed to fetch data';
            $response['message'] = 'successfully';
        }
        return response()->json($response);


    }

    /*get Vehicle category*/

    public function getVehicleCategoryData(Request $request)
    {

        //$sql = "SELECT * FROM tj_type_vehicule";
        $sql = DB::table('tj_type_vehicule')
            ->select('*')
            ->where('status', '=', 'Yes')
            ->where('deleted_at', '=', null)
            ->get();
        $output = [];
        foreach ($sql as $row) {
            $selected_image = $row->selected_image;

            if (file_exists('assets/images/type_vehicle' . '/' . $row->image) && !empty($row->image)) {
                $image_path = asset('assets/images/type_vehicle') . '/' . $row->image;
            } else {
                $image_path = asset('assets/images/placeholder_image.jpg');

            }
            if (file_exists('assets/images/type_vehicle' . '/' . $row->selected_image) && !empty($row->selected_image)) {
                $selected_image_path = asset('assets/images/type_vehicle') . '/' . $row->selected_image;
            } else {
                $selected_image_path = asset('assets/images/placeholder_image.jpg');

            }
            $row->image = $image_path;
            $row->selected_image_path = $selected_image_path;
            $get_commission = DB::table('tj_commission')
                ->select('*')
                ->where('type', '=', 'fixed')
                ->get();

            //$row_commission = $get_commission->toArray();
            foreach ($get_commission as $row_commission) {
                $row->statut_commission = $row_commission->statut;
                $row->commission = $row_commission->value;
                $row->type = $row_commission->type;
            }
            //$get_commission_perc = mysqli_query($con, "select * from tj_commission where type='percentage' limit 1");
            $get_commission_perc = DB::table('tj_commission')
                ->select('*')
                ->where('type', '=', 'percentage')
                ->get();

            foreach ($get_commission_perc as $row_commission_perc) {
                $row->statut_commission_perc = $row_commission_perc->statut;
                $row->commission_perc = $row_commission_perc->value;
                $row->type_perc = $row_commission_perc->type;
            }
            //Delivery Charges
            $get_delivery_chagres = DB::table('delivery_charges')
                ->select('*')
                ->where('id_vehicle_type', '=', $row->id)
                ->get();

            foreach ($get_delivery_chagres as $row_delivery_chagres) {
                $row->day_charges_per_km = $row_delivery_chagres->day_charges_per_km;
                $row->overnight_charges_per_km = $row_delivery_chagres->overnight_charges_per_km;
                $row->peak_charges_km = $row_delivery_chagres->peak_charges_km;
                $row->flag_day_rate = $row_delivery_chagres->flag_day_rate;
                $row->flag_overnight_rate = $row_delivery_chagres->flag_overnight_rate;
                $row->flag_peak_rate = $row_delivery_chagres->flag_peak_rate;
            }

            $output[] = $row;
        }
        if (!empty($sql)) {
            $response['success'] = 'Success';
            $response['error'] = null;
            $response['message'] = 'Successfully fetch data';
            $response['data'] = $output;
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Failed To Fetch Data';
        }
        return response()->json($response);


    }

}
