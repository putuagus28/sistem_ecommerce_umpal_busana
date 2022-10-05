@extends('frontend.layouts.app')

@section('title', $description)

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4"> Shoping Cart </span>
        </div>
    </div>

    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-xl-12 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    $('.alert').fadeOut();
                                }, 3500);
                            </script>
                        @endif
                        <div class="wrap-table-shopping-cart">
                            <table class="table table-bordered">
                                <tr class="table_head">
                                    <th class="column-1">No</th>
                                    <th class="column-2">Gambar</th>
                                    <th class="column-3">Nama Produk</th>
                                    <th class="column-4">Size</th>
                                    <th class="column-5">Harga Satuan</th>
                                    <th class="column-6">Jumlah</th>
                                    <th class="column-7">Total</th>
                                    <th class="column-7">Opsi</th>
                                </tr>
                                @if (count($cart) == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">Keranjangmu kosong nih, yuk belanja</td>
                                    </tr>
                                @else
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($cart as $i => $item)
                                        @php
                                            $img = explode(',', $item->produk->gambar);
                                            $harga = $item->produk->harga;
                                            $total = $item->produk->harga * $item->qty;
                                            $subtotal += $total;
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">{{ $i + 1 }}</td>
                                            <td class="column-2">
                                                <div class="how-itemcart1">
                                                    <img src="{{ asset('produk/' . $img[0]) }}" alt="IMG" />
                                                </div>
                                            </td>
                                            <td class="column-3">
                                                {{ $item->produk->nama_produk }}
                                            </td>
                                            <td class="column-4">
                                                M
                                            </td>
                                            <td class="column-5">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                            <td class="column-6">{{ $item->qty }}</td>
                                            <td class="column-7">Rp
                                                {{ number_format($total, 0, ',', '.') }}
                                            </td>
                                            <td class="column-8">
                                                <a href="{{ url('cart/minus/' . $item->id) }}"
                                                    class="btn btn-warning btn-sm {{ $item->qty > 1 ? '' : 'disabled' }}">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ url('cart/' . $item->id) }}"
                                                    onclick="return confirm('Yakin ingin hapus ?')"
                                                    class="btn btn-dark btn-sm">
                                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ url('cart/plus/' . $item->id) }}"
                                                    class="btn btn-warning btn-sm">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6"></td>
                                        <td><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                        <td></td>
                                    </tr>
                                @endif

                            </table>
                        </div>

                        <div class="flex-w flex-sb-l bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <a href="{{ url('cart/checkout') }}"
                                class="flex-c-m stext-101 cl0 size-119 bg1 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')

@endsection
