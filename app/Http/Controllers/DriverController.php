<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Driver;
use App\Models\Requests;
use App\Models\Vehicle;
use App\Models\RequestBooks;
use App\Models\FavoriteRide;
use App\Models\VehicleLocation;
use App\Models\DriversDocuments;
use App\Models\DriverDocument;
use App\Models\Message;
use App\Models\Note;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\VehicleType;
use App\Models\CpvRequirement;
use App\Models\vehicleImages;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Response;
use App\Http\Controllers\GcmController;

class DriverController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(Request $request)
    {

        $query = DB::table('tj_conducteur')
            ->leftJoin('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
            ->leftJoin('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')
            ->select('tj_conducteur.*', 'tj_type_vehicule.libelle');

    	if($request->search != '' && $request->selected_search != '') {
    		$keyword = $request->input('search');
			$field = $request->input('selected_search');
			if($field == "prenom"){
				$query->where('tj_conducteur.prenom', 'LIKE', '%' . $keyword . '%');
				// $query->orWhere('tj_conducteur.nom', 'LIKE', '%' . $keyword . '%');
                $query->orWhere(DB::raw('CONCAT(tj_conducteur.nom, " ",tj_conducteur.prenom)'), 'LIKE', '%' . $keyword . '%');

			}else{
				$query->where('tj_conducteur.'.$field, 'LIKE', '%' . $keyword . '%');

			}
			$query->where('tj_conducteur.deleted_at', '=', NULL);
            $query->paginate(20);
		}

		$drivers = $query->paginate(20);

        $totalRide = DB::table('tj_requete')
        ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
        ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
        ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
        ->where('tj_requete.deleted_at', '=', NULL)
        ->select('tj_requete.id_conducteur')->get();

        return view("drivers.index")->with("drivers", $drivers)->with('totalRide', $totalRide);
    }

    public function approvedDrivers(Request $request)
    {

        $query = DB::table('tj_conducteur')
            ->leftJoin('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
            ->leftJoin('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')
            ->select('tj_conducteur.*', 'tj_type_vehicule.libelle');
            $query->where('tj_conducteur.is_verified','=',1);

    	if($request->search != '' && $request->selected_search != '') {
    		$keyword = $request->input('search');
			$field = $request->input('selected_search');
			if($field == "prenom"){
				$query->where('tj_conducteur.prenom', 'LIKE', '%' . $keyword . '%');
				// $query->orWhere('tj_conducteur.nom', 'LIKE', '%' . $keyword . '%');
                $query->orWhere(DB::raw('CONCAT(tj_conducteur.nom, " ",tj_conducteur.prenom)'), 'LIKE', '%' . $keyword . '%');
			}else{
				$query->where('tj_conducteur.'.$field, 'LIKE', '%' . $keyword . '%');
			}
			$query->where('tj_conducteur.deleted_at', '=', NULL)->where('tj_conducteur.is_verified','=',1);
		}


		$drivers = $query->paginate(20);

    $totalRide = DB::table('tj_requete')
    ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
    ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
    ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
    ->where('tj_requete.deleted_at', '=', NULL)
    ->select('tj_requete.id_conducteur')->get();

        return view("drivers.approved")->with("drivers", $drivers)->with('totalRide', $totalRide);
    }

	public function pendingDrivers(Request $request)
    {
        $query = DB::table('tj_conducteur')
            ->leftJoin('tj_vehicule', 'tj_vehicule.id_conducteur', '=', 'tj_conducteur.id')
            ->leftJoin('tj_type_vehicule', 'tj_type_vehicule.id', '=', 'tj_vehicule.id_type_vehicule')
            ->select('tj_conducteur.*', 'tj_type_vehicule.libelle');
            $query->where('tj_conducteur.is_verified','=',0);

    	if($request->search != '' && $request->selected_search != '') {
    		$keyword = $request->input('search');
			$field = $request->input('selected_search');
    		if($field == "prenom"){
				$query->where('tj_conducteur.prenom', 'LIKE', '%' . $keyword . '%');
				// $query->orWhere('tj_conducteur.nom', 'LIKE', '%' . $keyword . '%');
                $query->orWhere(DB::raw('CONCAT(tj_conducteur.nom, " ",tj_conducteur.prenom)'), 'LIKE', '%' . $keyword . '%');
			}else{
				$query->where('tj_conducteur.'.$field, 'LIKE', '%' . $keyword . '%');
			}
			$query->where('tj_conducteur.deleted_at', '=', NULL)->where('tj_conducteur.is_verified','=',0);
		}


		$drivers = $query->paginate(20);

    $totalRide = DB::table('tj_requete')
    ->join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
    ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
    ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
    ->where('tj_requete.deleted_at', '=', NULL)
    ->select('tj_requete.id_conducteur')->get();

        return view("drivers.pending")->with("drivers", $drivers)->with('totalRide', $totalRide);
    }

    public function statusAproval(Request $request, $id, $type)
    {

		$document = DriversDocuments::find($id);
		$comment = $request->get('comment');

        if($document){
        	if($type == 1){
                $document->document_status = 'Approved';
				$document->comment = '';
            }else{
            	$document->document_status = 'Disapprove';
				$document->comment = $comment;
				// $this->notifyDriver($comment,$document->driver_id);
            }
			$document->save();
        }

		$admin_documents = DB::table('admin_documents')->where('admin_documents.is_enabled','Yes')->count();
		$approved_documents = DriversDocuments::where('driver_id',$document->driver_id)->whereDate('document_expiry', '>', now())->where('document_status','Approved')->count();

		$driver = Driver::find($document->driver_id);
		if($admin_documents == $approved_documents){
			$driver->is_verified = 1;
		}else{
			$driver->is_verified = 0;
		}
		$driver->save();

		if(!blank($comment)){
			echo json_encode(array('success'=>'yes')); die;
		}

        return redirect()->back();
    }

	public function notifyDriver($comment,$id){

		$tmsg = '';
        $terrormsg = '';

        $title = str_replace("'", "\'", "Disapproved of your Document");
        $msg = str_replace("'", "\'", "Admin is Disapproved your Document. Please submit again.");
        $reasons = str_replace("'", "\'", "$comment");

        $tab[] = array();
        $tab = explode("\\", $msg);

        $msg_ = "";
        for ($i = 0; $i < count($tab); $i++) {
            $msg_ = $msg_ . "" . $tab[$i];
        }

        $message = array("body" => $msg_, "reasons" => $reasons, "title" => $title, "sound" => "mySound", "tag" => "documentdisaaproved");

        $driver = DB::table('tj_conducteur')
            ->select('fcm_id')
            ->where('fcm_id', '<>', '')
            ->where('id',$id)
            ->first();

        $tokens = array();
        if(isset($driver->fcm_id)) {
            $tokens[] = $driver->fcm_id;
        }

        $temp = array();
        if(count($tokens) > 0) {
            $date_heure = date('Y-m-d H:i:s');
            $from_id = $id;
            $to_id = $id;
            GcmController::send_notification($tokens, $message, $temp);
        }
	}

    public function statusDisaproval(Request $request, $id, $type)
    {
        $validator = Validator::make($request->all(), $rules = [
            'comment' => 'required',
        ], $messages = [
            'comment.required' => 'Add Comment for disapproval!',
        ]);


        if ($validator->fails()) {
            return redirect('driver/document/view/' . $id)
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $comment = $request->input('comment');
        $approvalStatus = 'disapproved';

        $user = DriversDocuments::find($id);
        if ($user) {
            if ($type == 1) {
                $user->comment = $comment;
                $user->document_status = $approvalStatus;
            } elseif ($type == 2) {
                $user->comment = $comment;
                $user->document_status = $approvalStatus;
            } elseif ($type == 3) {
                $user->comment = $comment;
                $user->document_status = $approvalStatus;
            } elseif ($type == 4) {
                $user->comment = $comment;
                $user->document_status = $approvalStatus;
            }
        }
        $user->save();

        $tmsg = '';
        $terrormsg = '';

        $title = str_replace("'", "\'", "Disapproved of your Document");
        /*$msg=str_replace("'","\'",$driver_name." rejected your ride");*/
        $msg = str_replace("'", "\'", "Admin is Disapproved your Document. Please submit again.");
        $reasons = str_replace("'", "\'", "$comment");

        $tab[] = array();
        $tab = explode("\\", $msg);
        $msg_ = "";
        for ($i = 0; $i < count($tab); $i++) {
            $msg_ = $msg_ . "" . $tab[$i];
        }
        $message = array("body" => $msg_, "reasons" => $reasons, "title" => $title, "sound" => "mySound", "tag" => "documentdisaaproved");

        $query = DB::table('tj_conducteur')
            ->select('fcm_id')
            ->where('fcm_id', '<>', '')
            ->where('id', '=', DB::raw($id))
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
            $date_heure = date('Y-m-d H:i:s');
            $from_id = $id;
            $to_id = $id;
            GcmController::send_notification($tokens, $message, $temp);
            // $insertdata = DB::insert("insert into tj_notification(titre,message,statut,creer,modifier,to_id,from_id,type)
            // values('".$title."','".$msg."','yes','".$date_heure."','".$date_heure."','".$to_id."','".$from_id."','documentdisaaproved')");

        }
        return redirect()->back();
    }


    public function edit($id)
    {
        $driver = Driver::where('id', "=", $id)->first();
        $vehicle = Vehicle::where('id_conducteur', "=", $id)->first();

        $vehicleType = VehicleType::all();

        $brand =Brand::all();
        $model = Carmodel::where('brand_id', "=", $vehicle->brand)->where('vehicle_type_id', "=", $vehicle->id_type_vehicule)->get();
        $currency = Currency::where('statut', 'yes')->value('symbole');

        $vehicleImage = vehicleImages::where('id_driver', '=', $id)->first();
        $earnings = DB::select("SELECT sum(montant) as montant, count(id) as rides FROM tj_requete WHERE statut='completed' AND id_conducteur=$id");

		$avg_rating = Note::where('id_conducteur', "=", $id)->avg('niveau');
		$avg_rating = $avg_rating?$avg_rating:0;

        return view('drivers.edit')->with('driver', $driver)->with('model', $model)->with('brand', $brand)
            ->with("vehicle", $vehicle)->with("earnings", $earnings)->with('vehicleType', $vehicleType)->with('currency', $currency)
            ->with('vehicleImage', $vehicleImage)
			->with('avg_rating', $avg_rating);
    }

    public function create()
    {
        $brand = Brand::all();
        $vehicleType = VehicleType::all();
        $model = Carmodel::all();

        return view('drivers.create')->with('brand', $brand)->with('model', $model)->with('vehicleType', $vehicleType);
    }

    public function getModel(Request $request, $brand_id)
    {
        $id_type_vehicule = $request->get('id_type_vehicule');
        $data['model'] = Carmodel::where("brand_id", $brand_id)->where('vehicle_type_id',$id_type_vehicule)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function getBrand(Request $request, $vehicleType_id)
    {
        $data['brand'] = Brand::where("vehicle_id", $vehicleType_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        if ($request->id > 0) {
            $image_validation = "required";

            $doc_validation = "required";

        } else {
            $image_validation = "required";
            $doc_validation = "required";

        }


        $validator = Validator::make($request->all(), $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'password' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'id_type_vehicule'=>'required',
            'brand_name'=>'required',
            'model_name'=>'required',
            'car_category'=>'required',
            'car_number'=>'required',
            'color'=>'required',
            'passenger'=>'required',
        ], $messages = [
            'nom.required' => 'The First Name field is required!',
            'prenom.required' => 'The Last Name field is required!',
            'email.required' => 'The Email field is required!',
            'email.unique' => 'The Email field is should be unique!',
            'password.required' => 'The Password field is required!',
            'phone.required' => 'The Phone field is required!',
            'phone.unique' => 'The Phone field is should be unique!',
            'id_type_vehicule.required' => 'The Vehicle type field is required!',
            'brand_name.required' => 'The brand field is required!',
            'model_name.required' => 'The model field is required!',
            'car_category.required' => 'The car_category field is required!',
            'car_number.required' => 'The NumberPlate field is required!',
            'color.required' => 'The Color field is required!',
            'passenger.required' => 'The Number of Passenger field is required!',
        ]);

        if ($validator->fails()) {
            return redirect('drivers/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $user = new Driver;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');
        $user->statut = $request->has('statut') ? 'yes' : 'no';
        $user->statut_vehicule = $request->has('statut') ? 'yes' : 'no';
        // $user->tonotify = $request->has('notify') ? 'yes' : 'no';
        $user->online = 'yes';
        $user->status_car_image = 'yes';
        $user->login_type = 'phone';
        // $user->address = $request->input('address');
        $user->device_id = $request->input('device_id');
        $password = $request->input('password');
        $user->mdp = hash('md5', $password);
        $user->phone = $request->input('phone');
        $user->creer = date('Y-m-d H:i:s');
        $user->modifier = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');
        $user->bank_name = $request->input('bank_name');
        $user->holder_name = $request->input('holder_name');
        $user->account_no = $request->input('account_number');
        $user->branch_name = $request->input('branch_name');
        $user->other_info = $request->input('other_information');
        $user->ifsc_code = $request->input('ifsc_code');

        if ($request->hasfile('photo_path')) {
            $file = $request->file('photo_path');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'driver_image_' . $time;
            $file->move(public_path('assets/images/driver/'), $filename);
            $image = str_replace('data:image/png;base64,', '', $file);
            $image = str_replace(' ', '+', $image);
            $user->photo_path = $filename;
        }
        $user->save();
        $driver_id = $user->id;


        $vehicle = new Vehicle;
        $vehicle->brand_name = $request->input('brand_name');
        $vehicle->model_name = $request->input('model_name');
        $vehicle->car_category = $request->input('car_category');
        $vehicle->color = $request->input('color');
        $vehicle->numberplate = $request->input('car_number');
        $vehicle->car_make = '';
        $vehicle->km = $request->input('km') ?? '';
        $vehicle->milage = $request->input('milage') ?? '';
        $vehicle->id_conducteur = $driver_id;
        $vehicle->statut = 'yes';
        $vehicle->creer = date('Y-m-d H:i:s');
        $vehicle->modifier = date('Y-m-d H:i:s');
        $vehicle->updated_at = date('Y-m-d H:i:s');
        $vehicle->id_type_vehicule = $request->input('id_type_vehicule');
        $vehicle->passenger = $request->input('passenger');
        // $vehicle->num_of_luggage = $request->input('num_of_luggage') ?? '';
        // $vehicle->package_weight = $request->input('package_weight');
        // $vehicle->num_of_pets = $request->input('num_of_pets');
        // $vehicle->package_size = $request->input('package_size');
        if ($request->hasfile('car_image')) {
            $file = $request->file('car_image');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'vehicle_' . $time;
            $Selectedfilename = 'selected_vehicleType_' . $time;
           // $file->move('assets/images/vehicle', $filename);
            $file->move(public_path('assets/images/vehicle/'), $filename);
            $vehicle->car_image = $filename;
            // $vehicle_image->selected_image = $Selectedfilename;

        }
        $vehicle->save();
        $vehicle_id = $vehicle->id;

        $vehicle_image = new vehicleImages;
        if ($request->hasfile('image_path')) {
            $file = $request->file('image_path');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'vehicle_' . $time;
            $Selectedfilename = 'selected_vehicleType_' . $time;
           // $file->move('assets/images/vehicle', $filename);
            $file->move(public_path('assets/images/vehicle/'), $filename);
            $vehicle->image_path = $filename;
            // $vehicle_image->selected_image = $Selectedfilename;

        }

        $vehicle_image->id_vehicle = $vehicle_id;
        $vehicle_image->id_driver = $driver_id;
        $vehicle_image->creer = date('Y-m-d H:i:s');
        $vehicle_image->modifier = date('Y-m-d H:i:s');
        $vehicle_image->save();
        $vedicleType_id = $vehicle_image->id;

        return redirect('drivers');
    }


    public function deleteDriver($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $user = Driver::find($id[$i]);
                    $user->delete();
                }

            } else {


                $requests = Requests::where('id_conducteur', $id);
                if ($requests) {
                    $requests->delete();
                }
                $vehicle = Vehicle::where('id_conducteur', $id);
                $vehicle->delete();

                $Message = Message::where('id_conducteur', $id);
                if ($Message) {
                    $Message->delete();
                }


                $Note = Note::where('id_conducteur', $id);
                if ($Note) {
                    $Note->delete();
                }


                $requests_book = RequestBooks::where('id_conducteur', $id);
                if ($requests_book) {
                    $requests_book->delete();
                }

                $user = Driver::find($id);
                if($user){
                    $user->delete();
                }

            }

        }

        return redirect()->back();
    }

    public function updateDriver(Request $request, $id)
    {

        if ($request->id > 0) {
            $image_validation = "required";

            $doc_validation = "required";

        } else {
            $image_validation = "required";
            $doc_validation = "required";

        }

        $validator = Validator::make($request->all(), $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'id_type_vehicule'=>'required',
            'brand_name.required' => 'The brand field is required!',
            'model_name.required' => 'The model field is required!',
            'car_category.required' => 'The car_category field is required!',
            'numberplate'=>'required',
            'color'=>'required',
            'passenger'=>'required',
        ], $messages = [
            'nom.required' => 'The First Name field is required!',
            'prenom.required' => 'The Last Name field is required!',
            'email.required' => 'The Email field is required!',
            'email.unique' => 'The Email field is should be unique!',
            'phone.required' => 'The Phone field is required!',
            'brand_name.required' => 'The brand_name field is required!',
            'model_name.required' => 'The model_name field is required!',
            'car_category.required' => 'The car_category field is required!',
            'phone.unique' => 'The Phone field is should be unique!',
            'id_type_vehicule.required' => 'The Vehicle type field is required!',
            'numberplate.required' => 'The NumberPlate field is required!',
            'color.required' => 'The Color field is required!',
            'passenger.required' => 'The Number of Passenger field is required!',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }


        $nom = $request->input('nom');
        $prenom = $request->input('prenom');
        $phone = $request->input('phone');
        $device_id = $request->input('device_id');
        $status = $request->input('statut');
        $id_type_vehicule = $request->input('id_type_vehicule');
        $brand_name = $request->input('brand_name');
        $model_name = $request->input('model_name');
        $car_category = $request->input('car_category');
        $color = $request->input('color');
        $km = $request->input('km') ?? '';
        $milage = $request->input('milage') ?? '';
        $numberplate = $request->input('numberplate');
        $passenger = $request->input('passenger');
        $bank = $request->input('bank_name');
        $holder = $request->input('holder_name');
        $branch = $request->input('branch_name');
        $acc_no = $request->input('account_number');
        $other_info = $request->input('other_information');
        $ifsc_code = $request->input('ifsc_code');
        if ($status == "on") {
            $status = "yes";
        } else {
            $status = "no";
        }

        $address = $request->input('address');
        $email = $request->input('email');
        $user = Driver::find($id);
        $vehicle = Vehicle::where('id_conducteur', "=", $id)->first();
        if ($user) {
            $user->nom = $nom;
            $user->prenom = $prenom;
            $user->phone = $phone;
            $user->device_id = $device_id;
            $user->statut = $status;
            $user->address = $address;
            $user->email = $email;
            $user->bank_name = $bank;
            $user->branch_name = $branch;
            $user->holder_name = $holder;
            $user->account_no = $acc_no;
            $user->other_info = $other_info;
            $user->ifsc_code = $ifsc_code;
            if ($request->hasfile('photo_path')) {
                $destination = 'assets/images/driver/' . $user->photo_path;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo_path');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = 'driver_' . $id . '.' . $extenstion;
                $file->move(public_path('assets/images/driver/'), $filename);
                $user->photo_path = $filename;
            }

            $user->save();
        }
        if($vehicle->car_image) {
            if ($request->hasfile('car_image')) {
                $destination = 'assets/images/vehicle' .$vehicle->car_image;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('car_image');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = 'vehicle_' . $id . '.' . $extenstion;
                $file->move(public_path('assets/images/vehicle/'), $filename);
                $vehicle->car_image = $filename;

            }
        }else{

            if ($request->hasfile('car_image')) {
                $file = $request->file('car_image');

                $extenstion = $file->getClientOriginalExtension();

                $time = time() . '.' . $extenstion;
                $filename = 'vehicle_' . $id . '.' . $extenstion;
                //print_r($filename);die();
                $file->move(public_path('assets/images/vehicle/'), $filename);
                $vehicle->car_image = $filename;
                // $vehicle_image->selected_image = $Selectedfilename;

            }
        }
        $vehicle_image = vehicleImages::where('id_driver', "=", $id)->first();
        if ($vehicle_image) {
            if ($request->hasfile('image_path')) {
                $destination = 'assets/images/vehicle' . $vehicle_image->image_path;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('image_path');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = 'vehicle_' . $id . '.' . $extenstion;
                $file->move(public_path('assets/images/vehicle/'), $filename);
                $vehicle_image->image_path = $filename;
                $vehicle_image->save();
            }
        }else{
            $vehicle_image = new vehicleImages;
            if ($request->hasfile('image_path')) {
                $file = $request->file('image_path');

                $extenstion = $file->getClientOriginalExtension();

                $time = time() . '.' . $extenstion;
                $filename = 'vehicle_' . $id . '.' . $extenstion;
                //print_r($filename);die();
                $file->move(public_path('assets/images/vehicle/'), $filename);
                $vehicle_image->image_path = $filename;
                // $vehicle_image->selected_image = $Selectedfilename;

            }
            $vehicle_image->id_vehicle = $vehicle->id;
            $vehicle_image->id_driver = $id;
            $vehicle_image->creer = date('Y-m-d H:i:s');
            $vehicle_image->modifier = date('Y-m-d H:i:s');
            $vehicle_image->save();
        }
        if ($vehicle) {
            $vehicle->id_type_vehicule = $id_type_vehicule;
            $vehicle->brand_name = $brand_name;
            $vehicle->model_name = $model_name;
            $vehicle->car_category = $car_category;
            $vehicle->color = $color;
            $vehicle->km = $km;
            $vehicle->milage = $milage;
            $vehicle->numberplate = $numberplate;
            $vehicle->passenger = $passenger;
            // $vehicle->num_of_luggage = $request->input('num_of_luggage');
            // $vehicle->package_weight = $request->input('package_weight');
            // $vehicle->num_of_pets = $request->input('num_of_pets');
            // $vehicle->package_size = $request->input('package_size');
            $vehicle->id_type_vehicule=$request->input('id_type_vehicule');
            $vehicle->save();
        }


        return redirect('drivers');
    }

    public function show($id)
    {
        $driver = Driver::where('id', "=", $id)->first();

        $vehicle=DB::table('tj_vehicule')->leftjoin('brands','brands.id','=','tj_vehicule.brand')
                                        ->leftjoin('car_model','car_model.id','=','tj_vehicule.model')
                                        ->select('tj_vehicule.*','brands.name as brand','car_model.name as model')
                                        ->where('id_conducteur', "=", $id)->first();

        //$vehicle = Vehicle::where('id_conducteur', "=", $id)->first();
        $currency = Currency::where('statut', 'yes')->first();
        $rides = Requests::
        join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
            ->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
            ->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
            ->select('tj_requete.id', 'tj_requete.statut', 'tj_requete.statut_paiement', 'tj_requete.depart_name', 'tj_requete.destination_name', 'tj_requete.distance', 'tj_requete.montant', 'tj_requete.creer', 'tj_conducteur.id as driver_id', 'tj_conducteur.prenom as driverPrenom', 'tj_conducteur.nom as driverNom', 'tj_user_app.id as user_id', 'tj_user_app.prenom as userPrenom', 'tj_user_app.nom as userNom', 'tj_payment_method.libelle', 'tj_payment_method.image')
            ->where('tj_requete.id_conducteur', $id)
            ->orderBy('tj_requete.creer', 'DESC')
            ->paginate(10);
        $cpvs = CpvRequirement::where('driver_id',$id)->first();
        return view('drivers.show')->with('driver', $driver)->with("vehicle", $vehicle)->with("rides", $rides)->with("currency", $currency)->with('cpvs', $cpvs);
    }

    public function changeStatus($id)
    {
        $driver = Driver::find($id);
        if ($driver->statut == 'no') {
            $driver->statut = 'yes';
        } else {
            $driver->statut = 'no';
        }

        $driver->save();
        return redirect()->back();

    }

    public function documentView($id)
    {
        
		$driver = Driver::where('id', "=", $id)->first();

		$admin_documents = DB::table('admin_documents')->where('admin_documents.is_enabled','Yes')->get();

		$admin_documents->map(function ($admin_document, $key) use ($id){
			$driver_document = DB::table('driver_document')->where('driver_id',$id)->where('document_id',$admin_document->id)->first();
			$admin_document->driver_document = $driver_document;
			return $admin_document;
		});

        return view('drivers.viewDocument')->with('admin_documents',$admin_documents)->with('driver',$driver);
    }



      public function uploaddocument($id,$doc_id)
      {
          $document=DB::table('admin_documents')->where('is_enabled','=','Yes')->get();
          $dr_document = DB::table('driver_document')->where('driver_id',$id)->first();
          return view('drivers.uploaddocument')->with('id', $id)->with('document_id',$doc_id)->with('document',$document)->with('dr_document',$dr_document);
      }


    public function updatedocument(Request $request, $id)
    {

        $validator = Validator::make($request->all(), $rules = [
            'document_path' => "required",
            '' => "required",

        ], $messages = [
            'document_path.required' => 'The docuemnt field is required!',
            'document_expiry.required' => 'Expiry Date Required'

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $document_id = $request->input('document_id');

		$document_name = DB::table('admin_documents')->where('id', $document_id)->first();
        // print_r($document_id);
        // exit;
        $driver = DriversDocuments::where('driver_id', "=", $id)->where('document_id','=',$document_id)->first();

        if ($driver) {

            if ($request->hasfile('document_path')) {

                $destination = 'assets/images/driver/documents/' . $driver->document_path;

                if (File::exists($destination)) {
                    File::delete($destination);
                }

                $file = $request->file('document_path');

                $extenstion = $file->getClientOriginalExtension();

                $filename = str_replace(' ','_',$document_name->title) . '_' . time() . '.' . $extenstion;

                $file->move(public_path('assets/images/driver/documents/'), $filename);

                $driver->document_path = $filename;

                $driver->document_expiry = $request->document_expiry;

                $driver->document_status = 'Pending';
            }

            $driver->save();

        }else{

          $driver = new DriversDocuments;

          if ($request->hasfile('document_path')) {

              $file = $request->file('document_path');

              $extenstion = $file->getClientOriginalExtension();

              $filename = str_replace(' ','_',$document_name->title) . '_' . time() . '.' . $extenstion;

              $file->move(public_path('assets/images/driver/documents/'), $filename);

              $driver->document_path = $filename;

              $driver->document_status = 'Pending';
              $driver->document_expiry = $request->document_expiry;
          }

          $driver->driver_id = $id;

          $driver->document_id = $request->input('document_id');

          $driver->save();
        }

		return redirect()->route('driver.documentView',$id);
        /*return redirect()->back();*/
    }

    public function toggalSwitch(Request $request)
    {
        $ischeck = $request->input('ischeck');
        $id = $request->input('id');
        $driver = Driver::find($id);

        if ($ischeck == "true") {
            $driver->statut = 'yes';
        } else {
            $driver->statut = 'no';
        }
        $driver->save();

    }

}
