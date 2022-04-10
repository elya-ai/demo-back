<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $table = "orders";
    public $timestamps = true;
    public $fillable = [
        'address', 'description', 'category', 'price', 'image', 'type'
    ];
}
