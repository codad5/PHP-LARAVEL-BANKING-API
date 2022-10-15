<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory; 
    protected $fillable = [
        "user_id",
        "name",
        "password",
        "account_number",
        "account_type",
        "account_balance",
        "account_status"
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
