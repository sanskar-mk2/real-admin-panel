<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = [
        'name',
        'score',
        'user_id',
        'username',
        'firstname',
        'lastname',
        'photo_url'
    ];
}
