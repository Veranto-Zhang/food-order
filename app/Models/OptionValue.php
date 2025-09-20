<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValue extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'option_group_id',
        'name',
        'extra_price',
    ];

    public function optionGroup(){
        return $this->belongsTo(OptionGroup::class);
    }

    public function orderItemOptions(){
        return $this->hasMany(OrderItemOption::class, 'option_value_id');
    }

}
