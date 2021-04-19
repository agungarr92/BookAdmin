<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    public static function getDataBooks()
    {
        $books = Book::all();
        $book_filter = [];
        $no = 1;
        for ($i = 0; $i < $books->count(); $i++) {
            $book_filter[$i]['no'] = $no++;
            $book_filter[$i]['judul'] = $books[$i]->judul;
            $book_filter[$i]['penulis'] = $books[$i]->penulis;
            $book_filter[$i]['tahun'] = $books[$i]->tahun;
            $book_filter[$i]['penerbit'] = $books[$i]->penerbit;
        }
        return $book_filter;
    }
}
