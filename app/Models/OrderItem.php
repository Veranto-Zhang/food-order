<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_id',
        'menu_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function orderItemOptions(){
        return $this->hasMany(OrderItemOption::class);
    }

}
