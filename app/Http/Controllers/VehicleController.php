<?php

namespace App\Http\Controllers;

use App\Models\DeliveryCharges;
use App\Models\RentalVehicleType;
use App\Models\Settings;
use App\Models\VehicleRental;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function vehicleType()
    // {

    //     $types = VehicleType::paginate(10);
    //     return view("vehicle.index")->with("types",$types);
    // }
    public function vehicleType(Request $request)
    {

        if ($request->has('search') && $request->search != '' && $request->selected_search == 'libelle') {

            $search = $request->input('search');
            $types = DB::table('tj_type_vehicule')
                ->where('tj_type_vehicule.libelle', 'LIKE', '%' . $search . '%')
                ->where('tj_type_vehicule.deleted_at', '=', NULL)
                // $types = VehicleType::where('tj_type_vehicule.libelle','LIKE','%'.$search.'%')

                ->paginate(10);


        } elseif ($request->has('search') && $request->search != '' && $request->selected_search == 'prix') {

            $search = $request->input('search');
            $types = DB::table('tj_type_vehicule')
                ->where('tj_type_vehicule.prix', 'LIKE', '%' . $search . '%')
                ->where('tj_type_vehicule.deleted_at', '=', NULL)
                // $types = VehicleType::where('tj_type_vehicule.libelle','LIKE','%'.$search.'%')

                ->paginate(10);


        } else {

            $types = VehicleType::paginate(10);

        }

        return view("vehicle.index")->with("types", $types);
    }

    public function creates()
    {
        $vehicle = VehicleType::all();
        $Settings = Settings::all();

        foreach ($Settings as $data)
            $delivery_distance = $data->delivery_distance;

        return view('vehicle.creates', compact('vehicle'))->with('delivery_distance', $delivery_distance);
    }

    public function store(Request $request)
    {
        // dd($request);
        if ($request->id > 0) {
            $image_validation = "required";

        } else {
            $image_validation = "required";

        }

        $validator = Validator::make($request->all(), $rules = [
            'libelle' => 'required',
            'image' => $image_validation,
            'day_charges_per_km'=>'required',
            'overnight_charges_per_km'=>'required',
            'peak_charges_km'=>'required',
            'flag_day_rate'=>'required',
            'flag_overnight_rate'=>'required',
            'flag_peak_rate'=>'required',

        ], $messages = [
            'libelle.required' => 'The Vehicle Type field is required!',
            'image.required' => 'The Image field is required!',
            'day_charges_per_km.required'=>'Delivery Charges per Miles is required!',
            'overnight_charges_per_km.required' => 'Minimum Delivery Charges is required!',
            'peak_charges_km.required'=>'Minimum Delivery Charges Within Miles is required!',
            'flag_day_rate.required'=>'Flag Day Rate is required!',
            'flag_overnight_rate.required' => 'Flag Overnight Rate is required!',
            'flag_peak_rate.required'=>'Flag PEak Rate is required!',

        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }


        $vehicle = new VehicleType;
        $vehicle->libelle = $request->input('libelle');
        $vehicle->status = !empty($request->input('status')) ? 'Yes' : 'No';

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'image_vehicleType' . $time;
            $selectedfilename = 'selected_image_vehicleType' . $time;
            $file->move(public_path('assets/images/type_vehicle/'), $filename);
            $vehicle->image = $filename;
        }
        $vehicle->creer = date('Y-m-d H:i:s');
        $vehicle->modifier = date('Y-m-d H:i:s');
        $vehicle->updated_at = date('Y-m-d H:i:s');
        $vehicle->save();
        $vedicleType_id = $vehicle->id;

        $flag_day_rate = $request->input('flag_day_rate');
        $flag_overnight_rate = $request->input('flag_overnight_rate');
        $flag_peak_rate = $request->input('flag_peak_rate');


        $delivery = new DeliveryCharges;
        $delivery->day_charges_per_km = $request->input('day_charges_per_km');
        $delivery->overnight_charges_per_km = $request->input('overnight_charges_per_km');
        $delivery->peak_charges_km = $request->input('peak_charges_km');
        $delivery->flag_day_rate = $flag_day_rate;
        $delivery->flag_overnight_rate = $flag_overnight_rate;
        $delivery->flag_peak_rate = $flag_peak_rate;
        $delivery->id_vehicle_type = $vedicleType_id;
        $delivery->created = date('Y-m-d H:i:s');
        $delivery->modifier = date('Y-m-d H:i:s');
        $delivery->save();

        return redirect('vehicle/index');
    }

    public function vehicleTypeEdit($id)
    {

        $type = VehicleType::find($id);
        // $type = DB::table('tj_type_vehicule')
        // ->join('delivery_charges', 'tj_type_vehicule.id', '=', 'delivery_charges.id_vehicle_type')
        // ->select('tj_type_vehicule.id', 'tj_type_vehicule.libelle', 'tj_type_vehicule.image', 'delivery_charges.id_vehicle_type', 'delivery_charges.delivery_charges_per_km', 'delivery_charges.minimum_delivery_charges', 'delivery_charges.minimum_delivery_charges_within_km')
        // ->where('tj_type_vehicule.id', '=', $id)
        // ->get();

        //print_r($type);
        $delivery_charges = DeliveryCharges::where('id_vehicle_type', $id)->first();
        $Settings = Settings::all();

        foreach ($Settings as $data)
            $delivery_distance = $data->delivery_distance;

        return view("vehicle.edits")->with("type", $type)->with('delivery_charges', $delivery_charges)->with('delivery_distance', $delivery_distance);
    }

    public function vehicleTypeUpdate(Request $request, $id)
    {


        $validator = Validator::make($request->all(), $rules = [
            'libelle' => 'required',
            'day_charges_per_km'=>'required',
            'overnight_charges_per_km'=>'required',
            'peak_charges_km'=>'required',
            'flag_day_rate'=>'required',
            'flag_overnight_rate'=>'required',
            'flag_peak_rate'=>'required',

        ], $messages = [
            'libelle.required' => 'The Vehicle Type field is required!',
            'day_charges_per_km.required'=>'Delivery Charges per Miles is required!',
            'overnight_charges_per_km.required' => 'Minimum Delivery Charges is required!',
            'peak_charges_km.required'=>'Minimum Delivery Charges Within Miles is required!',
            'flag_day_rate.required'=>'Flag Day Rate is required!',
            'flag_overnight_rate.required' => 'Flag Overnight Rate is required!',
            'flag_peak_rate.required'=>'Flag PEak Rate is required!',


        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $Libelle = $request->input('libelle');
        $status = !empty($request->input('status')) ? 'Yes' : 'No';
        // $prix = $request->input('prix');
        $modifier = $request->updated_at = date('Y-m-d H:i:s');
        $updated_at = $request->updated_at = date('Y-m-d H:i:s');

        $vehicle = VehicleType::find($id);
        $filename = $vehicle->image;
        if ($vehicle) {
            $vehicle->Libelle = $Libelle;
            $vehicle->status = $status;
            // $vehicle->prix = $prix;
            $vehicle->modifier = $modifier;
            $vehicle->updated_at = $updated_at;
            if ($request->hasfile('image')) {
                $destination = 'assets/images/type_vehicle' . $vehicle->image;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = 'image_vehicleType' . $time;
                $selectedfilename = 'selected_image_vehicleType' . $time;
                $file->move(public_path('assets/images/type_vehicle/'), $filename);
                $vehicle->selected_image = $selectedfilename;
                $vehicle->image = $filename;
            }
            else{
                $vehicle->image = $filename;
            }
            $vehicle->save();

            $day_charges_per_km = $request->input('day_charges_per_km');
            $overnight_charges_per_km = $request->input('overnight_charges_per_km');
            $peak_charges_km = $request->input('peak_charges_km');
            $flag_day_rate = $request->input('flag_day_rate');
            $flag_overnight_rate = $request->input('flag_overnight_rate');
            $flag_peak_rate = $request->input('flag_peak_rate');
            $delivery = DeliveryCharges::where('id_vehicle_type', $id)->first();
            if ($delivery) {
                $delivery->day_charges_per_km = $day_charges_per_km;
                $delivery->overnight_charges_per_km = $overnight_charges_per_km;
                $delivery->peak_charges_km = $peak_charges_km;
                $delivery->flag_day_rate = $flag_day_rate;
                $delivery->flag_overnight_rate = $flag_overnight_rate;
                $delivery->flag_peak_rate = $flag_peak_rate;

                $delivery->modifier = date('Y-m-d H:i:s');

            } else {
                $delivery = new DeliveryCharges;
                $delivery->day_charges_per_km = $day_charges_per_km;
                $delivery->overnight_charges_per_km = $overnight_charges_per_km;
                $delivery->peak_charges_km = $peak_charges_km;
                $delivery->flag_day_rate = $flag_day_rate;
                $delivery->flag_overnight_rate = $flag_overnight_rate;
                $delivery->flag_peak_rate = $flag_peak_rate;
                $delivery->id_vehicle_type = $id;
                $delivery->created = date('Y-m-d H:i:s');
                $delivery->modifier = date('Y-m-d H:i:s');

            }
            $delivery->save();
            return redirect('vehicle/index');
        }

    }


    public function deleteVehicle($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $user = VehicleType::find($id[$i]);
                    $user->delete();
                }

            } else {
                $user = VehicleType::find($id);
                $user->delete();
            }

        }

        return redirect()->back();
    }

    public function vehicleList(Request $request)
    {
        if ($request->has('search') && $request->search != '' && $request->selected_search == 'vehicle_type') {
            $search = $request->input('search');
            $vehicles = DB::table('tj_vehicule_rental')
                ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule_rental.id_type_vehicule_rental')
                ->select('tj_vehicule_rental.*', 'tj_type_vehicule.libelle')
                ->where('tj_type_vehicule.libelle', 'LIKE', '%' . $search . '%')
                ->where('tj_vehicule_rental.deleted_at', '=', NULL)
                ->paginate(10);

            $types = VehicleType::all('libelle', 'id');

        } else if ($request->has('search') && $request->search != '' && $request->selected_search == 'number') {
            $search = $request->input('search');
            $vehicles = DB::table('tj_vehicule_rental')
                ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule_rental.id_type_vehicule_rental')
                ->select('tj_vehicule_rental.*', 'tj_type_vehicule.libelle')
                ->where('tj_vehicule_rental.nombre', 'LIKE', '%' . $search . '%')
                ->where('tj_vehicule_rental.deleted_at', '=', NULL)
                ->paginate(10);

            $types = VehicleType::all('libelle', 'id');

        } else {
            $vehicles = DB::table('tj_vehicule_rental')
                ->join('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule_rental.id_type_vehicule_rental')
                ->select('tj_vehicule_rental.*', 'tj_type_vehicule.libelle')
                ->where('tj_vehicule_rental.deleted_at', '=', NULL)
                ->paginate(10);

            $types = RentalVehicleType::all('libelle', 'id');
        }
        return view("vehicle.vehicle")->with("vehicles", $vehicles)->with('types', $types);
    }

    public function create(Request $request)
    {
        if ($request->id > 0) {
            $image_validation = "required";

        } else {
            $image_validation = "required";

        }

        $validator = Validator::make($request->all(), $rules = [
            'nombre' => 'required',
            'prix' => 'required',
            'nb_place' => 'required',
            'id_type_vehicule_rental' => 'required',
            'image' => $image_validation,

        ], $messages = [
            'nombre.required' => 'The Number of Vehicle field is required!',
            'prix.required' => 'The price field is required!',
            'nb_place.required' => 'The Number of Place field is required!',
            'id_type_vehicule_rental.required' => 'The Vehicle Type is required!',
            'image.required' => 'The Image field is required!',


        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $rental = new VehicleRental;
        $rental->id_type_vehicule_rental = $request->input('id_type_vehicule_rental');
        $rental->prix = $request->input('prix');
        $rental->nombre = $request->input('nombre');
        $rental->nb_place = $request->input('nb_place');
        $rental->statut = $request->input('statut');

        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'image_vehicleType' . $time;
            $selectedfilename = 'selected_image_vehicleType' . $time;
            $file->move('assets/images/vehicule', $filename);
            $rental->image = $filename;
        }
        $rental->creer = date('Y-m-d H:i:s');
        $rental->modifier = date('Y-m-d H:i:s');
        $rental->save();
        return redirect('vehicle/vehicle');
    }

    public function vehiclecreates()
    {

        $rental = VehicleRental::all();
        $vehicle = RentalVehicleType::all();
        //$vehicle = VehicleType::all('libelle', 'id');
        return view('vehicle.vehicle_create', compact('rental', 'vehicle'));
    }

    public function edit($id)
    {
        //  $types = VehicleType::all('libelle', 'id');
        $types = RentalVehicleType::all();
        $vehicle = VehicleRental::where('id', $id)->first();

        return view('vehicle.vehicle_edit', compact('vehicle', 'types'));
        //return view("vehicle.vehicle_edit")->with("vehicle", $vehicle, 'types', $types);
    }

    public function update(Request $request, $id)
    {
        if ($request->id > 0) {
            $image_validation = "required";

        } else {
            $image_validation = "required";

        }

        $validator = Validator::make($request->all(), $rules = [
            'nombre' => 'required',
            'prix' => 'required',
            'nb_place' => 'required',
            'id_type_vehicule_rental' => 'required',
            'image' => $image_validation,

        ], $messages = [
            'nombre.required' => 'The Number of Vehicle field is required!',
            'prix.required' => 'The price field is required!',
            'nb_place.required' => 'The Number of Place field is required!',
            'id_type_vehicule_rental.required' => 'The Vehicle Type is required!',
            'image.required' => 'The Image field is required!',


        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $id_type_vehicule_rental = $request->input('type');
        $prix = $request->input('prix');
        $nb_place = $request->input('nb_place');
        $nombre = $request->input('nombre');
        $modifier = $request->modifier = date('Y-m-d H:i:s');

        $vehicle = VehicleRental::find($id);
        if ($vehicle) {
            $vehicle->id_type_vehicule_rental = $type;
            $vehicle->prix = $prix;
            $vehicle->nb_place = $nb_place;
            $vehicle->nombre = $nombre;
            $vehicle->modifier = $modifier;
            if ($request->hasfile('image')) {
                $destination = 'assets/images/vehicule' . $vehicle->image;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = 'image_vehicle_Rental' . $time;
                $file->move('assets/images/vehicule', $filename);
                $vehicle->image = $filename;
            }
            $vehicle->save();
            return redirect('vehicle/vehicle');
        }

    }

    public function delete($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $user = VehicleRental::find($id[$i]);
                    $user->delete();
                }

            } else {
                $user = VehicleRental::find($id);
                $user->delete();
            }

        }

        return redirect()->back();
    }

    public function toggalSwitch(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $vehicle = VehicleRental::find($id);

        if ($ischeck == "true") {
            $vehicle->statut = 'yes';
        } else {
            $vehicle->statut = 'no';
        }
        $vehicle->save();

    }
    public function vehicleTypeSwitch(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $vehicle = VehicleType::find($id);

        if ($ischeck == "true") {
            $vehicle->status = 'Yes';
        } else {
            $vehicle->status = 'No';
        }
        $vehicle->save();

    }

}
