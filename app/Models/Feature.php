<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['title', 'package_id', 'status'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
    public function features()
{
    return $this->hasMany(Feature::class);
}
}
