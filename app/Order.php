<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id'];
    protected $casts = [
        'load_points' => 'array',
        'unload_points' => 'array',
    ];
    //
}
