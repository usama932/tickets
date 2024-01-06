<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverModel extends Model
{
    use HasFactory;
    protected $table = 'tj_model';
    protected $fillable = ['id','model','id_conducteur'];
    public $timestamps = false;
}
