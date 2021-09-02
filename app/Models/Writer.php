<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class Writer extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'surname',
        'bday', 
        'dday',
        'created_at',
        'update_at'
    ];

    public function books(){
        return $this->belongsToMany(Book::class, 'book_writers');
    }
}
