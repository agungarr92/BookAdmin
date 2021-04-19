<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Exports\BookExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use PDF;

class BookController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $books = Book::all();
        return view('book', compact('user', 'books'));
    }

    public function submit_book(Request $req)
    {
        $book = new Book;

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extension();

            $filename = 'cover_buku' . time() . '.' . $extension;
            $req->file('cover')->storeAs(
                'public/cover_buku',
                $filename
            );

            $book->cover = $filename;
        }
        $book->save();

        $notification = array(
            'message' => 'Data buku berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }
    public function update(Request $req)
    {
        $book = Book::find($req->get('id'));

        $book->judul = $req->get('judul');
        $book->penulis = $req->get('penulis');
        $book->tahun = $req->get('tahun');
        $book->penerbit = $req->get('penerbit');

        if ($req->hasFile('cover')) {
            $extension = $req->file('cover')->extension();

            $filename = 'cover_buku_' . time() . '.' . $extension;

            $req->file('cover')->storeAs(
                'public/cover_buku',
                $filename
            );

            Storage::delete('public/cover_buku/' . $req->get('old_cover'));

            $book->cover = $filename;
        }

        $book->save();

        $notification = array(
            'message' => 'Data buku berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }

    public function getDataBuku($id)
    {
        $buku = Book::find($id);

        return response()->json($buku);
    }
    public function destroy(Request $req)
    {
        $book = Book::find($req->id);
        Storage::delete('public/cover_buku/' . $req->get('old_cover'));
        $book->delete();

        $notification = array(
            'message' => 'Data buku berhasil dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('admin.books')->with($notification);
    }
    public function print_books()
    {
        $books = Book::all();

        $pdf = PDF::loadview('print_books', ['books' => $books]);
        return $pdf->download('data_buku.pdf');
    }
    public function export()
    {
        return Excel::download(new BooksExport, 'book.xlsx');
    }
}
