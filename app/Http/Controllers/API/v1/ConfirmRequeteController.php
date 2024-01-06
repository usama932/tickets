<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use App\Models\Requests;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\API\v1\GcmController;
use Illuminate\Support\Facades\Log;
use App\Models\RemainingToken;
use App\Models\RideSetting;
use DB;


class ConfirmRequeteController extends Controller
{

   public function __construct()
   {
      $this->limit=20;
   }
  /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
  public function confirmRequest(Request $request)
  {

    $id_requete = $request->get('id_ride');
    $id_user = $request->get('id_user');
    $driver_name = $request->get('driver_name');
    $from_id=$request->get('from_id');

    $lat_conducteur = $request->get('lat_conducteur');
    $lng_conducteur = $request->get('lng_conducteur');
    $lat_client = $request->get('lat_client');
    $lng_client = $request->get('lng_client');

    $lat_conducteur=str_replace("."," ",$lat_conducteur);
    $lng_conducteur=str_replace("."," ",$lng_conducteur);
    $lat_client=str_replace("."," ",$lat_client);
    $lng_client=str_replace("."," ",$lng_client);
    if(!empty($id_requete) && !empty($id_user) && !empty($driver_name) && !empty($from_id)){
    $updatedata =  DB::update('update tj_requete set statut = ? where id = ? AND statut = ?',['confirmed',$id_requete,'new']);

    if (!empty($updatedata)) {
        $otp = random_int(100000, 999999);


        $user =  Requests::where('id',$id_requete)->first();
        if($user){
            $user->otp = $otp;
            $user->otp_created = now();
        }
        $user->save();
        $sql = Requests::where('id',$id_requete)->first();
        $row = $sql->toArray();
        if($row['trajet'] != ''){
            if(file_exists('images/recu_trajet_course'.'/'.$row['trajet'] ))
            {
                $image_user = asset('images/recu_trajet_course').'/'. $row['trajet'];
            }
            else
            {
                $image_user =asset('assets/images/placeholder_image.jpg');

            }
            $row['trajet'] = $image_user;
        }
        $tmsg='';
        $terrormsg='';

        $title=str_replace("'","\'","Confirmation of your ride");
        $msg=str_replace("'","\'",$driver_name." is Confirmed your ride.");
        $type = 'confirm';

        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }
        $sound = $lat_conducteur."_".$lng_conducteur."_".$lat_client."_".$lng_client;
        $message=array("body"=>$msg_,"title"=>$title,"sound"=>$sound,"tag"=>"rideconfirmed");

        $query = DB::table('tj_user_app')
        ->select('fcm_id')
        ->where('fcm_id','<>','')
        ->where('id','=',DB::raw($id_user))
        ->get();

        $tokens = array();
        if ($query->count() > 0) {
            foreach ($query as $user) {
                if (!empty($user->fcm_id)) {
                    $tokens[] = $user->fcm_id;
                }
            }
        }
        $temp = array();
        if (count($tokens) > 0) {
            Log::info('inside');
            GcmController::send_notification($tokens, $message, $temp);
        }
        $gift_token =  RideSetting::latest()->first();
        if($gift_token){
           $rem =  RemainingToken::where('user_id', $from_id)->first();
           if(!empty($rem) && $rem->tokens > 0 && $rem->tokens >=  $gift_token->ride_token){
            $rem->tokens = $rem->tokens - $gift_token->ride_token;
            $rem->save();
           }
           else{
            $response['success'] = 'Failed';
            $response['error'] = 'Your token is less then ride token';
           }
        }
        if (count($tokens) > 0) {
            $data = DB::table('tj_requete')
                ->crossjoin('tj_conducteur')
                ->select('tj_requete.distance','tj_requete.destination_name','tj_requete.montant','tj_requete.depart_name',
                    'tj_requete.id_user_app','tj_requete.latitude_depart','tj_requete.duree','tj_requete.id','tj_requete.distance_unit','tj_requete.longitude_depart',
                    'tj_requete.latitude_arrivee','tj_requete.longitude_arrivee','tj_requete.id_conducteur'
                    ,'tj_requete.tip_amount','tj_requete.statut',
                    'tj_conducteur.nom','tj_conducteur.prenom','tj_conducteur.photo_path'
                )
                ->where('tj_conducteur.id','=',DB::raw('tj_requete.id_conducteur'))
                ->where('tj_requete.id','=',DB::raw($id_requete))->first();

           if(!empty($data->photo_path))
           {
               if (file_exists('assets/images/driver' . '/' . $data->photo_path)) {
                   $image_user = asset('my-assets/images/driver') . '/' . $data->photo_path;
               } else {
                   $image_user = asset('assets/images/placeholder_image.jpg');

               }
               $data->photo_path = $image_user;
           }
            GcmController::send_notification($tokens, $message,$data,$type);
            $date_heure = date('Y-m-d H:i:s');
            $to_id=$request->get('id_user');

            $insertdata = DB::insert("insert into tj_notification(titre,message,statut,creer,modifier,to_id,from_id,type)
            values('".$title."','".$msg."','yes','".$date_heure."','".$date_heure."','".$to_id."','".$from_id."','rideconfirmed')");
            $sql_notification = Notification::orderby('id','desc')->first();
            $data = $sql_notification->toArray();
                $row['titre'] = $data['titre'];
                $row['message'] = $data['message'];
                $row['statut_notification'] = $data['statut'];
                $row['to_id'] = $data['to_id'];
                $row['from_id'] = $data['from_id'];
                $row['type'] = $data['type'];

        }
        $response['success'] = 'success';
        $response['error'] = null;
        $response['message'] = 'status successfully updated';
        $response['data'] = $row;

        }
    else {
        $response['success'] = 'Failed';
        $response['error'] = 'Failed to update data';

    }
}
else {
    $response['success'] = 'Failed';
    $response['error'] = 'some field are missing';

}
    return response()->json($response);
  }

}
