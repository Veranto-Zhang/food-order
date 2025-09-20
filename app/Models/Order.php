<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        // 'name',
        // 'phone_number',
        'table_no',
        'payment_method',
        'payment_status',
        'order_status',
        'transaction_date',
        'tax',
        'total_amount',
    ];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
