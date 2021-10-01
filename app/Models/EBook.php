<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Genre;
use App\Models\Writer;

class EBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'created_at',
        'updated_at'
    ];

    public function genres(){
        return $this->belongsToMany(Genre::class, 'ebook_genres', 'e_book_id', 'genre_id');
    }

    public function writers(){
        return $this->belongsToMany(Writer::class, 'writer_ebooks', 'e_book_id', 'writer_id');
    }

    public function ratings(){
        return $this->hasMany(EBookRating::class);
    }

    public function image(){
        return $this->hasOne(EbookImage::class);
    }

    public function pdf(){
        return $this->hasOne(FileUpload::class);
    }    
}
