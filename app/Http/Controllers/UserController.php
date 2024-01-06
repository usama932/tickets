<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Requests;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Validator;

// use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{



    public function index(Request $request)
    {

        if ($request->has('search') && $request->search != '' && $request->selected_search == 'prenom') {
            $search = $request->input('search');
            $users = DB::table('tj_user_app')
                ->where('tj_user_app.prenom', 'LIKE', '%' . $search . '%')
                ->orWhere(DB::raw('CONCAT(tj_user_app.prenom, " ",tj_user_app.nom)'), 'LIKE', '%' . $search . '%')
                ->where('tj_user_app.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('search') && $request->search != '' && $request->selected_search == 'phone') {
            $search = $request->input('search');
            $users = DB::table('tj_user_app')
                ->where('tj_user_app.phone', 'LIKE', '%' . $search . '%')
                ->where('tj_user_app.deleted_at', '=', NULL)
                ->paginate(20);
        } else if ($request->has('search') && $request->search != '' && $request->selected_search == 'email') {
            $search = $request->input('search');
            $users = DB::table('tj_user_app')
                ->where('tj_user_app.email', 'LIKE', '%' . $search . '%')
                ->where('tj_user_app.deleted_at', '=', NULL)
                ->paginate(20);
        } else {
            $users = UserApp::paginate(20);
        }

        //$users = DB::table('tj_user_app')->simplePaginate(10);
        // $users = UserApp::paginate(10);
        /* $results = DB::select("SELECT * FROM tj_user_app"); */
        return view("settings.users.index")->with("users", $users);
    }

    public function create()
    {
        return view("settings.users.create");
    }

    public function storeuser(Request $request)
    {


        if ($request->id > 0) {
            $image_validation = "required";

        } else {
            $image_validation = "required";


        }
        $validator = Validator::make($request->all(), $rules = [
            'nom' => 'required',
            'prenom' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            // 'age' => 'required',
            // 'gender' => 'required',
            'phone' => 'required|unique:tj_user_app',
            'email' => 'required|unique:tj_user_app',
            'photo_path' => $image_validation,
            // 'nic_path' =>$image_validation,
        ], $messages = [
            'nom.required' => 'The First Name field is required!',
            'prenom.required' => 'The Last Name field is required!',
            'email.required' => 'The Email field is required!',
            'email.unique' => 'The Email is already taken!',
            'password.required' => 'The Password field is required!',
            'confirm_password.same' => 'Confirm Password should match the Password',
            'phone.required' => 'The Phone is required!',
            'phone.unique' => 'The Phone field is should be unique!',
            'photo_path.required' => 'The Image field is required!',
        ]);

        if ($validator->fails()) {
            return redirect('users/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $user = new UserApp;
        $user->nom = $request->input('nom');
        $user->prenom = $request->input('prenom');
        $user->email = $request->input('email');

        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        $user->mdp = hash('md5', $password);

        $user->login_type = 'phone';
        $user->phone = $request->input('phone');

        $user->statut = $request->has('statut') ? 'yes' : 'no';

        $user->photo = '';
        $user->photo_nic = '';

        $user->creer = date('Y-m-d H:i:s');
        $user->modifier = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');

        if ($request->hasfile('photo_path')) {
            $file = $request->file('photo_path');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = 'user_image' . $time;
            $file->move(public_path('assets/images/users/'), $filename);
            $image = str_replace('data:image/png;base64,', '', $file);
            $image = str_replace(' ', '+', $image);
            $user->photo_path = $filename;
        }

        // if ($request->hasfile('nic_path')) {
        //     $file = $request->file('nic_path');
        //     $extenstion = $file->getClientOriginalExtension();
        //     $time = time() . '.' . $extenstion;
        //     $filename = 'user_nic_image' . $time;
        //     $file->move('assets/images/users/', $filename);
        //     $image = str_replace('data:image/png;base64,', '', $file);
        //     $image = str_replace(' ', '+', $image);
        //     $user->photo_nic_path = $filename;

        //     $user->statut_nic = $request->has('statut') ? 'yes' : 'no';

        // }

        $user->save();
        return redirect('users');
        //return view("settings.users.index")->with("users", $users);

    }


    public function appUsers()
    {
        return view("settings.users.index")->with("users", $users);
    }

    public function edit($id)
    {

        $user = UserApp::where('id', "=", $id)->first();
        $rides = DB::select("SELECT count(id) as rides

        FROM tj_requete WHERE statut='completed' AND id_user_app=$id");
        return view("settings.users.edit")->with("user", $user)->with("rides", $rides);
    }

    public function show($id)
    {

        // dd("Till here");

        $user = UserApp::where('id', "=", $id)->first();

        $currency = Currency::where('statut', 'yes')->first();

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
    }

    public function userUpdate(Request $request, $id)
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
            'phone' => 'required|unique:tj_user_app,phone,' . $id,
            'email' => 'required|unique:tj_user_app,email,' . $id,
            'photo_path' => $image_validation,

        ], $messages = [
            'nom.required' => 'The First Name field is required!',
            'prenom.required' => 'The Last Name field is required!',
            'email.required' => 'The Email field is required!',
            'email.unique' => 'The Email is already taken!',
            'phone.required' => 'The Phone is required!',
            'phone.unique' => 'The Phone field is should be unique!',
            'photo_path.required' => 'The Image field is required!',

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

        // $gender = $request->input('gender');
        if ($request->input('statut')) {
            $status = "yes";
        } else {
            $status = "no";
        }
        //$address = $request->input('address');
        $email = $request->input('email');


        $user = UserApp::find($id);
        if ($user) {
            $user->nom = $nom;
            $user->prenom = $prenom;
            $user->phone = $phone;
            $user->device_id = $device_id;
            $user->statut = $request->has('statut') ? 'yes' : 'no';
            // $user->age = $age;
            // $user->gender = $gender;
            //$user->address = $address;
            $user->email = $email;
            if ($request->hasfile('photo_path')) {
                $destination = 'assets/images/users/' . $user->photo_path;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('photo_path');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = 'user_' . $id . '.' . $extenstion;
                $file->move(public_path('assets/images/users/'), $filename);

                $user->photo_path = $filename;
            }
            $user->save();
        }

        return redirect()->back();
    }

    public function deleteUser($id)
    {

        if ($id != "") {

            $id = json_decode($id);

            if (is_array($id)) {

                for ($i = 0; $i < count($id); $i++) {
                    $user = UserApp::find($id[$i]);
                    $user->delete();
                }

            } else {
                $user = UserApp::find($id);
                $user->delete();
            }

        }

        return redirect()->back();
    }

    public function profile()
    {
        $user = Auth::user();
        return view('settings.users.profile', compact(['user']));
    }


    public function changeStatus($id)
    {
        $user = UserApp::find($id);
        if ($user->statut == 'no') {
            $user->statut = 'yes';
        } else {
            $user->statut = 'no';
        }

        $user->save();
        return redirect()->back();

    }



    // public function edit($id)
    // {
    //     return view('settings.users.edit')->with('id',$id);
    // }

    // public function profile()
    // {
    //     $user = Auth::user();
    //     return view('settings.users.profile', compact(['user']));
    // }

    public function update(Request $request, $id)
    {
        $name = $request->input('name');
        $password = $request->input('password');
        $old_password = $request->input('old_password');
        $email = $request->input('email');
        if ($password == '') {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'email' => 'required|email'
            ]);
        } else {
            $user = Auth::user();
            if (password_verify($old_password, $user->password)) {
                $validator = Validator::make($request->all(), [
                    'name' => 'required|max:255',
                    'password' => 'required|min:8',
                    'confirm_password' => 'required|same:password',
                    'email' => 'required|email'
                ]);

            } else {
                return Redirect()->back()->with(['message' => "Please enter correct old password"]);
            }

        }

        if ($validator->fails()) {
            $error = $validator->errors()->first();
            return Redirect()->back()->with(['message' => $error]);
        }

        $user = User::find($id);
        if ($user) {
            $user->name = $name;
            $user->email = $email;
            if ($password != '') {
                $user->password = Hash::make($password);
            }
            $user->save();
        }

        return redirect()->back();
    }

    //  public function create()
    // {
    //     return view('settings.users.create');
    // }


    public function getUser()
    {


        $sql = "SELECT u.id,u.nom_prenom,u.telephone,u.email,u.statut,u.creer,u.modifier,c.libelle as libCatUser

        FROM tj_user u, tj_categorie_user c

        WHERE u.id_categorie_user=c.id";

        $result = mysqli_query($con, $sql);

        // output data of each row

        while ($row = mysqli_fetch_assoc($result)) {

            $output[] = $row;

        }


        mysqli_close($con);

        if (mysqli_num_rows($result) > 0) {

            return $output;

        } else {

            return $output = [];

        }

    }
public function toggalSwitch(Request $request){
        $ischeck=$request->input('ischeck');
        $id=$request->input('id');
        $user = UserApp::find($id);

        if($ischeck=="true"){
          $user->statut = 'yes';
        }else{
          $user->statut = 'no';
        }
          $user->save();

}

}
