<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $guarded = [];
    
    use HasFactory;

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
