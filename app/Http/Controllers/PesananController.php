<?php

namespace App\Http\Controllers;

use App\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\File;

class PesananController extends Controller
{
    function formatMoney($money = null)
    {
        return 'Rp ' . number_format($money, 0, ',', '.');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pesanan::with('pelanggan', 'detail')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    // status 0 =belum bayar, 1= kemas, 2 = kirim, 3 = terima
                    $btn = "";
                    if ($row->bukti != '' && $row->status == 0) {
                        $btn .= '<div class="dropdown open">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Pilih Status
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <button class="dropdown-item" data-id="'.$row->id.'" id="dikemas">Konfirmasi & Dikemas</button>
                        </div>
                    </div>';
                    } elseif ($row->bukti != '' && $row->status == 1) {
                        $btn .= '<div class="dropdown open">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            Pilih Status
                        </button>
                        <div class="dropdown-menu" aria-labelledby="triggerId">
                            <button class="dropdown-item" data-id="'.$row->id.'" id="dikirim">Siap Dikirim</button>
                        </div>
                    </div>';
                    }
                    $btn .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-dark my-1" id="lihat">Detail</a>';

                    return $btn;
                })
                ->addColumn('tanggal', function ($row) {
                    return date('Y-m-d G:i:s', strtotime($row->created_at));
                })
                ->addColumn('total_bayar', function ($row) {
                    return 'Rp ' . number_format($row->total_bayar, 0, ',', '.');
                })
                ->addColumn('ongkir', function ($row) {
                    return 'Rp ' . number_format($row->ongkir, 0, ',', '.');
                })
                ->rawColumns(['action', 'tanggal', 'total_bayar', 'ongkir'])
                ->make(true);
        }
        return view('backend.pesanan.index');
    }

    public function detail(Request $request)
    {
        $p = Pesanan::with('detail', 'pelanggan', 'admin')->where('id', $request->id)->get();
        $data = [];
        $bulan = [
            "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
            "September", "Oktober", "November", "Desember"
        ];
        foreach ($p as $item) {
            $no = 'T-' . date('Ymd', strtotime($item->created_at)) . $item->total_bayar;
            if ($item->status == 0) {
                if ($item->bukti != '') {
                    $status = '<span class="px-2 py-1 bg-warning text-white">MENUNGGU KONFIRMASI ANDA</span>';
                } else {
                    $status = '<span class="px-2 py-1 bg-danger text-white">BELUM BAYAR</span>';
                }
            } else {
                $status = '<span class="px-2 py-1 bg-success text-white">LUNAS</span>';
            }
            $data = [
                'no' => $no,
                'tanggal_pesan' => date('d', strtotime($item->created_at)) . '-' . $bulan[date('n', strtotime($item->created_at))] . '-' . date('Y', strtotime($item->created_at)),
                'nama_pelanggan' => ucwords($item->pelanggan->name),
                'alamat_pengiriman' => ucwords($item->alamat_pengiriman),
                'no_telp' => $item->pelanggan->no_telp,
                'ongkir' => $this->formatMoney($item->ongkir),
                'catatan' => ($item->catatan == null ? '-' : $item->catatan),
                'status_pembayaran' => $status,
                'total_bayar' => $this->formatMoney($item->total_bayar),
            ];

            foreach ($item->detail as $no => $d) {
                $img = explode(',', $d->produk->gambar);
                $data['detail'][$no] = [
                    'produk' => $d->produk->nama_produk,
                    'gambar' => $img[0],
                    'harga_satuan' => $this->formatMoney($d->produk->harga),
                    'qty' => $d->qty,
                    'total' => $this->formatMoney($d->produk->harga * $d->qty),
                ];
            }
        }
        return response()->json($data);
    }

    public function update_status(Request $req)
    {   
        $p = Pesanan::find($req->id);
        // konfirmasi & kemas
        if($req->status==1){
            $p->status = $req->status;
        }
        // dikirim
        else if($req->status==2){
            $p->kode_resi = $req->kode_resi;
            $p->status = $req->status;
            $p->tgl_kirim = date('Y-m-d');
        }
        $p->save();
        return response()->json([
            'status'=>true,
            'message'=>'Berhasil',
        ]);
    }
}
