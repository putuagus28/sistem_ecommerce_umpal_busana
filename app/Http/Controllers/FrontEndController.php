<?php

namespace App\Http\Controllers;

use App\AnggotaUkm;
use App\Produk;
use App\Kategori;
use App\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Session;

class FrontEndController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'title' => 'Umpal busana',
            'description' => 'Toko Spesialis Busana Adat Bali',
            'kategori' => Kategori::all(),
            'produk' => Produk::with('kategori', 'terjual')->get(),
        ];
        return view('frontend.index', $data);
    }

    public function search(Request $req)
    {
        if ($req->search) {
            $query = Produk::with('kategori', 'terjual')
                ->where('nama_produk', 'LIKE', "%{$req->search}%")
                ->orWhere('keterangan', 'LIKE', "%{$req->search}%");
            if ($query->count() == 0) {
                $keyword = explode(' ', $req->search);
                $id = [];
                foreach ($keyword as $item) {
                    $querys = Produk::with('kategori', 'terjual')
                        ->where('nama_produk', 'LIKE', "%{$item}%")
                        ->orWhere('keterangan', 'LIKE', "%{$item}%")
                        ->get();
                    foreach ($querys as $items) {
                        $id[] = $items->id;
                    }
                }
                $id = array_unique($id);
                $query_search = Produk::with('kategori', 'terjual')
                    ->whereIn('id', $id)
                    ->get();
            } else {
                $query_search = Produk::with('kategori', 'terjual')
                    ->where('nama_produk', 'LIKE', "%{$req->search}%")
                    ->orWhere('keterangan', 'LIKE', "%{$req->search}%")
                    ->get();
            }
        }
        if ($req->category) {
            $query_search = Produk::with('kategori', 'terjual')->whereHas('kategori', function ($query)  use ($req) {
                return $query->where('nama_kategori', 'LIKE', "%{$req->category}%");
            })->get();
        }
        $data = [
            'title' => 'Umpal busana',
            'description' => 'Toko Spesialis Busana Adat Bali',
            'kategori' => Kategori::all(),
            'produk' => $query_search,
            'keyword' => ($req->search ? $req->search : $req->category)
        ];
        return view('frontend.search', $data);
    }

    public function detail($id = null)
    {
        $d = Produk::with('kategori', 'terjual')->where('id', $id)->first();
        $d_other = Produk::with('kategori', 'terjual')->where('id', '!=', $id)->get();
        $data = [
            'title' => 'Umpal busana',
            'description' => ucwords($d->nama_produk),
            'id' => $id,
            'detail' => $d,
            'd_other' => $d_other,
        ];
        return view('frontend.detail', $data);
    }

    public function cart(Request $request)
    {
        $data = [
            'cart' => Cart::where([
                'users_global' => auth()->user()->id,
            ])->get(),
            'description' => 'Keranjang Belanja Anda',
        ];
        return view('frontend.cart', $data);
    }

    public function contact(Request $request)
    {
        $data = [
            'description' => 'Contact Us',
        ];
        return view('frontend.contact_us', $data);
    }
}
