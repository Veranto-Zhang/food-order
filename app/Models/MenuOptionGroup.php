<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuOptionGroup extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'menu_id',
        'option_group_id',
    ];

    public function menu(){
        return $this->belongsTo(Menu::class);
    }

    public function optionGroup(){
        return $this->belongsTo(OptionGroup::class);
    }
}
