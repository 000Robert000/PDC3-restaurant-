<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MenuProducts extends Model
{
    protected $fillable = [
    'menu_id', 
    'product_id', 
    ];
    public $timestamps = false;

    protected $table = 'menu_products';
    public function menu()
    {
    return $this->belongsTo(Menus::class, 'menu_id');
    }

    public function product()
    {
    return $this->belongsTo(Products::class, 'product_id');
    }
    protected $hidden = ['pivot'];
}
