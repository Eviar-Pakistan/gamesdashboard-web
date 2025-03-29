<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bids extends Model
{
    use HasFactory;
    protected $fillable = ['horse_no', 'user_id', 'amount','race_id'];

}