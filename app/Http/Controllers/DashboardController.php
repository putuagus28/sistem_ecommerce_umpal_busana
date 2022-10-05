<?php

namespace App\Http\Controllers;

use App\Pesanan;
use App\Produk;
use App\Pelanggan;
use App\DetailPesanan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $role = auth()->user()->role;
        $id = auth()->user()->id;
        $page = $role;

        if ($role == 'admin') {
            $data = [
                'title' => 'Dashboard Administrator',
                'produk' => Produk::all()->count(),
                'pesanan' => Pesanan::all()->count(),
                'terlaris'=>DetailPesanan::select('*',DB::raw('SUM(qty) as qty'))
                ->groupBy('produks_id')
                ->orderBy('qty','desc')
                ->get()
            ];
            $page = 'backend/dashboard-admin';
        } elseif ($role == 'pelanggan') {
            // status 0 = belum bayar, 1 = kemas, 2 = kirim, 3 = terima
            $data = [
                'title' => 'Dashboard Member',
                'description' => 'Toko Spesialis Busana Adat Bali',
                'pesanan' => Pesanan::with('detail')->where('users_global', $id)->get(),
                'belumbayar' => Pesanan::with('detail')->where('users_global', $id)->where('status', 0)->get(),
                'dikemas' => Pesanan::with('detail')->where('users_global', $id)->where('status', 1)->get(),
                'dikirim' => Pesanan::with('detail')->where('users_global', $id)->where('status', 2)->get(),
            ];
            $page = 'frontend/dashboard-member';
        }
        $data['bulan'] = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];

        $this->checkout_24jam();
        return view($page, $data);
    }

    public function profile(Request $req)
    {
        if (!empty($req->name)) {
            $up = Pelanggan::find(auth()->user()->id);
            $up->name = $req->name;
            $up->email = $req->email;
            $up->no_telp = $req->no_telp;
            $up->alamat = $req->alamat;
            $up->username = $req->username;
            if (!empty($req->password)) {
                $up->password = bcrypt($req->password);
            }
            $up->save();
            return redirect()->back()->with('success', 'Perubahan berhasil disimpan');
        } else {
            $data = [
                'title' => 'Pengaturan Data Diri',
            ];
            return view('frontend.profile', $data);
        }
    }

    public function email(Request $req)
    {
        $details = [
            'title' => 'Feedback Kami',
            'name' => $req->name,
            'email' => $req->email,
            'pesan' => $req->pesan,
        ];

        \Mail::to('putuagusaditya28@gmail.com')->send(new SendMail($details));

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }

    public function transaksi(Request $request)
    {
        if ($request->ajax()) {
            $data = Pesanan::with('detail')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = "";
                    if ($row->bukti == null) {
                        $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm mx-1" id="batalkan"><i class="fas fa-times"></i> Batalkan</a>';
                    } else {
                        $btn .= '';
                    }
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-info btn-sm mx-1" id="detail"><i class="fas fa-eye"></i> Detail</a>';

                    return $btn;
                })
                ->addColumn('tanggal', function ($row) {
                    return date('Y-m-d G:i:s', strtotime($row->created_at));
                })
                ->addColumn('estimasi', function ($row) {
                    $r = str_replace(['(', ')', ' ', 'hari', 'HARI'], '', $row->estimasi_sampai);
                    $a = explode('-', $r);
                    if (count($a) > 1) {
                        if ($a[0] == $a[1]) {
                            $tgl = $a[0];
                        } else {
                            $tgl = $a[1];
                        }
                    } else {
                        $tgl = $a[0];
                    }
                    return date('Y-m-d', strtotime($row->created_at . '+' . $tgl . ' days'));
                })
                ->addColumn('total_bayar', function ($row) {
                    return 'Rp ' . number_format($row->total_bayar, 0, ',', '.');
                })
                ->addColumn('ongkir', function ($row) {
                    return 'Rp ' . number_format($row->ongkir, 0, ',', '.');
                })
                ->rawColumns(['action', 'tanggal', 'estimasi', 'total_bayar', 'ongkir'])
                ->make(true);
        }
        $role = auth()->user()->role;
        $id = auth()->user()->id;
        $page = $role;
        $data = [
            'title' => 'Transaksi Anda',
        ];

        $this->checkout_24jam();
        return view('frontend/transaksi_pelanggan', $data);
    }

    public function batalkan(Request $req)
    {
        if ($req->ajax()) {
            $p = Pesanan::with('detail')->where('id', $req->id)->get();
            foreach ($p as $item) {
                foreach ($item->detail as $d) {
                    $this->kembalikanQty($d->produks_id, $d->qty);
                }
            }
            $del = Pesanan::where('id', $req->id)->delete();
            return response()->json(true);
        }
    }

    public function uploadbukti(Request $req)
    {
        if ($req->ajax()) {
            try {
                if ($req->hasFile('bukti')) {
                    $file = $req->file('bukti');
                    $extension = $file->getClientOriginalExtension();
                    $fileName = rand(11111, 99999) . '.' . $extension;
                    $file->move(public_path() . '/bukti/', $fileName);
                    $up = Pesanan::find($req->id);
                    $up->bukti = $fileName;
                    $up->save();
                    return response()->json([
                        'status' => true,
                        'message' => 'Berhasil Upload Bukti Pembayaran',
                    ]);
                }
            } catch (\Exception $err) {
                return response()->json(['status' => false, 'message' => $err->getMessage()]);
            }
        }
    }

    public function chart()
    {
        $data['bulan'] = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];

        $total = [];
        for ($i = 1; $i <= 12; $i++) {
            $db = DB::table("pesanans")
                ->selectRaw('SUM(total_bayar) as total')
                ->whereMonth('created_at', '=', $i)
                ->whereYear('created_at', '=', date('Y'))
                ->groupBy(DB::raw("MONTH(created_at)"))
                ->get();
            if ($db->count() == null) {
                $total[] = 0;
            } else {
                foreach ($db as $val) {
                    $total[] = $val->total;
                }
            }
        }
        $data['total'] = $total;
        $data['title'] = 'Penjualan Umpal Busana ' . date('Y');

        return response()->json(array('data' => $data));
    }

    public function chart2()
    {
        $data = [];
        $db = DetailPesanan::with('produk')
        ->select('*',DB::raw('SUM(qty) as total_qty'))
        ->whereYear('created_at', '=', date('Y'))
        ->groupBy('produks_id')
        ->get();
        foreach($db as $v){
            $data[] = $v;
        }

        return response()->json($data);
    }

    public function checkout_24jam()
    {
        // Output: Selisih waktu: 28 tahun, 5 bulan, 9 hari, 13 jam, 7 menit, 7 detik
        $p = Pesanan::with('detail')->get();
        $pesanans_id = [];
        foreach ($p as $ke => $item) {
            $awal  = date_create($item->created_at);
            $akhir = date_create('2022-09-27 12:00:00'); // waktu sekarang
            $diff  = date_diff($awal, $akhir);

            $hari = $diff->days;
            $jam  = $diff->h;
            // cek dlu apakah sudah bukti kosong
            if ($item->bukti == '' || $item->status == 0) {
                // jika lewat 1 hari, 
                if ($hari >= 1) {
                    $pesanans_id[] = $item->id;
                    foreach ($item->detail as $d) {
                        $qty = $d->qty;
                        $this->kembalikanQty($d->produks_id, $qty);
                    }
                }
            }
        }

        // jika ada maka delete berdasarkan array id
        $del = Pesanan::whereIn('id', $pesanans_id)->delete();
        return $del;
    }

    function kembalikanQty($id_produk, $qty)
    {
        $p = Produk::find($id_produk);
        $p->stok = ($p->stok + $qty);
        $p->save();
    }
}
