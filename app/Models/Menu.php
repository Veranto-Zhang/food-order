<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    //
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'description',
        'category_id',
        'price',
        'is_promo',
        'percent',
        'price_after_discount',
        'sold_count',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function menuOptionGroups(){
        return $this->hasMany(MenuOptionGroup::class);
    }

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }



}
