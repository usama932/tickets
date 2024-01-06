<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ChatMessage extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'tj_chat_message';
    public $timestamps = false;
    protected $fillable = [
        'message',
        'chat_id',
        'creer',
        'modifier',

    ];
}
