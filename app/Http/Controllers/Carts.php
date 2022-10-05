<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Cart;
use App\City;
use App\DetailPesanan;
use App\Pesanan;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class Carts extends Controller
{
    function hari($date)
    {
        $daftar_hari = array(
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        );

        $namahari = date('l', strtotime($date));
        return $daftar_hari[$namahari];
    }

    function getTotal()
    {
        $total = 0;
        $cart = Cart::with('produk')->where('users_global', auth()->user()->id)->get();
        foreach ($cart as $id => $item) {
            $total += $item->produk->harga * $item->qty;
        }
        return $total;
    }

    function kurangiQty($id_produk, $qty)
    {
        $p = Produk::find($id_produk);
        $p->stok = ($p->stok - $qty);
        $p->save();
    }

    function formatMoney($money = null)
    {
        return 'Rp ' . number_format($money, 0, ',', '.');
    }

    public function addToCart(Request $req)
    {
        try {
            $cek = Cart::where([
                'users_global' => auth()->user()->id,
                'produks_id' => $req->produks_id,
            ]);
            if ($cek->exists()) {
                $row = $cek->first();
                $cart = Cart::find($row->id);
                $cart->users_global = auth()->user()->id;
                $cart->produks_id = $req->produks_id;
                $cart->qty = ($cart->qty + $req->qty);
                $cart->save();
            } else {
                $cart = new Cart;
                $cart->users_global = auth()->user()->id;
                $cart->produks_id = $req->produks_id;
                $cart->qty = $req->qty;
                $cart->save();
            }
            return redirect()->back()->with('success', 'Berhasil ditambah dikeranjang');
        } catch (\Exception $er) {
            return redirect()->back()->with('error', $er->getMessage());
        }
    }

    public function action($act = null, $id = null)
    {
        try {
            $up = Cart::find($id);
            if ($act == 'minus') {
                $up->qty = ($up->qty - 1);
                $text = "dikurangi";
            } else {
                $up->qty = ($up->qty + 1);
                $text = "ditambah";
            }
            $up->save();
            return redirect()->back()->with('success', 'Qty berhasil ' . $text);
        } catch (\Exception $er) {
            return redirect()->back()->with('error', $er->getMessage());
        }
    }

    public function removeOne($id = null)
    {
        Cart::destroy($id);
        return redirect()->back()->with('success', 'Berhasil hapus');
    }

    public function checkout(Request $request)
    {
        $data = [
            'cart' => Cart::where([
                'users_global' => auth()->user()->id,
            ])->get(),
            'description' => 'Checkout',
            'provinces' => Province::pluck('name', 'province_id')
        ];
        return view('frontend.checkout', $data);
    }

    public function checkout_submit(Request $req)
    {

        try {
            $cek_ongkir = explode(',', $req->cek_ongkir);
            $total_bayar = $cek_ongkir[0] + $this->getTotal();
            $kota_tujuan = City::where('city_id', $req->kota)->first();
            $provinsi_tujuan = Province::where('province_id', $req->provinsi)->first();

            $p = new Pesanan;
            $p->users_global = auth()->user()->id;
            $p->total_bayar = $total_bayar;
            $p->ongkir = $cek_ongkir[0];
            $p->kurir = $cek_ongkir[1];
            $p->estimasi_sampai = $cek_ongkir[2];
            $p->catatan = $req->pesan;
            $p->alamat_pengiriman = $req->alamat . ', ' . $kota_tujuan->name . ', ' . $provinsi_tujuan->name;
            // status 0 =belum bayar, 1= kemas, 2 = kirim, 3 = terima
            $p->save();

            $id_last = $p->id;

            $cart = Cart::with('produk')->where('users_global', auth()->user()->id)->get();
            foreach ($cart as $id => $item) {
                // kurangi qty stok
                $this->kurangiQty($item->produks_id, $item->qty);

                $d = new DetailPesanan;
                $d->pesanans_id = $id_last;
                $d->produks_id = $item->produks_id;
                $d->qty = $item->qty;
                $d->save();
            }
            return redirect(route('pelanggan.dashboard'))->with('success', 'Transaksi berhasil, silahkan lakukan pembayaran agar produk segera dikirim oleh penjual');
        } catch (\Exception $er) {
            return redirect()->back()->with('error', $er->getMessage());
        }
    }
}
