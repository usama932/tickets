<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\v1\GcmController;
use App\Models\Requests;
use App\Models\UserApp;
use App\Models\Driver;
use App\Models\Commission;
use App\Models\Tax;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use DB;
class PayRequeteWalletController extends Controller
{

  public function UpdatePayRequeteWallet(Request $request)
  {

    $id_requete = $request->get('id_ride');
    $id_user = $request->get('id_driver');
    $id_user_app = $request->get('id_user_app');
    $amount_new = $request->get('amount');
    $paymethod = $request->get('paymethod');
    $date_heure = date('Y-m-d H:i:s');
    $discount = $request->get('discount');
    $tip = $request->get('tip');
    $transaction_id = $request->get('transaction_id');
    $payment_status=$request->get('payment_status');

    if (!empty($discount)) {

        $totalDriverAmount = $amount_new - $discount;
    }

    $admin_commisions = Commission::where('statut','yes')->first();

    if($admin_commisions->type == 'Percentage')
    {
        $commission_amount = (($admin_commisions->value * $totalDriverAmount) / 100);
    }
    else{
        $commission_amount=$admin_commisions->value;
    }

    $tax=Tax::where('statut','=','yes')->first();
    if($tax->type=='Percentage'){
      $tax_amount=(($totalDriverAmount*$tax->value)/100);
    }else{
      $tax_amount=$tax->value;
    }

$totalUserAmount=$totalDriverAmount+$tip+$tax_amount;
    if (!empty($commission_amount) || !empty($tax_amount)) {
        $totalDriverAmount = $totalDriverAmount+$tip+$tax_amount - $commission_amount;
    }


        $row_amount = DB::table('tj_user_app')->select('amount')->where('id','=',DB::raw($id_user_app))->first();

        $amount = $row_amount->amount - $totalUserAmount;
      

        DB::update('update tj_user_app set amount = ? where id = ?',[$amount,$id_user_app]);

        DB::insert("insert into tj_transaction(amount,deduction_type,ride_id,payment_method, payment_status,id_user_app, creer,modifier)
        values($totalUserAmount,0,'".$id_requete."','".$paymethod."','".$payment_status."','".$id_user_app."','".$date_heure."','".$date_heure."')");


        $row_driver = DB::table('tj_conducteur')->select('amount')->where('id',$id_user)->first();
        $amount = $row_driver->amount;
        $amount_driver = $amount + $totalDriverAmount;
        DB::update('update tj_conducteur set amount = ? where id = ?',[$amount_driver,$id_user]);

    $row_payment_method = DB::table('tj_payment_method')->select('id')->where('libelle',$paymethod)->first();
	if($row_payment_method){
		$id_payment = $row_payment_method->id;
	}else{
		$response['success'] = 'Failed';
        $response['error'] = 'Payment method not found';
	  	return response()->json($response);
	}

	$updatedata = DB::update('update tj_requete set statut_paiement = ?,id_payment_method = ?,tip_amount = ?,tax = ?,discount = ?,transaction_id = ?,admin_commission = ? where id = ?',['yes',$id_payment,$tip,$tax_amount,$discount,$transaction_id,$commission_amount,$id_requete]);

    if($updatedata > 0){

        $sql = Requests::where('id',$id_requete)->first();
        $row = $sql->toarray();

        $sql_user = UserApp::where('id',$id_user_app)->first();
        $row_user = $sql_user->toarray();

        $sql_driver = Driver::where('id',$id_user)->first();
        $row_driver = $sql_driver->toarray();

        $sql_payment = PaymentMethod::where('id',$id_payment)->first();
        $row_payment = $sql_payment->toarray();

        $row['payment_method'] = $row_payment['libelle'];
        $row['amount'] = $row_user['amount'];
        $row['amount_driver'] = $row_driver['amount'];
        $row['tax']= $row['tax'];
        $row['discount'] = $row['discount'];

        $response['success']='Success';
        $response['error']= null;
        $response['data'] = $row;

        $tmsg='';
        $terrormsg='';

        $title=str_replace("'","\'","Payment of the race");
        $msg=str_replace("'","\'","Your customer has just paid for his ride");

        $tab[] = array();
        $tab = explode("\\",$msg);
        $msg_ = "";
        for($i=0; $i<count($tab); $i++){
            $msg_ = $msg_."".$tab[$i];
        }

        $message=array("body"=>$msg_,"title"=>$title,"sound"=>"mySound","tag"=>"ridecompleted");

        $driver_row = DB::table('tj_conducteur')->select('fcm_id')->where('fcm_id','!=','')->where('id','=',DB::raw($id_user))->first();

        $tokens = array();
        if(!empty($driver_row) && $driver_row->fcm_id){
             $tokens[] = $driver_row->fcm_id;
        }

        $temp = array();
        if (count($tokens) > 0) {
            GcmController::send_notification($tokens, $message, $temp);
        }

         // Get user info
        $query = DB::table('tj_requete')
        ->crossJoin('tj_user_app')
        ->select('tj_user_app.fcm_id', 'tj_user_app.id', 'tj_user_app.nom', 'tj_user_app.prenom', 'tj_user_app.email')
        ->where('tj_requete.id_user_app','=',DB::raw('tj_user_app.id'))
        ->where('tj_requete.id','=',DB::raw($id_requete))
        ->get();

        // Get Ride Info
        $ride = DB::table('tj_requete')->select('distance', 'distance_unit','duree', 'montant', 'creer', 'trajet','discount','tax','tip_amount')->where('id','=',DB::raw($id_requete))->first();

        $distance = $ride->distance;
		$distance_unit = $ride->distance_unit;
        $duree = $ride->duree;
		$subtotal = $ride->montant;
        $date_heure = $ride->creer;
        $img_name = $ride->trajet;
		$discount = $ride->discount?$ride->discount:0;
		$tax = $ride->tax?$ride->tax:0;
		$tip_amount = $ride->tip_amount?$ride->tip_amount:0;

		$total = ($subtotal - $discount) + $tax + $tip_amount;
		$subtotal = number_format($subtotal,2);
		$discount = number_format($discount,2);
		$tax = number_format($tax,2);
		$tip_amount = number_format($tip_amount,2);
		$total = number_format($total,2);

        $tokens = array();
        $nom = "";
        $prenom = "";
        $email = "";

        if(!empty($query)){
            foreach($query as $user){
                if (!empty($user->fcm_id)) {
                    $tokens[] = $user->fcm_id;
                    $nom = $user->nom;
                    $prenom = $user->prenom;
                    $email = $user->email;
                }
            }
        }

        if($email != ""){

        	$contact_us_email = DB::table('tj_settings')->select('contact_us_email')->value('contact_us_email');
			$contact_us_email = $contact_us_email?$contact_us_email:'none@none.com';

        	$currency = DB::table('tj_currency')->select('symbole')->where('statut','yes')->value('symbole');
			$currency = $currency?$currency:'$';

            $app_name = env('APP_NAME','Cabme');

			$to = $email;
            $subject = "Payment Receipt - ".$app_name;
            $message = '
            	<body>
                   <div width="100%" style="padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
                      <div style="max-width:700px;margin: 30px 30px; font-size: 14px; background: #fff;">
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
                   	         	<tbody>
                    	            <tr>
                        	            <td>
                            	            <img src="'.url('images/logo2.png').'" alt="'.$app_name.'" style="border:none" width="15%">
                                	    </td>
                                	</tr>
                            	</tbody>
                        	</table>
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <h3>Payment Receipt </h3>
                                        <p>Hello Mr./Mrs '.$prenom.' '.$nom.'</p>
                                        <b><u>Details of your payment receipt:</u></b><br>
                                        <p><b>Distance:</b> '.$distance.' '.$distance_unit.' </p>
                                        <p><b>Duration:</b> '.$duree.'</p>
                                        <p><b>Sub Total:</b>  '.$currency.$subtotal. '</p>
                                        <p><b>Discount:</b>  '.$currency.$discount . '</p>
                                        <p><b>Tax:</b>  '.$currency.$tax . '</p>
                                        <p><b>Driver Tip:</b>  '.$currency.$tip_amount . '</p>
                                        <p><b>Total:</b>  '.$currency.$total . '</p>
                                        <p><b>Date:</b> '.date('d F Y',strtotime($date_heure)).'</p>
                                        <br/>
                                        <p><b>Regards '.$app_name.'</b></p>
                                    </tr>
                                </tbody>
                            </table>
                    	</div>
                	</div>
            </body>';

            // Always set content-type when sending HTML email
           	$headers = "MIME-Version: 1.0" . "\r\n";
		   	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
			$headers .= 'From: '.$app_name.'<'.$contact_us_email.'>' . "\r\n";
            mail($to,$subject,$message,$headers);
        }

    }else{
        $response['success'] = 'Failed';
        $response['error'] = 'Failed';
    }

  	 return response()->json($response);
  }

}
