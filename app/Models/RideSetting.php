<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideSetting extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function fareRange(){
        return $this->hasMany(RideFareRangeTokens::class,'ride_setting_id','id');
    }
}
