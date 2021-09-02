<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Book;

class Genre extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books(){
        return $this->BelongsToMany(Book::class, 'book_genres');
    }
}
