<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionGroup extends Model
{
    //
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'is_required',
        'max_select',
    ];

    public function optionValues(){
        return $this->hasMany(OptionValue::class);
    }

    public function menuOptionGroups(){
        return $this->hasMany(MenuOptionGroup::class);
    }

    public function orderItemOptions(){
        return $this->hasMany(OrderItemOption::class, 'option_group_id');
    }


}
