<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Kategori;
use App\Pesanan;
use App\DetailPesanan;
use App\StokOpname;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index($jenis = "")
    {
        if ($jenis == "penjualan") {
            $data = [
                'title' => 'Laporan ' . ucwords($jenis),
                'jenis' => $jenis,
                'kategori' => Kategori::all()
            ];
            return view('backend.laporan.' . $jenis, $data);
        } elseif ($jenis == "stok") {
            $data = [
                'title' => 'Laporan ' . ucwords($jenis),
                'jenis' => $jenis,
                'kategori' => Kategori::all()
            ];
            return view('backend.laporan.' . $jenis, $data);
        } elseif ($jenis == "pemesanan") {
            $data = [
                'title' => 'Laporan ' . ucwords($jenis),
                'jenis' => $jenis,
            ];
            return view('backend.laporan.' . $jenis, $data);
        } elseif ($jenis == "pembayaran") {
            $data = [
                'title' => 'Laporan ' . ucwords($jenis),
                'jenis' => $jenis,
            ];
            return view('backend.laporan.' . $jenis, $data);
        } elseif ($jenis == "stok_opname") {
            $data = [
                'title' => 'Laporan ' . ucwords(str_replace("_"," ",$jenis)),
                'jenis' => $jenis,
            ];
            return view('backend.laporan.' . $jenis, $data);
        }

        return abort(404);
    }

    public function getLaporan(Request $request)
    {
        if ($request->jenis == "penjualan") {
            $d1 = date('d-m-Y', strtotime($request->tgl_awal));
            $d2 = date('d-m-Y', strtotime($request->tgl_akhir));
            $query = DetailPesanan::with("pesanan.pelanggan", "produk")
                ->select('*', DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as tanggal'))
                ->whereHas("produk", function ($q) use ($request) {
                    $q->where('kategoris_id', '=', $request->kategori);
                })
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '>=', $d1)
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '<=', $d2)
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'query' => $query,
            ];
        } elseif ($request->jenis == "stok") {
            $query = Produk::with("kategori")
                ->whereHas("kategori", function ($q) use ($request) {
                    $q->where('id', '=', $request->kategori);
                })
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'query' => $query,
            ];
        } elseif ($request->jenis == "pemesanan") {
            $d1 = date('d-m-Y', strtotime($request->tgl_awal));
            $d2 = date('d-m-Y', strtotime($request->tgl_akhir));
            $query = Pesanan::with("pelanggan", "detail.produk")
                ->select('*', DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as tanggal'))
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '>=', $d1)
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '<=', $d2)
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'query' => $query,
            ];
        } elseif ($request->jenis == "pembayaran") {
            $d1 = date('d-m-Y', strtotime($request->tgl_awal));
            $d2 = date('d-m-Y', strtotime($request->tgl_akhir));
            $query = Pesanan::with("pelanggan", "detail.produk")
                ->select('*', DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as tanggal'))
                ->where('status', '>', 0)
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '>=', $d1)
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '<=', $d2)
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'query' => $query,
            ];
        }elseif ($request->jenis == "stok_opname") {
            $d1 = date('d-m-Y', strtotime($request->tgl_awal));
            $d2 = date('d-m-Y', strtotime($request->tgl_akhir));
            $query = StokOpname::with("produk.kategori")
                ->select('*', DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as tanggal'))
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '>=', $d1)
                ->where(DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y")'), '<=', $d2)
                ->orderBy('created_at', 'desc')
                ->get();
            $data = [
                'query' => $query,
            ];
        }
        return response()->json($data);
    }
}
