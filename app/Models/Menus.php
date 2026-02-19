<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'menus'; 

    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Products::class, 'menu_products', 'menu_id', 'product_id');
    }
     protected $hidden = ['pivot'];
}

