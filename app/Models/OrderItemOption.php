<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItemOption extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_item_id',
        'menu_option_id',
        'option_value_id',
        'extra_price',
    ];

    public function optionGroup(){
        return $this->belongsTo(OptionGroup::class);
    }

    public function orderItem(){
        return $this->belongsTo(OrderItem::class);
    }

    public function optionValue(){
        return $this->belongsTo(OptionValue::class);
    }
}
