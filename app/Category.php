<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;
    public $table = 'category';
    public $fillable = [
        'name'
    ];
}
