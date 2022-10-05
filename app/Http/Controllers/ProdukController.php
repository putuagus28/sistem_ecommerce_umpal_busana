<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Session;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Produk::with('kategori')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-success btn-sm mx-1" id="edit"><i class="fas fa-edit"></i></a>';
                    return $btn;
                })
                ->addColumn('gambar', function ($row) {
                    $img = "";
                    $gambar = explode(",", $row->gambar);
                    foreach ($gambar as $item) {
                        $img .= '<img src="' . asset("produk/" . $item) . '" class="img-fluid rounded m-2 border" width="40px">';
                    }
                    return $img;
                })
                ->addColumn('harga', function ($row) {
                    return "Rp " . number_format($row->harga, 0, ',', '.');
                })
                ->rawColumns(['action', 'gambar', 'harga'])
                ->make(true);
        }
        $data = [
            'produk' => Produk::all(),
            'kategori' => Kategori::all(),
        ];
        return view('backend.produk.index', $data);
    }

    public function insert(Request $req)
    {
        $mhs = new Produk;
        try {
            $q = new Produk;
            $q->nama_produk = $req->nama_produk;
            $q->kategoris_id = $req->kategoris_id;
            $q->harga = $req->harga;
            $q->size = $req->size;
            $q->berat_satuan = $req->berat_satuan;
            $q->stok = $req->stok;
            $q->tgl_masuk = $req->tgl_masuk;
            $q->keterangan = $req->keterangan;
            $gambar = [];
            if ($req->hasFile('gambar')) {
                $file = $req->file('gambar');
                foreach ($file as $key => $img) {
                    $extension = $img->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $img->move(public_path() . '/produk/', $fileName);
                    $gambar[] = $fileName;
                }
                // upload ke folder
            }
            $q->gambar = implode(",", $gambar);
            $simpan = $q->save();
            return response()->json(['status' => $simpan, 'message' => 'Sukses']);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $q = Produk::with('kategori')->where('id', $request->id)->first();
        return response()->json($q);
    }

    public function update(Request $req)
    {
        try {
            $q = Produk::find($req->id);
            $q->nama_produk = $req->nama_produk;
            $q->kategoris_id = $req->kategoris_id;
            $q->harga = $req->harga;
            $q->size = $req->size;
            $q->berat_satuan = $req->berat_satuan;
            $q->stok = $req->stok;
            $q->tgl_masuk = $req->tgl_masuk;
            $q->keterangan = $req->keterangan;
            $gambar = [];
            if ($req->hasFile('gambar')) {
                $img_lama = explode(',', $q->gambar);
                if (!empty($q->gambar)) {
                    foreach ($img_lama as $key => $img) {
                        $filePath = 'produk/' . $img;
                        if (file_exists($filePath)) {
                            unlink($filePath);
                        }
                    }
                }

                $file = $req->file('gambar');
                foreach ($file as $key => $img) {
                    $extension = $img->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $img->move(public_path() . '/produk/', $fileName);
                    $gambar[] = $fileName;
                }
                $q->gambar = implode(",", $gambar);
            }
            $simpan = $q->save();
            if ($simpan) {
                return response()->json(['status' => $simpan, 'message' => 'Tersimpan']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }

    public function update_stok(Request $req)
    {
        try {
            $q = Produk::find($req->nama_produk);
            $q->stok = ($q->stok + $req->stok_new);
            $simpan = $q->save();
            if ($simpan) {
                return response()->json(['status' => $simpan, 'message' => 'Stok berhasil ditambah']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }
}
