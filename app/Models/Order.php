<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function books(){
        return $this->belongsToMany(Book::class, 'order_books')->withPivot('quantity');
    }

    public function ebooks(){
        return $this->belongsToMany(EBook::class, 'order_ebooks')->withPivot('quantity');
    }

    public function promotions(){
        return $this->belongsToMany(Promotion::class, 'order_promotions')->withPivot('quantity');
    }
}
