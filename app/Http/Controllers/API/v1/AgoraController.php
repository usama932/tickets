<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Willywes\AgoraSDK\RtcTokenBuilder;

class AgoraController extends Controller
{
    public static function rtc_token(Request $request){
    
        $appID = "03db78a190bc4764b5a4ea2f0c119294";
        $appCertificate = "7bb4f4c5eb1246cdb0557858fa751500";
        $channelName = $request->channelName;
        $uid = $request->uid;
        $uidStr = ($request->uid) . '';
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new \DateTime("now", new \DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token =  RtcTokenBuilder::buildTokenWithUid($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpiredTs);
        return response()->json($token);
       
    
    }
}
