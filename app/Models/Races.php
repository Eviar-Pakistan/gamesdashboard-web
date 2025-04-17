<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Races extends Model
{
    use HasFactory;
    protected $fillable = ['start_time', 'winner_horse_no', 'started'];
}
