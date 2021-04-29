<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Categorie;

class CategorieController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $user = Auth::user();
        $categories = Categorie::all();
        return view('categorie', compact('user', 'categories'));
    }

    public function submit_categorie(Request $req){
        $categorie = new Categorie;

        $categorie->name = $req->get('name');
        $categorie->description = $req->get('description');

        $categorie->save();

        $notification = array(
            'message' => 'Data Merek berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('categorie')->with($notification);
    }

    // ajax prosess
    public function getDataCategorie($id)
    {
        $categorie = Categorie::find($id);

        return response()->json($categorie);
    }

    // update categorie
    public function update_categorie(Request $req)
    {
        $categorie = Categorie::find($req->get('id'));

        $categorie->name = $req->get('name');
        $categorie->description = $req->get('description');

        $categorie->save();

        $notification = array(
            'message' => 'Data Merek berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('categorie')->with($notification);
    }

    public function delete_categorie(Request $req)
    {
        $categorie = Categorie::find($req->get('id'));

        $categorie->delete();

        $notification = array(
            'message' => 'Data Merek berhasil dihapus',
            'alert-type' => 'success'
        );

        return redirect()->route('categorie')->with($notification);
    }
}
