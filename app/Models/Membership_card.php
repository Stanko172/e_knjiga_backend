<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership_card extends Model
{
    use HasFactory;

    protected $table = "membership_card";

    protected $fillable = [
        'user_id',
        'password',
        'is_ot_password',
        'created_at',
        'updated_at'
    ];
}
