<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_image';

    protected $fillable = [
        'product_id',
        'image_id',
    ];

    protected $primaryKey = 'product_id';

    public function getProduct()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function getImage()
    {
        return $this->hasOne('App\Models\Image', 'id', 'image_id');
    }
}
