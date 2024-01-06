<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Models\UserApp;
use App\Models\Driver;
use App\Models\Currency;
use App\Models\Country;
use Illuminate\Http\Request;
use DB;
class RideDetailsController extends Controller
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
    
    $users = UserApp::all();
    $users = UserApp::paginate($this->limit);
    return response()->json($users);
  }

  public function ridedetails(Request $request)
  {
         
        $ride_id = $request->get('ride_id');
        //$amount = $request->get('amount');
        $date_heure = date('Y-m-d H:i:s');
        
        if(!empty($ride_id)){
            
            $sql = DB::table('tj_requete')
            ->where('id', $ride_id)
            ->get();
                if($sql){
                    foreach($sql as $row){
                       
                        //$output[] = $row;
                        $row->tax=number_format((float)$row->tax, 2, '.', '');
                        $row->discount = number_format((float)$row->discount, 2, '.', '');
                    }

                  
                        $response['success']= 'success';
                        $response['error']= null;
                        $response['message']= 'successfully';
                        $response['data'] = $row;
              
                    
                }
        
                else{
                    $response['success']= 'Failed';
                    $response['error']= 'Ride Not Found';
                }
                    
            }
        
        else{
            $response['success']= 'Failed';
            $response['error']= 'Some fields not found';
        }
        
    
    return response()->json($response);
  }

	public function getRideReview(Request $request){
		
		$ride_id = $request->get('ride_id');
		$review_of = $request->get('review_of');
		$user_id = $request->get('user_id');
		
		if(empty($ride_id)){
            $response['success'] = 'Failed';
            $response['error'] = 'Ride Id Missing';
        }else if(empty($review_of)){
            $response['success'] = 'Failed';
            $response['error'] = 'Review of Missing';
        }else if($review_of == "customer" && empty($user_id)){
            $response['success'] = 'Failed';
            $response['error'] = 'Driver Id missing';
        }else if($review_of == "driver" && empty($user_id)){
            $response['success'] = 'Failed';
            $response['error'] = 'User Id missing';
        } else {
        		
        	if($review_of == "customer"){
				$review = DB::table('tj_user_note')->where('ride_id',$ride_id)->where('id_conducteur',$user_id)->first();	
			}else if($review_of == "driver"){
				$review = DB::table('tj_note')->where('ride_id',$ride_id)->where('id_user_app',$user_id)->first();					
			}
			
			if($review){
				$response['success'] = 'Success';
	            $response['error'] = null;
	            $response['data'] = $review;
			}else{
				$response['success'] = 'Failed';
            	$response['error'] = 'No review found';
			}
		}
		
		return response()->json($response);
	}

}