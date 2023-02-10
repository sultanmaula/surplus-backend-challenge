<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;

    protected $table = 'category_product';

    protected $fillable = [
        'product_id',
        'category_id',
    ];

    protected $primaryKey = 'product_id';

    public function getCategory()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    public function getProduct()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }
}
