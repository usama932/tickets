<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use App\Models\UserApp;
use App\Models\Requests;
use App\Models\Notification;
use Illuminate\Http\Request;
use DB;
class SendResetPasswordOtpController extends Controller
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
  

  public function resetPasswordOtp(Request $request)
  {
    $email = $request->get('email');
    $user_cat = $request->get('user_cat');
    $otp = mt_rand(1000,9999);
    $date_heure = date('Y-m-d H:i:s');


    if(!empty($email)){
        if($user_cat == 'user_app'){
            $sql = DB::table('tj_user_app')
            ->select('id','nom','prenom')
            ->where('email','=',DB::raw("'$email'"))
            ->get();
            if($sql->count()>0){
            foreach($sql as $row)
            {
                
            }
                if($row->id >0)
                {
                $user_id = $row->id;
                $user_name = $row->nom." ".$row->prenom;
    
                $updatedata = DB::update('update tj_user_app set reset_password_otp = ? , reset_password_otp_modifier = ? where email = ?',[$otp,$date_heure,$email]);
             }
        
    }else{
        $response['success'] = 'Failed';
        $response['error'] = 'Email is not Exist';
    }
}
        elseif($user_cat == 'driver'){

            $sql = DB::table('tj_conducteur')
            ->select('id','nom','prenom')
            ->where('email','=',DB::raw("'$email'"))
            ->get();
            if($sql->count()>0){
            foreach($sql as $row){
            }
            if($row->id >0)
            {
                $user_id = $row->id;
                $user_name = $row->nom." ".$row->prenom;
    
                $updatedata = DB::update('update tj_conducteur set reset_password_otp = ? , reset_password_otp_modifier = ? where email = ?',[$otp,$date_heure,$email]);

                      
            }  else{
                $response['success'] = 'Failed';
                $response['error'] = 'Email is not Exist';
            }
      
   
        }  else{
            $response['success'] = 'Failed';
            $response['error'] = 'Email is not Exist';

        }
    }else{
        $response['success'] = 'Failed';
        $response['error'] = 'Not Found';

    }
        if(!empty($user_id)){

            $to = $email;
            $subject = "Reset your Password ";
            $message = '
                <body style="margin:100px; background: #ffc600; ">
                    <div width="100%" style="background: #ffc600; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                        <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px; background: #fff;">
                         
                            <div style="padding: 40px; background: #fff;">
                                <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <h2>Hello '.$user_name.',</h2><br>
                                           <p>We are sending this email because you requested a password reset.Please use <b>'.$otp.'</b> code to reset your Password.</p>
                                            Thank You                                              
                                            
                                            <br/>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </body>
            ';
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\b";
            //$headers .= 'From: Reyi'"\r\n";
            mail($to,$subject,$message,$headers);

        $response['success'] = 'success';
        $response['error']= null;
        $response['message']='successfully';
        $response['data']=$row;
    }   
}else{
    $response['success'] = 'Failed';
    $response['error'] = 'Email required';

}
   return response()->json($response);
  }
}