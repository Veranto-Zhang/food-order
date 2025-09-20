<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromoCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 
        'discount_type', 
        'discount_value',
        'expires_at', 
        'usage_limit', 
        'times_used', 
        'is_active',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
    
    public function isValid()
    {
        return $this->is_active &&
               ($this->expires_at === null || $this->expires_at->isFuture()) &&
               ($this->usage_limit === null || $this->times_used < $this->usage_limit);
    }
}
