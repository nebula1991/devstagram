<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    Use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id'
    ];
}
