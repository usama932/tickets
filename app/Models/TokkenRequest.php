<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokkenRequest extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'number_of_tokens',
        'total_price',
        'payment_method',
        'status',
        'transaction_number',
        'created_at',
        'update_at',
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
