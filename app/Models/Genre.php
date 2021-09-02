<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Book;
use App\Models\EBook;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books(){
        return $this->BelongsToMany(Book::class, 'book_genres');
    }

    public function ebooks(){
        return $this->belongsToMany(EBook::class, 'ebook_genres');
    }
}
