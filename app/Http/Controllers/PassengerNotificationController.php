<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserApp;

class PassengerNotificationController extends Controller
{

    public function index()
    {
        return view('notification.passenger');
    }
    public function send_notify(Request $request){
      //  dd($request->all());
        $firebaseToken = UserApp::whereNotNull('fcm_id')->pluck('fcm_id')->all();

        $SERVER_API_KEY = "AAAA0u9BeJI:APA91bHFNEgnMMAWSJr5lfxj1S5JF1NOcPvyJzxMIIrnmTJEfoVRBdm8v3QKXTpKBGFKL6ACdU4R88eYmUi0QaSno_QJxa8WiE2Ci5wgMCGy9R5MtqNPblaGmOA9eeX7y56042X2tTBV";

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        return back()->with('message', 'Notification send successfully.');
    }
}
