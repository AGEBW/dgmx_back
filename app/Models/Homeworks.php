<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homeworks extends Model
{
    use HasFactory;
    protected $fillable=[
        'id_user',
        'homework',
        'status',
        'details',
    ];

}
