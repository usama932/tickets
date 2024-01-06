<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class GcmController extends Controller
{
    /**
     * Sending Push Notification
     */
    public static function send_notification($tokens, $message, $data,$type=null)
    {
        // Set POST variables
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array(
            'registration_ids' => $tokens,
            'notification' => $message,
            'data' => [
                'notification_type' => $type,
                'data' => $data
            ],
            'content_available' => true,
            'priority' => 'high',
//            'body'=>$data
        );
        //$API_KEY= Config::get('constants.apikey');

        $headers = array(
//            'Authorization:key='.Config::get('constant.apikey.GOOGLE_API_KEY'),
            'Authorization:key=AAAA0u9BeJI:APA91bHFNEgnMMAWSJr5lfxj1S5JF1NOcPvyJzxMIIrnmTJEfoVRBdm8v3QKXTpKBGFKL6ACdU4R88eYmUi0QaSno_QJxa8WiE2Ci5wgMCGy9R5MtqNPblaGmOA9eeX7y56042X2tTBV',
            'Content-Type:application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        $result = curl_exec($ch);
        Log::info($result);
        if ($result === FALSE) {
            Log::info('failed');
            die('Curl Failed:' . curl_error($ch));
        }
        curl_close($ch);

        return $result;
        Log::info('success');
    }
}
