<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use App\Models\Driver;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\DriverTime;

class ChangeStatusControlller extends Controller
{
   
    public function changeStatus(Request $request)
    {
        $id_conducteur = $request->id_driver;
        $online = $request->online;
        $mytime  = $request->my_time;
       
        if (!empty($id_conducteur) && !empty($online)) {
          
          $admin_documents = DB::table('admin_documents')->where('is_enabled','=','Yes')->get();
        
          if(!empty($admin_documents)){
           
            foreach ($admin_documents as $document) {
             
              $get_driver_document = DB::table('driver_document')->where('document_id', $document->id)
              ->where('driver_id', $id_conducteur)->first();
             
              if(!empty($get_driver_document)){
               
                if($online == 'yes'){
                   
                 
                    $drivertime = DriverTime::where('driver_id', $id_conducteur)->first();

                    if(empty($drivertime)){
                        DriverTime::create([
                            'driver_id' => $id_conducteur,
                            'start_time' =>  $mytime,
                        ]);
                    }else{
                        DriverTime::where('driver_id', $id_conducteur)->update([
                            'driver_id' => $id_conducteur,
                            'start_time' => $mytime,
                            
                        ]);
                    }
                  
                }
                else{
                    
                    
                  
                    $drivertime = DriverTime::where('driver_id', $id_conducteur)->first();
                  
                    if(empty($drivertime)){
                      
                        DriverTime::create([
                            'driver_id' => $id_conducteur,
                            'end_time' =>   $mytime
                        ]);
                    }else{
                        
                       $driver=  DriverTime::where('driver_id', $id_conducteur)->update([
                            'driver_id' => $id_conducteur,
                            'end_time' =>  $mytime
                        ]);
                    }
                    
                    
                    
                }
              
                $driver = Driver::where('id',$id_conducteur)->first();
               
                if (!empty($driver)) {
                    $updatedata =  Driver::where('id',$id_conducteur)->update([
                        'online' => $online
                    ]);
                    $get_user = Driver::where('id', $id_conducteur)->first();
                    $row = $get_user->toArray();

                    $image_user = $row['photo_path'];
                    $photo = '';
                    $row['photo'] = $photo;
                    $row['photo_nic'] = $photo;
                    $row['photo_car_service_book'] = $photo;
                    $row['photo_licence'] = $photo;
                    $row['photo_road_worthy'] = $photo;

                    if ($image_user != '') {
                        if (file_exists('assets/images/driver' . '/' . $image_user)) {
                            $image_user = asset('my-assets/images/driver') . '/' . $image_user;
                        } else {
                            $image_user = asset('assets/images/placeholder_image.jpg');
                        }
                        $row['photo_path'] = $image_user;
                    }

                    $image = $row['photo_nic_path'];

                    if ($image != '') {
                        if (file_exists('assets/images/driver' . '/' . $image)) {
                            $image = asset('my-assets/images/driver') . '/' . $image;
                        } else {
                            $image = asset('assets/images/placeholder_image.jpg');
                        }
                        $row['photo_nic_path'] = $image;
                    }

                    $car = $row['photo_car_service_book_path'];
                    if ($car != '') {
                        if (file_exists('assets/images/driver' . '/' . $car)) {
                            $car = asset('my-assets/images/driver') . '/' . $car;
                        } else {
                            $car = asset('assets/images/placeholder_image.jpg');
                        }
                        $row['photo_car_service_book_path'] = $car;
                    }

                    $licence = $row['photo_licence_path'];
                    if ($licence != '') {
                        if (file_exists('assets/images/driver' . '/' . $licence)) {
                            $licence = asset('my-assets/images/driver') . '/' . $licence;
                        } else {
                            $licence = asset('assets/images/placeholder_image.jpg');
                        }
                        $row['photo_licence_path'] = $licence;
                    }

                    if ($row['photo_road_worthy_path'] != '') {
                        if (file_exists('assets/images/driver' . '/' . $row['photo_road_worthy_path'])) {
                            $road = asset('my-assets/images/driver') . '/' . $row['photo_road_worthy_path'];
                        } else {
                            $road = asset('assets/images/placeholder_image.jpg');
                        }
                        $row['photo_road_worthy_path'] = $road;
                    }

                    $response['success'] = 'success';
                    $response['error'] = null;
                    $response['message'] = 'Status Changed Successfully';
                    $response['data'] = $row;
                } else {
                    $response['success'] = 'Failed';
                    $response['error'] = 'Failed to change status';
                }
              }
             
            }
          }
        } else {
            $response['success'] = 'Failed';
            $response['error'] = 'Some Fields are missing';
        }
        return response()->json($response);
    }
}

