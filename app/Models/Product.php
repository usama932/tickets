<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps = false;
protected $table ='products';
    protected $fillable = [
        'user_id',
        'product_name',
        'product_price',
        'product_image',
        'product_description',
        'delivery_charges',
        
        
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
