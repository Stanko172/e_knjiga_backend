<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookArticleResource;
use App\Http\Resources\EbookArticleResource;
use App\Models\Book;
use App\Models\EBook;
use Illuminate\Http\Request;

class ArticlesSearch extends Controller
{
    public function index(Request $request){
        $str_search = $request->str_search;
        $books = Book::select('id', 'name', 'description', 'created_at')->where(function($query) use ($str_search)
        {
            $columns = ['name', 'description'];

            foreach ($columns as $column)
            {
                $query->orWhere($column, 'LIKE', '%'.$str_search.'%');
            }
        })
        ->orderBy('updated_at', 'desc')                            
        ->get();

        $books = BookArticleResource::collection($books);

        $ebooks = EBook::select('id', 'name', 'description', 'created_at')->where(function($query) use ($str_search)
        {
            $columns = ['name', 'description'];

            foreach ($columns as $column)
            {
                $query->orWhere($column, 'LIKE', '%'.$str_search.'%');
            }
        })
        ->orderBy('updated_at', 'desc')                            
        ->get();

        $ebooks = EbookArticleResource::collection($ebooks);

        $articles = $books->concat($ebooks);

        return $articles->shuffle();
    }
}
