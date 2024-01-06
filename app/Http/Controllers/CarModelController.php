<?php

namespace App\Http\Controllers;


use App\Models\Brand;
use App\Models\CarModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\VehicleType;

use Validator;

// use Illuminate\Support\Facades\Validator;

class CarModelController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request->has('search') && $request->search != '' && $request->selected_search == 'name') {
            $search = $request->input('search');
            $carModel = DB::table('car_model')
                ->where('car_model.name', 'LIKE', '%' . $search . '%')
                ->where('car_model.deleted_at', '=', NULL)
                ->paginate(10);
        }  else {
            $carModel = CarModel::paginate(10);
        }
        $brand=DB::table('brands')->select('*')->get();
        $vehicleType = VehicleType::all();
        return view("carModel.index")->with("carModel", $carModel)->with("brand",$brand)->with('vehicleType',$vehicleType);
    }

    public function create()
    {
        $brand=DB::table('brands')->select('*')->get();
        $vehicleType = VehicleType::all();
        return view("carModel.create")->with('brand',$brand)->with('vehicleType',$vehicleType);
    }

    public function storecarmodel(Request $request)
    {

        $validator = Validator::make($request->all(), $rules = [
            'name' => 'required',
            'brand' => 'required',
            'vehicle_id'=> 'required',

        ], $messages = [
            'name.required' => 'The  Name field is required!',
            'brand.required' => 'The brand field is required!',
            'vehicle_id.required' =>'The vehicle Type field is required!',
        ]);

        if ($validator->fails()) {
            return redirect('car_model/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $carModel = new CarModel;
        $carModel->name = $request->input('name');
        $carModel->brand_id = $request->input('brand');
        $carModel->vehicle_type_id = $request->input('vehicle_id');
        $carModel->status = $request->input('status') ? 'yes' : 'no';


        $carModel->created_at = date('Y-m-d H:i:s');
        $carModel->modifier = date('Y-m-d H:i:s');
        $carModel->updated_at = date('Y-m-d H:i:s');

        $carModel->save();

        return redirect('car_model');

    }


    public function edit($id)
    {
        $carModel = CarModel::where('id', "=", $id)->first();
      // $brand=DB::table('brands')->select('name')->where('id',$carModel->brand_id)->get();
        $brand=DB::table('brands')->select('*')->get();
        $vehicleType = VehicleType::all();

        return view("carModel.edit")->with("carModel", $carModel)->with("brand", $brand)->with('vehicleType', $vehicleType);
    }

   /* public function show($id)
    {

        $user = UserApp::where('id', "=", $id)->first();

        $currency = Currency::where('statut', 'yes')->value('symbole');

        $transactions = Transaction::where('id_user_app', "=", $id)->paginate(10);

        $rides = Requests::
        join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
            ->where('tj_requete.id_user_app', $id)
            ->orderBy('tj_requete.creer', 'DESC')
            ->paginate(10);

        return view("settings.users.show")->with("user", $user)->with("rides", $rides)->with("transactions", $transactions)->with("currency", $currency);
    }*/

    public function UpdateCarModel(Request $request, $id)
    {
        $validator = Validator::make($request->all(), $rules = [
            'name' => 'required',
            'brand_name' => 'required',
            'vehicle_id'=> 'required',

        ], $messages = [
            'name.required' => 'The  Name field is required!',
            'brand_name.required' => 'The brand field is required!',
            'vehicle_id.required' =>'The vehicle Type field is required!',
        ]);

        if ($validator->fails()) {
            return redirect('users/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $name = $request->input('name');
        $brand = $request->input('brand_name');
        $status = $request->input('status') ? 'yes' : 'no';
        $vehicle_type = $request->input('vehicle_id');

        $carModel = CarModel::find($id);
        if ($carModel) {
            $carModel->name = $name;
            $carModel->brand_id = $brand;
            $carModel->status = $status;
            $carModel->vehicle_type_id = $vehicle_type;
            $carModel->updated_at = date('Y-m-d H:i:s');

            $carModel->save();
        }

        return redirect('car_model');
    }

    public function deleteCarModel($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $carModel = CarModel::find($id[$i]);
                    $carModel->delete();
                }

            } else {
                $carModel = CarModel::find($id);
                $carModel->delete();
            }

        }

        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $carModel = CarModel::find($id);
        if ($carModel->status == 'no') {
            $carModel->status = 'yes';
        } else {
            $carModel->status = 'no';
        }

        $carModel->save();
        return redirect()->back();

    }

    public function toggalSwitch(Request $request){
            $ischeck=$request->input('ischeck');
            $id=$request->input('id');
            $carModel = CarModel::find($id);

            if($ischeck=="true"){
              $carModel->status = 'yes';
            }else{
              $carModel->status = 'no';
            }
              $carModel->save();

    }


}
