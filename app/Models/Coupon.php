<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'price',
        'time_from',
        'time_to',
        'user_id',
        'active'
    ];

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
