<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Chat extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tj_chat';
    protected $fillable = [
        'message_id',
        'id_user_app',
        'id_conducteur',
        'creer',
        'modifier',

    ];
}
