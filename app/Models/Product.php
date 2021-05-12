<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 * @method static paginate(int $int)
 */

class Product extends Model
{
    use HasFactory;
    //protected $table = 'products';
    //protected $fillable = ['name', 'slug', 'price'];
    protected $guarded = [];
    //protected $hidden = [];

    public function categories(){
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }
}
