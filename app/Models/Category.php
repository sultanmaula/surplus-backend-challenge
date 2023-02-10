<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';

    protected $fillable = [
        'name',
        'enable',
    ];

    public function product()
    {
        return $this->hasMany('App\Models\CategoryProduct', 'category_id', 'id');
    }
}
