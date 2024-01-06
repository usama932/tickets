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
            'Authorization:key=AAAAOERbWiY:APA91bF1xO1XzAzZRt3-0S_3WTiAVuTdyKr9lDqidZ5ojSMh1-9DRJZl4JJ0C1zQmVIxtAbFCyG5D_D3rQfsn3oT_wvl6WYSQJZ-eehGhL1RX3hvKR_Dk8Ve449Amlg6gT9kIqghOHrB',
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
