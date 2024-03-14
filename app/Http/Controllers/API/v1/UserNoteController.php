<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserNote;
use Illuminate\Http\Request;
use DB;
class UserNoteController extends Controller
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
  public function index()
  {

    $driver = Vehicle::all();
    $driver = Vehicle::paginate($this->limit);
    return response()->json($driver);
  }

  public function register(Request $request)
  {
      $id_user_app = $request->get('id_user_app');
      $id_conducteur = $request->get('id_conducteur');
      $note_value = $request->get('note_value');
      $passenger_behaviour = $request->get('passenger_behaviour');
      $follow_roads = $request->get('follow_roads');
      $passenger_clean = $request->get('passenger_clean');
      $find_passenger = $request->get('find_passenger');
      $drop_passenger = $request->get('drop_passenger');
      $comment = $request->get('comment') ?? '';
      $ride_id = $request->get('ride_id');
      $date_heure = date('Y-m-d H:i:s');
      $response = [];

      if ($id_user_app && $id_conducteur && $note_value && $comment) {

          $chknote = DB::table('tj_user_note')
              ->select('id')
              ->where('id_user_app', $id_user_app)
              ->where('id_conducteur', $id_conducteur)
              ->where('ride_id', $ride_id)
              ->get();

          if ($chknote->count() > 0) {

              $updatedata = DB::table('tj_user_note')
                  ->where('id_user_app', $id_user_app)
                  ->where('id_conducteur', $id_conducteur)
                  ->where('ride_id', $ride_id)
                  ->update([
                      'niveau_driver' => $note_value,
                      'passenger_behaviour' => $passenger_behaviour,
                      'follow_roads' => $follow_roads,
                      'passenger_clean' => $passenger_clean,
                      'find_passenger' => $find_passenger,
                      'drop_passenger' => $drop_passenger,
                      'ride_id' => $ride_id,
                      'modifier' => $date_heure,
                      'comment' => $comment,
                  ]);

              // Nb avis conducteur
              $sql_nb_avis = DB::table('tj_user_note')
                  ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau_driver) as somme"))
                  ->where('id_user_app', $id_user_app)
                  ->get();

              foreach ($sql_nb_avis as $row_nb_avis) {
                  $somme = $row_nb_avis->somme;
                  $nb_avis = $row_nb_avis->nb_avis;
              }

              $moyenne = $nb_avis > 0 ? number_format(($somme / $nb_avis), 2, '.', '') : 0;

              // Note conducteur
              $sql_note = DB::table('tj_user_note')
                  ->select('niveau_driver', 'passenger_behaviour', 'follow_roads', 'passenger_clean', 'find_passenger', 'drop_passenger', 'comment')
                  ->where('id_conducteur', $id_conducteur)
                  ->where('id_user_app', $id_user_app)
                  ->get();

              $row = [];
              $row['nb_avis'] = $nb_avis;

              if (!$sql_note->isEmpty()) {
                  $row['niveau_driver'] = $sql_note->first()->niveau_driver;
                  $row['follow_roads'] = $sql_note->first()->follow_roads;
                  $row['passenger_clean'] = $sql_note->first()->passenger_clean;
                  $row['find_passenger'] = $sql_note->first()->find_passenger;
                  $row['drop_passenger'] = $sql_note->first()->drop_passenger;
                  $row['passenger_behaviour'] = $sql_note->first()->passenger_behaviour;
                  $row['comment'] = $sql_note->first()->comment;
              } else {
                  $row['niveau_driver'] = "";
                  $row['follow_roads'] = "";
                  $row['passenger_clean'] = "";
                  $row['drop_passenger'] = "";
                  $row['find_passenger'] = "";
                  $row['passenger_behaviour'] = "";
                  $row['comment'] = "";
              }

              $row['moyenne'] = $moyenne;

              $response['success'] = 'Success';
              $response['error'] = null;
              $response['message'] = 'Note updated Successfully';
              $response['data'] = $row;

          } else {
              // Insert new record if not exists
              $insertdata = DB::table('tj_user_note')->insert([
                  'niveau_driver' => $note_value,
                  'passenger_behaviour' => $passenger_behaviour,
                  'follow_roads' => $follow_roads,
                  'passenger_clean' => $passenger_clean,
                  'find_passenger' => $find_passenger,
                  'drop_passenger' => $drop_passenger,
                  'ride_id' => $ride_id,
                  'id_conducteur' => $id_conducteur,
                  'id_user_app' => $id_user_app,
                  'statut' => 'yes',
                  'creer' => $date_heure,
                  'modifier' => $date_heure,
                  'comment' => $comment,
              ]);

              if ($insertdata) {
                  // Nb avis conducteur
                  $sql_nb_avis = DB::table('tj_user_note')
                      ->select(DB::raw("COUNT(id) as nb_avis"), DB::raw("SUM(niveau_driver) as somme"))
                      ->where('id_user_app', $id_user_app)
                      ->get();

                  foreach ($sql_nb_avis as $row_nb_avis) {
                      $somme = $row_nb_avis->somme;
                      $nb_avis = $row_nb_avis->nb_avis;
                  }

                  $moyenne = $nb_avis > 0 ? number_format(($somme / $nb_avis), 2, '.', '') : 0;

                  // Note conducteur
                  $sql_note = DB::table('tj_user_note')
                      ->select('niveau_driver', 'passenger_behaviour', 'follow_roads', 'passenger_clean', 'find_passenger', 'drop_passenger', 'comment')
                      ->where('id_conducteur', $id_conducteur)
                      ->where('id_user_app', $id_user_app)
                      ->get();

                  $row = [];
                  $row['nb_avis'] = $nb_avis;

                  if (!$sql_note->isEmpty()) {
                      $row['niveau_driver'] = $sql_note->first()->niveau_driver;
                      $row['follow_roads'] = $sql_note->first()->follow_roads;
                      $row['passenger_clean'] = $sql_note->first()->passenger_clean;
                      $row['find_passenger'] = $sql_note->first()->find_passenger;
                      $row['drop_passenger'] = $sql_note->first()->drop_passenger;
                      $row['passenger_behaviour'] = $sql_note->first()->passenger_behaviour;
                      $row['comment'] = $sql_note->first()->comment;
                  } else {
                      $row['niveau_driver'] = "";
                      $row['follow_roads'] = "";
                      $row['passenger_clean'] = "";
                      $row['drop_passenger'] = "";
                      $row['find_passenger'] = "";
                      $row['passenger_behaviour'] = "";
                      $row['comment'] = "";
                  }

                  $row['moyenne'] = $moyenne;

                  $response['success'] = 'Success';
                  $response['error'] = null;
                  $response['message'] = 'Note Added Successfully';
                  $response['data'] = $row;

              } else {
                  $response['success'] = 'Failed';
                  $response['error'] = 'Failed to add note';
              }
          }
      } else {
          $response['success'] = 'Failed';
          $response['error'] = 'some field is missing';
      }

      return response()->json($response);

  }
}
