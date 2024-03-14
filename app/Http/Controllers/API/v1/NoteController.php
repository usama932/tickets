<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;
use DB;
class NoteController extends Controller
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
//   public function index()
//   {

//     $driver = Vehicle::all();
//     $driver = Vehicle::paginate($this->limit);
//     return response()->json($driver);
//   }

  public function register(Request $request)
  {

        $id_user_app = $request->get('id_user_app');
        $id_conducteur = $request->get('id_conducteur');
        $note_value = $request->get('note_value');
        $car_condition = $request->get('car_condition');
        $driver_comfort = $request->get('driver_comfort');
        $no_jugment = $request->get('no_jugment');
        $comment = $request->get('comment') ?? '';
        $ride_id = $request->get('ride_id');
        $date_heure = date('Y-m-d H:i:s');

        if($id_user_app && $id_conducteur && $note_value && $comment ){
        //$chknote = Note::where('id_user_app',$id_user_app AND 'id_conducteur',$id_conducteur)->first();
        $chknote = DB::table('tj_note')
        ->select('id')
        ->where('id_user_app','=',DB::raw($id_user_app))
        ->where('id_conducteur','=',DB::raw($id_conducteur))
        ->where('ride_id','=',DB::raw($ride_id))
        ->get();
      if ($chknote->count() > 0)  {

                $updatedata = DB::update('update tj_note set niveau = ?,car_condition = ?,driver_comfort = ?,no_jugment = ?,ride_id = ?,modifier = ?,comment = ? where id_conducteur = ? AND id_user_app = ?',[$note_value,$car_condition,$driver_comfort,$no_jugment,$ride_id,$date_heure,$comment,$id_conducteur,$id_user_app]);

                  // Nb avis conducteur
                $sql_nb_avis = DB::table('tj_note')
                ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau) as somme"))
                ->where('id_user_app','=',DB::raw($id_user_app))
                ->get();

               foreach($sql_nb_avis as $row_nb_avis)
                {
                    $somme = $row_nb_avis->somme;
                    $nb_avis = $row_nb_avis->nb_avis;
                }
                $moyenne = $somme/$nb_avis;

            // Note conducteur
            $sql_note = DB::table('tj_note')
            ->select('niveau', 'comment')
            ->where('id_conducteur','=',DB::raw($id_conducteur))
            ->where('id_user_app','=',DB::raw($id_user_app))
            ->get();
            foreach($sql_note as $row_note)

            $row['nb_avis'] = $row_nb_avis->nb_avis;
            if(!empty($sql_note)){
                $row['niveau'] = $row_note->niveau;
                $row['car_condition'] = $row_note->car_condition ?? '';
                $row['driver_comfort'] = $row_note->driver_comfort  ?? '';
                $row['no_jugment'] = $row_note->no_jugment  ?? '';
                $row['comment'] = $row_note->comment;
            }else{
                $row['niveau'] = "";
                $row['car_condition'] = '';
                $row['driver_comfort'] = '';
                $row['no_jugment'] = '';
                $row['comment'] = "";
            }
            $row['moyenne'] = $moyenne;
              $response['success']= 'Success';
                $response['error']= null;
                $response['message']='Note Added Successfully';
                $response['data'] = $row;

        }

        else {
            $insertdata = DB::insert("insert into tj_note(niveau,car_condition,driver_comfort,no_jugment,ride_id,id_conducteur,id_user_app,statut,creer,modifier,comment)
            values('".$note_value."','".$car_condition."','".$driver_comfort."','".$no_jugment."','".$ride_id."','".$id_conducteur."','".$id_user_app."','yes','".$date_heure."','".$date_heure."','".$comment."')");
            $id=DB::getPdo()->lastInsertId();
            if ($insertdata > 0) {
                $row = [];

                // Nb avis conducteur
                $sql_nb_avis = DB::table('tj_note')
                ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau) as somme"))
                ->where('id_user_app','=',DB::raw($id_user_app))
                ->get();
                foreach($sql_nb_avis as $row_nb_avis)
                 {
                $somme = $row_nb_avis->somme;
                $nb_avis = $row_nb_avis->nb_avis;
                 }
                $moyenne = $somme/$nb_avis;
                // Note conducteur
                $sql_note = DB::table('tj_note')
                ->select('niveau', 'comment')
                ->where('id_conducteur','=',DB::raw($id_conducteur))
                ->where('id_user_app','=',DB::raw($id_user_app))
                ->get();
                foreach($sql_note as $row_note)

                $row['nb_avis'] = $row_nb_avis->nb_avis;

                if(!empty($sql_note)){
                    $row['niveau'] = $row_note->niveau;
                    $row['car_condition'] = $row_note->car_condition ?? '';
                    $row['driver_comfort'] = $row_note->driver_comfort  ?? '';
                    $row['no_jugment'] = $row_note->no_jugment  ?? '';
                    $row['comment'] = $row_note->comment;
                }else{
                    $row['niveau'] = "";
                    $row['car_condition'] = '';
                    $row['driver_comfort'] = '';
                    $row['no_jugment'] = '';
                    $row['comment'] = "";
                }
                $row['moyenne'] = $moyenne;

                $response['success']= 'Success';
                $response['error']= null;
                $response['message']='Note Added Successfully';
                $response['data'] = $row;

            } else {
              $response['success']= 'Failed';
              $response['error']= 'Failed to add note';
            }
    }
  }else
  {
    $response['success']= 'Failed';
    $response['error']= 'some field is missing';
  }

    return response()->json($response);
  }

}
