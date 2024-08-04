<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'role',
        'status',
        'referral_code',
        'referrer_id',
        'number_of_tokens',
        'subscription_status',
        'current_balance',
        'total_balance',
        'withdrawal_balance',
        'package_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function loanRequests()
    {
        return $this->hasMany(LoanRequest::class);
    }
   // User.php

public function cart()
{
    return $this->hasMany(Cart::class);
}
public function products()
{
    return $this->hasMany(Product::class);
}
public function cartItems()
{
    return $this->hasMany(CartItem::class);
}

}
