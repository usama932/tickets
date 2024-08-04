<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanRequest extends Model
{
    use HasFactory;
    protected $table = 'loanrequests';
    protected $fillable = [
        'user_id',
        'loan_amount',
        'easypaisa_account_number',
        'loan_in_earnings',
        'status'

        
        
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
