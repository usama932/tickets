<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RideFareRangeTokens extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_range','to_range','token','ride_setting_id'];
    protected $table = 'ride_fare_range_tokens';
}
