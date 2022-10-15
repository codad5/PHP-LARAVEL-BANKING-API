<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        "account_id",
        "transaction_type",
        "transaction_reference",
        "account_number",
        "amount",
        "narration",
        "old_balance",
        "new_balance",
        "status"
    ];
}
