<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Writer;

class Book extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'amount',
        'price',
        'created_at',
        'updated_at'
    ];
    public function genres(){
        return $this->belongsToMany(Genre::class, 'book_genres', 'book_id', 'genre_id');
    }

    public function writers(){
        return $this->belongsToMany(Writer::class, 'book_writers', 'book_id', 'writer_id');
    }
}
