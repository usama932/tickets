<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\language;
use App\Models\Requests;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Validator;
use App;

// use Illuminate\Support\Facades\Validator;

class languageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function change(Request $request)
    {
        
        App::setLocale($request->lang);
        
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }
    public function getCode($slugid){
        $data = DB::table('language')
        ->where('code','=',$slugid)
        ->get();
        
        return response()->json($data);
    }
    public function index(Request $request)
    {

        if ($request->has('search') && $request->search != '' && $request->selected_search == 'prenom') {
            $search = $request->input('search');
            $language = DB::table('language')
                ->where('language.language', 'LIKE', '%' . $search . '%')
                ->paginate(10);

        } else {
            $language = language::paginate(10);
            
        }

        //$users = DB::table('tj_user_app')->simplePaginate(10);
        // $users = UserApp::paginate(10);
        /* $results = DB::select("SELECT * FROM tj_user_app"); */
        return view("language.index")->with("language", $language);
    }
    public function getLangauage()
    {
         $data = DB::table('language')
         ->where('status','=','true')
         ->get();
         return response()->json($data);
       // $language = language::all();
        
       // return view("layouts.header")->with("language", $language);

    }

    public function create()
    {
        return view("language.create");
    }

    public function storeuser(Request $request)
    {


        if ($request->id > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
            $doc_validation = "mimes:doc,pdf,docx,zip,txt";

        } else {
            $image_validation = "required|mimes:jpeg,jpg,png";
            $doc_validation = "required|mimes:doc,pdf,docx,zip,txt";

        }
        $validator = Validator::make($request->all(), $rules = [
            'language' => 'required',
            'code' => 'required',
            'flag' => $image_validation,
        ], $messages = [
            'language.required' => 'The First Name field is required!',
            'code.required' => 'The Code field is required!',
            'flag.required' => 'The flag field is required!',

        ]);

        if ($validator->fails()) {
            return redirect('language/create')
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }
        $user = new language;
        $user->language = $request->input('language');
        $user->code = $request->input('code');


        $user->status = $request->has('status') ? 'true' : 'false';
        $user->is_rtl = $request->has('is_rtl') ? 'true' : 'false';


        $user->flag = '';

        $user->creer = date('Y-m-d H:i:s');
        $user->modifier = date('Y-m-d H:i:s');
        $user->updated_at = date('Y-m-d H:i:s');


        if ($request->hasfile('flag')) {
            $file = $request->file('flag');
            $extenstion = $file->getClientOriginalExtension();
            $time = time() . '.' . $extenstion;
            $filename = $request->input('language') . '.' . $extenstion;
            $file->move('assets/images/flags/', $filename);
            $image = str_replace('data:image/png;base64,', '', $file);
            $image = str_replace(' ', '+', $image);
            $user->flag = $filename;
        }


        $user->save();

        return redirect('language');

    }


    public function edit($id)
    {

        $language = language::where('id', "=", $id)->first();

        return view("language.edit")->with("language", $language);
    }

    // public function show($id)
    // {

    //   // dd("Till here");

    //     $user = UserApp::where('id',"=", $id)->first();

    // 	$currency = Currency::where('statut', 'yes')->value('symbole');

    // 	$transactions = Transaction::where('id_user_app',"=", $id)->paginate(10);

    // 	$rides = Requests::
    //     	join('tj_user_app', 'tj_requete.id_user_app', '=', 'tj_user_app.id')
    //     	->join('tj_conducteur', 'tj_requete.id_conducteur', '=', 'tj_conducteur.id')
    //     	->join('tj_payment_method', 'tj_requete.id_payment_method', '=', 'tj_payment_method.id')
    //     	->select('tj_requete.id','tj_requete.statut', 'tj_requete.statut_paiement','tj_requete.depart_name','tj_requete.destination_name','tj_requete.distance','tj_requete.montant','tj_requete.creer','tj_conducteur.id as driver_id','tj_conducteur.prenom as driverPrenom','tj_conducteur.nom as driverNom','tj_user_app.id as user_id','tj_user_app.prenom as userPrenom','tj_user_app.nom as userNom','tj_payment_method.libelle','tj_payment_method.image')
    //     	->where('tj_requete.id_user_app',$id)
    //     	->orderBy('tj_requete.creer', 'DESC')
    //     	->paginate(10);

    //     return view("settings.users.show")->with("user",$user)->with("rides",$rides)->with("transactions",$transactions)->with("currency",$currency);
    // }

    public function userUpdate(Request $request, $id)
    {


        if ($request->id > 0) {
            $image_validation = "mimes:jpeg,jpg,png";
            $doc_validation = "mimes:doc,pdf,docx,zip,txt";

        } else {
            $image_validation = "required|mimes:jpeg,jpg,png";
            $doc_validation = "required|mimes:doc,pdf,docx,zip,txt";

        }
        $validator = Validator::make($request->all(), $rules = [
            'language' => 'required',
            'code' => 'required',
            'flag' => $image_validation,
        ], $messages = [
            'language.required' => 'The language field is required!',
            'code.required' => 'The Code field is required!',
            'flag.required' => 'The flag field is required!',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)->with(['message' => $messages])
                ->withInput();
        }

        $language = $request->input('language');
        $code = $request->input('code');

        if ($request->input('status')) {
            $status = "true";
        } else {
            $status = "false";
        }
        if ($request->input('is_rtl')) {
            $is_rtl = "true";
        } else {
            $is_rtl = "false";
        }


        $user = language::find($id);
        if ($user) {
            $user->language = $language;
            $user->code = $code;
            $user->status = $status;
            $user->is_rtl = $is_rtl;

            if ($request->hasfile('flag')) {
                $destination = 'assets/images/flags/' . $user->flag;
                if (File::exists($destination)) {
                    File::delete($destination);
                }
                $file = $request->file('flag');
                $extenstion = $file->getClientOriginalExtension();
                $time = time() . '.' . $extenstion;
                $filename = $request->input('language') . '.' . $extenstion;
                $file->move('assets/images/flags/', $filename);
                $user->flag = $filename;


            }
            $user->save();
        }

        return redirect('language');
    }

    public function deleteUser($id)
    {

        // $user=UserApp::find($id);
        // $user->delete();

        if ($id != "") {

            $user = language::find($id);
            $user->delete();

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
            $language = language::find($id);

            if($ischeck=="true"){
              $language->status = 'true';
            }else{
              $language->status = 'false';
            }
              $language->save();

    }

}
