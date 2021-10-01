<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EBook;
use App\Models\EbookImage;
use App\Models\Favorite;
use App\Models\FileUpload;
use App\Models\User;
use App\Models\Waiting_for_ebook;
use App\Models\Writer;
use App\Notifications\EBookWait;
use App\Notifications\NewEbookFromFavorite;

class EbookController extends Controller
{
    public function index(){
        $ebooks = EBook::with(['genres', 'writers', 'image', 'pdf'])->orderByDesc('id')->get();
        return $ebooks;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /*
        $request->validate([
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required']
        ]);
        */

        $ebook = new Ebook([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price
        ]);
        $ebook->save();
        
        //Dodavanje pisaca
        $writers = array_map(function($writer){
            $writer = json_decode($writer, true);
            return $writer['id'];
        }, $request->writers);

        $ebook->writers()->attach($writers);

        //Obavijesti za korisnike kojima je pisac u favorites
        foreach($writers as $writer){
            $favorites = Favorite::where('writer_id', '=', $writer)->get();
            foreach($favorites as $favorite){
                $writer = Writer::find($favorite->writer_id);
                $user = User::find($favorite->user_id);
                $user->notify(new NewEbookFromFavorite($ebook, $writer));
            }
        }

        //Dodavanje žanrova
        $genres = array_map(function($genre){
            $genre = json_decode($genre, true);
            return $genre['id'];
        }, $request->genres);

        $ebook->genres()->attach($genres);

        //Dodavanje slike za knjigu
        $fileUpload = new EbookImage();

        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('ebook_uploads', $file_name, 'public');

        $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
        $fileUpload->path = '/storage/' . $file_path;
        $fileUpload->e_book_id = $ebook->id;

        if($fileUpload->save()){
            //Dodavanje pdf-a za knjigu
            $fileUpload = new FileUpload();

            $file_name = time().'_'.$request->pdf->getClientOriginalName();
            $file_path = $request->file('pdf')->storeAs('file_uploads', $file_name, 'public');

            $fileUpload->name = time().'_'.$request->pdf->getClientOriginalName();
            $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->e_book_id = $ebook->id;

            if($fileUpload->save()){
                return response()->json(['success'=>['E-knjiga uspješno kreirana.']], 200);
            }else{
                return response()->json(['error' => "Greška prilikom kreiranja e-knjige!"], 500);
            }
        }else{
            return response()->json(['error' => "Greška prilikom kreiranja e-knjige!"], 500);
        }

        //return response()->json(['message' => 'E-knjiga kreirana']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $book = EBook::find($id);

        $writers = array_map(function($writer){
            $writer = json_decode($writer, true);
            return $writer['id'];
        }, $request->writers);

        $genres = array_map(function($genre){
            $genre = json_decode($genre, true);
            return $genre['id'];
        }, $request->genres);

        //Ažuriranje međutablica
        $book->writers()->sync($writers);
        $book->genres()->sync($genres);

        //Ažuriranje knjige
        $book->name = $request->name;
        $book->price = $request->price;
        $book->description = $request->description;

        if($book->save()){

            if($request->file !== null){
                //Brisanje stare slike
                $book_image = EbookImage::where('e_book_id', '=', $book->id)->first();
                $book_image->delete();

                unlink(storage_path('app/public/ebook_uploads/'. $book_image->name ));

                //Dodavanje slike za knjigu
                $fileUpload = new EbookImage();

                $file_name = time().'_'.$request->file->getClientOriginalName();
                $file_path = $request->file('file')->storeAs('ebook_uploads', $file_name, 'public');

                $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->e_book_id = $book->id;

                if(!$fileUpload->save()){
                    return response()->json(['error'=>['Greška pilikom spremanja e-knjige']], 200);
                }
            }

            if($request->pdf !== null){
                //Brisanje starog pdf-a
                $book_pdf = FileUpload::where('e_book_id', '=', $book->id)->first();
                $book_pdf->delete();

                unlink(storage_path('app/public/file_uploads/'. $book_pdf->name ));

                //Dodavanje pdf-a za knjigu
                $fileUpload = new FileUpload();

                $file_name = time().'_'.$request->pdf->getClientOriginalName();
                $file_path = $request->file('pdf')->storeAs('file_uploads', $file_name, 'public');

                $fileUpload->name = time().'_'.$request->pdf->getClientOriginalName();
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->e_book_id = $book->id;

                if($fileUpload->save()){
                    return response()->json(['success'=>['E-knjiga uspješno spremljena.']], 200);
                }else{
                    return response()->json(['error' => "Greška prilikom kreiranja e-knjige!"], 500);
                }
            }

            return response()->json(['success'=>['E-knjiga uspješno kreirana.']], 200);

        }else{
            return response()->json(['message' => "Greška prilikom spremanja e-knjige!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        #return Book::where('id', $id)->delete();
        $ebook = Ebook::find($id);

        //Brisanje stare slike
        $book_image = EbookImage::where('e_book_id', '=', $id)->first();
        $book_image->delete();

        unlink(storage_path('app/public/ebook_uploads/'. $book_image->name ));

        //Brisanje starog pdfa
        $book_pdf = FileUpload::where('e_book_id', '=', $id)->first();
        $book_pdf->delete();

        unlink(storage_path('app/public/file_uploads/'. $book_pdf->name ));

        $result = $ebook->delete();
        if($result){
            return ['message' => 'E-knjiga izbrisana!'];
        }
        else{
            return ['message' => 'Greška prilikom brisanja e-knjige!'];
        }
    }
}
