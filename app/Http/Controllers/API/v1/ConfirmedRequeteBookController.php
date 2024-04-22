<?php

namespace App\Http\Controllers\api\v1;
use App\Http\Controllers\Controller;
use App\Models\VehicleLocation;
use Illuminate\Http\Request;
use App\Models\DriverTime;
use App\Http\Controllers\API\v1\GcmController;
use DB;
use Carbon\Carbon;

class ConfirmedRequeteBookController extends Controller
{



    public function confirmRequest(Request $request)
    {
        
        $id_requete = $request->get('id_ride');
        $id_user = $request->get('id_user');
        $driver_name = $request->get('driver_name');

        $updatedata =  DB::update('update tj_requete_book set statut = ? where id = ? AND statut = ?',['confirmed',$id_requete,'new']);

        if (!empty($updatedata)) {
            $response['msg']['etat'] = 1;
                
            $tmsg='';
            $terrormsg='';
            
            $title=str_replace("'","\'","Confirmation of your ride");
            $msg=str_replace("'","\'",$driver_name." is Confirmed your ride.");
            
            $tab[] = array();
            $tab = explode("\\",$msg);
            $msg_ = "";
            for($i=0; $i<count($tab); $i++){
                $msg_ = $msg_."".$tab[$i];
            }
            $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"rideconfirmed");

            $query = DB::table('tj_conducteur')
            ->select('fcm_id')
            ->where('fcm_id','!=','')
            ->where('id','=',DB::raw($id_user))
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
                GcmController::send_notification($tokens, $message, $temp);

            }
        
            }
        else {
            $response['msg']['etat'] = 2;
        }
        return response()->json($response);
    }
       
    
    public function active_hour(Request $request, $driver_id)
    {
        $driver = DriverTime::where('driver_id',$driver_id)->first();
        if(!empty($driver)){
            $start_time = Carbon::parse($driver->start_time);
            $end_time = Carbon::parse($driver->end_time);
            $time_difference_in_hours = $end_time->diffInHours($start_time);
            $currentDateTime = Carbon::now();
            $update_time =  Carbon::parse($driver->updated_at);
            $hoursDifference = $update_time->diffInHours($currentDateTime);
            
            // if ($hoursDifference <= 14) {
            //     if($time_difference_in_hours < 10){
            //         $response['success']= 'success';
            //         $response['error']= false;
            //         $response['message']= 'Active  Successfully';       
            //     }
            //     elseif($time_difference_in_hours >= 10 && $time_difference_in_hours + 14 >=  24)
            //     {
                
            //         $updated = DriverTime::where('driver_id',$driver_id)->update([
            //             'driver_id' => $driver_id,
            //             'start_time' => Carbon::parse($request->start_time),
            //         ]);
                    
            //         $response['success']= 'success';
            //         $response['error']= false;
            //         $response['message']= 'Active  Successfully and start time create';       
            //     }
            //     else{
            //         $response['success']= 'success';
            //         $response['error']= true;
            //         $response['message']= 'Active  Unsuccessfully';    
            //     }
            // }
            // else{
            //     $updated = DriverTime::where('driver_id',$driver_id)->update([
            //         'driver_id' => $driver_id,
            //         'start_time' => Carbon::parse($request->start_time),
            //     ]);
                
            //     $response['success']= 'success';
            //     $response['error']= false;
            //     $response['message']= 'Active  Successfully and start time udpated';       
            // }
            $updated = DriverTime::where('driver_id',$driver_id)->update([
                'driver_id' => $driver_id,
                'start_time' => Carbon::parse($request->start_time),
            ]);
        }
        else{
            DriverTime::create([
                'driver_id' => $driver_id,
                'start_time' => $request->start_time,
            ]);
            $response['success']= 'success';
            $response['error']= false;
            $response['message']= 'Active  Successfully and start time create';       
        }
        return response()->json($response);
    }

    public function inactive_hour(Request $request, $driver_id)
    {
        $driver = DriverTime::where('driver_id',$driver_id)->first();
        if(!empty($driver)){
            $start_time = Carbon::parse($driver->start_time);
            $end_time = Carbon::parse($request->end_time);
           
            $time_difference_in_hours = $end_time->diffInHours($start_time);
            // dd($time_difference_in_hours);
            DriverTime::where('driver_id',$driver_id)->update([
                'driver_id' => $driver_id,
                'end_time' => Carbon::parse($request->end_time),
                'hours' => $driver + $time_difference_in_hours
            ]);
            $response['success']= 'success';
            $response['error']= false;
            $response['message']= 'Active  Successfully and End time create';    
        }else{
            $response['success']= 'success';
            $response['error']= true;
            $response['message']= 'driver not found';    
        }
        return response()->json($response);

    }  

}