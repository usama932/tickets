<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends Authenticatable
{
    protected $table = 'car_model';
    protected $fillable = [
        'name',
        'brand_id',
        'status',
        'modifier',
        'created_at',
        'updated_at'
    ];

 
}
