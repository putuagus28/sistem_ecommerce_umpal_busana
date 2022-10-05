<?php

namespace App\Http\Controllers;

use App\Kategori;
use App\StokOpname;
use App\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;
use App\User;
use Illuminate\Support\Facades\Session;

class StokOpnameController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StokOpname::with('produk')
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
                    $gambar = explode(",", $row->produk->gambar);
                    $img .= '<img src="' . asset("produk/" . $gambar[0]) . '" class="img-fluid rounded m-2 border" width="40px">';
                    return $img;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        $data = [
            'produk' => Produk::all(),
        ];
        return view('backend.stokopname.index', $data);
    }

    function kurangiQty($id_produk, $qty)
    {
        $p = Produk::find($id_produk);
        $p->stok = ($p->stok - $qty);
        $p->save();
    }

    function kembalikanQty($id_produk, $qty)
    {
        $p = Produk::find($id_produk);
        $p->stok = ($p->stok + $qty);
        $p->save();
    }

    public function insert(Request $req)
    {
        try {
            $q = new StokOpname;
            $q->tanggal = $req->tanggal;
            $q->produks_id = $req->produks_id;
            $q->qty = $req->qty;
            $q->keterangan = $req->keterangan;
            $simpan = $q->save();

            $this->kurangiQty($req->produks_id, $req->qty);

            return response()->json(['status' => $simpan, 'message' => 'Sukses']);
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        $q = StokOpname::with('produk')->where('id', $request->id)->first();
        return response()->json($q);
    }

    public function update(Request $req)
    {
        try {
            $q = StokOpname::find($req->id);
            $this->kembalikanQty($q->produks_id, $q->qty);
            $q->tanggal = $req->tanggal;
            $q->produks_id = $req->produks_id;
            $q->qty = $req->qty;
            $q->keterangan = $req->keterangan;
            $simpan = $q->save();
            $this->kurangiQty($req->produks_id, $req->qty);
            if ($simpan) {
                return response()->json(['status' => $simpan, 'message' => 'Tersimpan']);
            }
        } catch (\Exception $err) {
            return response()->json(['status' => false, 'message' => $err->getMessage()]);
        }
    }
}
