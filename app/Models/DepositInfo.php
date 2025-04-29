<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DepositInfo extends Model
{
    use HasFactory;
    protected $table = 'deposit_info'; // Laravel would guess `deposit_infos` otherwise

    protected $fillable = [
        'account_type',
        'account_title',
        'account_no',
    ];
}
