<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgoraController extends Controller
{
    public function rtc_token(Request $request){
        $appID = '03db78a190bc4764b5a4ea2f0c119294';
        $appCertificate = '7bb4f4c5eb1246cdb0557858fa751500';

        $channelName = $request->channelName;
        $user = $request->uid;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 36000;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $rtcToken = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);
    }
}
