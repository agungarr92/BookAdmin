<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Brand;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
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
        $brands = brand::all();
        return view('brand', compact('user', 'brands'));
    }

    public function submit_brand(Request $req){
        $brand = new Brand;

        $brand->name = $req->get('name');
        $brand->description = $req->get('description');

        $brand->save();

        $notification = array(
            'message' => 'Data Merek berhasil ditambahkan',
            'alert-type' => 'success'
        );

        return redirect()->route('brand')->with($notification);
    }


    // ajax prosess
    public function getDataBrand($id)
    {
        $brand = Brand::find($id);

        return response()->json($brand);
    }

    // update brand
    public function update_brand(Request $req)
    {
        $brand = Brand::find($req->get('id'));

        $brand->name = $req->get('name');
        $brand->description = $req->get('description');

        $brand->save();

        $notification = array(
            'message' => 'Data Merek berhasil diubah',
            'alert-type' => 'success'
        );

        return redirect()->route('brand')->with($notification);
    }

    public function delete_brand(Request $req)
    {
        $brand = Brand::find($req->get('id'));

        $brand->delete();

        $notification = array(
            'message' => 'Data Merek berhasil dihapus',
            'alert-type' => 'warning'
        );

        return redirect()->route('brand')->with($notification);
    }
}
