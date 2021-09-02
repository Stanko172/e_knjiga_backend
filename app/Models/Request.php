<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'email',
        'shop_office_id',
        'created_at',
        'updated_at'
    ];

    public function shop_office(){
        return $this->belongsTo(Shop_office::class, 'shop_office_id');
    }
}
