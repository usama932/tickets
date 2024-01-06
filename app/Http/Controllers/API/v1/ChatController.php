<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Calculation\Database\DVar;

class ChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $message = $request->get('message');
        $chatId = $request->get('chat_id');
        $chatMessage = ChatMessage::create([
            'message' => $message,
            'chat_id' => $chatId,
            'creer' => Carbon::now(),
            'modifier' => Carbon::now()
        ]);
        return response()->json(['status' => 'created', 'data' => $chatMessage], 201);
    }

    public function createChat(Request $request)
    {
        $userId = $request->get('user_id');
        $driverId = $request->get('driver_id');
        if (!empty(Chat::where('id_user_app', $userId)->where('id_conducteur', $driverId)->first())) {
            $chat = Chat::where('id_user_app', $userId)->where('id_conducteur', $driverId)->first();
        } else {
            DB::insert("insert into tj_chat(id_user_app,id_conducteur,creer,modifier)
                    values('" . $userId . "','" . $driverId . "','" . Carbon::now() . "','" . Carbon::now() . "')");
        }
        $chat = Chat::where('id_user_app', $userId)->where('id_conducteur', $driverId)->first();
        return response()->json(['status' => 'success', 'data' => $chat]);
    }

    public function allChats(Request $request)
    {
        $userId = $request->get('user_id');
        $driverId = $request->get('driver_id');
        $cat = $request->get('cat');
        if ($cat == 'driver') {
            $user = DB::table('tj_conducteur')
                ->select('id', 'nom', 'prenom', 'photo_path', 'statut')
                ->where('id', '=', DB::raw($driverId))
                ->first();
            if ($user->photo_path != '') {
                if (file_exists('assets/images/driver' . '/' . $user->photo_path)) {
                    $image_user = asset('my-assets/images/driver') . '/' . $user->photo_path;
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $user->photo_path = $image_user;
            }
            $chats = DB::table('tj_chat')
                ->crossJoin('tj_user_app')
                ->select('tj_chat.id as chat_id','tj_chat.id_conducteur', 'tj_chat.id_user_app', 'tj_chat.creer',
                    'tj_user_app.id', 'tj_user_app.nom', 'tj_user_app.prenom')
                ->where('tj_chat.id_user_app', '=',DB::raw('tj_user_app.id'))
                ->where('tj_chat.id_user_app', '=', DB::raw($userId))
                ->where('tj_chat.id_conducteur','=',DB::raw($driverId))
                ->get();
            foreach ($chats as $chat) {
                $chat->message = ChatMessage::where('id', $chat->chat_id)->orderByDesc('id')->first();
            }
            $user->chats = $chats;
            return response()->json($user);
        }
        if ($cat == 'user') {
            $user = DB::table('tj_user_app')
                ->select('id', 'nom', 'prenom', 'photo_path', 'statut')
                ->where('id', '=', DB::raw($userId))
                ->first();
            if ($user->photo_path != '') {
                if (file_exists('assets/images/users' . '/' . $user->photo_path)) {
                    $image_user = asset('my-assets/images/users') . '/' . $user->photo_path;
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $user->photo_path = $image_user;
            }
            $chats = DB::table('tj_chat')
                ->crossJoin('tj_conducteur')
                ->select('tj_chat.id as chat_id','tj_chat.id_conducteur', 'tj_chat.id_user_app', 'tj_chat.creer',
                    'tj_conducteur.id', 'tj_conducteur.nom', 'tj_conducteur.prenom')
                ->where('tj_chat.id_conducteur', '=', DB::raw('tj_conducteur.id'))
                ->where('tj_chat.id_user_app', '=', DB::raw($userId))
                ->where('tj_chat.id_conducteur','=',DB::raw($driverId))
                ->get();
            foreach ($chats as $chat) {
                $chat->message = ChatMessage::where('id', $chat->chat_id)->orderByDesc('id')->first();
            }
            $user->chats = $chats;
            return response()->json($user);
        }
    }
    public function getChatMessage(Request $request)
    {
        $chatId = $request->get('chat_id');
        $cat = $request->get('cat');
        $driver_id = Chat::where('id',$chatId)->first()->id_conducteur;
        $user_id = Chat::where('id',$chatId)->first()->id_user_app;
        if($cat == 'driver')
        {
            $user = DB::table('tj_user_app')
                ->select('id', 'nom', 'prenom', 'photo_path', 'statut')
                ->where('id', '=', DB::raw($user_id))
                ->first();
            if ($user->photo_path != '') {
                if (file_exists('assets/images/users' . '/' . $user->photo_path)) {
                    $image_user = asset('my-assets/images/users') . '/' . $user->photo_path;
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $user->photo_path = $image_user;
                $messages = ChatMessage::where('chat_id',$chatId)->get();
                foreach ($messages as $message)
                {
                    $message->id_user_app = $user_id;
                    $message->id_conducteur = $driver_id;
                }
                $user->messages = $messages;
            }
        }
        if($cat == 'user')
        {
            $user = DB::table('tj_conducteur')
                ->select('id', 'nom', 'prenom', 'photo_path', 'statut')
                ->where('id', '=', DB::raw($driver_id))
                ->first();
            if ($user->photo_path != '') {
                if (file_exists('assets/images/driver' . '/' . $user->photo_path)) {
                    $image_user = asset('my-assets/images/driver') . '/' . $user->photo_path;
                } else {
                    $image_user = asset('assets/images/placeholder_image.jpg');

                }
                $user->photo_path = $image_user;

                $messages = ChatMessage::where('chat_id',$chatId)->get();
                foreach ($messages as $message)
                {
                    $message->id_user_app = $user_id;
                    $message->id_conducteur = $driver_id;
                }
                $user->messages = $messages;
            }
        }
        return response()->json($user);
    }
}
