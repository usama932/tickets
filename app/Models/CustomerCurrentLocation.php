<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCurrentLocation extends Model
{
    use HasFactory;

    protected $table = 'live_customer_location';
    protected $fillable = ['id', 'customer_id', 'location','destination'];
}
