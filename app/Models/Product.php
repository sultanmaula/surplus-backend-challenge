<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = [
        'name',
        'description',
        'enable',
    ];

    public function category()
    {
        return $this->hasMany('App\Models\CategoryProduct', 'product_id', 'id')->with('getCategory');
    }

    public function image()
    {
        return $this->hasMany('App\Models\ProductImage', 'product_id', 'id')->with('getImage');
    }
}
