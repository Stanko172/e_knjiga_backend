<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Book;
use App\Models\Ebook;

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

    public function ebooks(){
        return $this->belongsToMany(EBook::class, 'writer_ebooks');
    }
}
