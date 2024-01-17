<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverTime extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'driver_times';
}
