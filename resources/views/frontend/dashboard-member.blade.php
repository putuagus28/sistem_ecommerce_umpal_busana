@extends('frontend.layouts.app')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row">
            @include('frontend.layouts.sidebar')
            <div class="col-sm-12 col-md-9">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card mb-3">
                            <div class="row no-gutters">
                                <div class="col-md-4 my-auto mx-auto text-center">
                                    <img src="{{ asset('ecommerce/images/icons/order.png') }}" alt="..."
                                        class="img-thumbnail border-0" width="60px">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h6 class="card-title font-weight-bold">Total Transaksi</h6>
                                        <p class="card-text">
                                            {{ count($pesanan) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="alert alert-warning" role="alert">
                            <strong>INFO PEMBAYARAN</strong>
                            <p>upload konfirmasi bukti pembayaran sebelum 1 x 24 jm, jika
                                tidak maka transaksi otomatis dibatalkan</p>
                            <p></p>
                        </div>
                    </div>
                    <div class="col-sm-12">
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
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    $('.alert').fadeOut();
                                }, 3500);
                            </script>
                        @endif
                    </div>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" type="button"
                            role="tab" aria-controls="home" aria-selected="true">Semua
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" type="button"
                            role="tab" aria-controls="settings" aria-selected="false">Belum Dibayar
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="messages-tab" data-toggle="tab" data-target="#messages" type="button"
                            role="tab" aria-controls="messages" aria-selected="false">Dikemas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="settings-tab" data-toggle="tab" data-target="#settings" type="button"
                            role="tab" aria-controls="profile" aria-selected="false">Dikirim
                        </button>
                    </li>
                </ul>

                <div class="tab-content border p-3">
                    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row">
                            @if (count($pesanan) == 0)
                                <div class="alert alert-danger" role="alert">
                                    Anda belum mempunyai transaksi
                                </div>
                            @else
                                @foreach ($pesanan as $item)
                                    @foreach ($item->detail as $d)
                                        @php
                                            $img = explode(',', $d->produk->gambar);
                                        @endphp
                                        <div class="col-sm-6">
                                            <div class="card mb-3">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4 d-flex align-content-start flex-wrap pt-3 mt-1">
                                                        <img src="{{ asset('produk/' . $img[0]) }}" alt="..."
                                                            class="img-thumbnail border-0">
                                                        @php
                                                            $text = '';
                                                            $css = '';
                                                            if ($item->status == 0) {
                                                                if ($item->bukti == null) {
                                                                    $text = 'belum bayar';
                                                                    $css = 'danger';
                                                                } else {
                                                                    $text = 'menunggu konfirmasi';
                                                                    $css = 'warning';
                                                                }
                                                            } elseif ($item->status == 1) {
                                                                $text = 'dikemas';
                                                                $css = 'info';
                                                            } elseif ($item->status == 2) {
                                                                $text = 'dikirim';
                                                                $css = 'info';
                                                            } elseif ($item->status == 3) {
                                                                $text = 'diterima';
                                                                $css = 'success';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge badge-pill badge-{{ $css }} mx-auto mt-1">
                                                            {{ $text }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body py-3">
                                                            <h5 class="card-title">{{ ucwords($d->produk->nama_produk) }}
                                                            </h5>
                                                            <p class="card-text">
                                                                <small>{{ Str::limit($d->produk->keterangan, 80, '...') }}</small>
                                                            </p>
                                                            <p class="card-text mt-2">
                                                                <strong>{{ $d->qty }} barang </strong> x
                                                                <strong>Rp
                                                                    {{ number_format($d->produk->harga, 0, ',', '.') }}</strong>
                                                            </p>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-sm-6 d-flex align-content-center flex-wrap">
                                                                    <a class="btn btn-dark btn-sm"
                                                                        href="{{ url('produk/detail/' . $d->produks_id) }}"
                                                                        role="button">Beli lagi</a>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <small>Total Belanja</small>
                                                                    <p class="card-text">
                                                                        <strong>Rp
                                                                            {{ number_format($d->produk->harga * $d->qty, 0, ',', '.') }}</strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            @if (count($belumbayar) == 0)
                                <div class="alert alert-danger" role="alert">
                                    Anda belum mempunyai transaksi
                                </div>
                            @else
                                @foreach ($belumbayar as $item)
                                    @foreach ($item->detail as $d)
                                        @php
                                            $img = explode(',', $d->produk->gambar);
                                        @endphp
                                        <div class="col-sm-6">
                                            <div class="card mb-3">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4 d-flex align-content-start flex-wrap pt-3 mt-1">
                                                        <img src="{{ asset('produk/' . $img[0]) }}" alt="..."
                                                            class="img-thumbnail border-0">
                                                        @php
                                                            $text = '';
                                                            $css = '';
                                                            if ($item->status == 0) {
                                                                if ($item->bukti == null) {
                                                                    $text = 'belum bayar';
                                                                    $css = 'danger';
                                                                } else {
                                                                    $text = 'menunggu konfirmasi';
                                                                    $css = 'warning';
                                                                }
                                                            } elseif ($item->status == 1) {
                                                                $text = 'dikemas';
                                                                $css = 'info';
                                                            } elseif ($item->status == 2) {
                                                                $text = 'dikirim';
                                                                $css = 'info';
                                                            } elseif ($item->status == 3) {
                                                                $text = 'diterima';
                                                                $css = 'success';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge badge-pill badge-{{ $css }} mx-auto mt-1">
                                                            {{ $text }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body py-3">
                                                            <h5 class="card-title">{{ ucwords($d->produk->nama_produk) }}
                                                            </h5>
                                                            <p class="card-text">
                                                                <small>{{ Str::limit($d->produk->keterangan, 80, '...') }}</small>
                                                            </p>
                                                            <p class="card-text mt-2">
                                                                <strong>{{ $d->qty }} barang </strong> x
                                                                <strong>Rp
                                                                    {{ number_format($d->produk->harga, 0, ',', '.') }}</strong>
                                                            </p>
                                                            <hr>
                                                            <div class="row">
                                                                <div
                                                                    class="col-sm-6 d-flex align-content-center flex-wrap">
                                                                    <a class="btn btn-dark btn-sm"
                                                                        href="{{ url('produk/detail/' . $d->produks_id) }}"
                                                                        role="button">Beli lagi</a>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <small>Total Belanja</small>
                                                                    <p class="card-text">
                                                                        <strong>Rp
                                                                            {{ number_format($d->produk->harga * $d->qty, 0, ',', '.') }}</strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="messages" role="tabpanel" aria-labelledby="messages-tab">
                        <div class="row">
                            @if (count($dikemas) == 0)
                                <div class="alert alert-danger" role="alert">
                                    Belum ada produk yg dikemas
                                </div>
                            @else
                                @foreach ($dikemas as $item)
                                    @foreach ($item->detail as $d)
                                        @php
                                            $img = explode(',', $d->produk->gambar);
                                        @endphp
                                        <div class="col-sm-6">
                                            <div class="card mb-3">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4 d-flex align-content-start flex-wrap pt-3 mt-1">
                                                        <img src="{{ asset('produk/' . $img[0]) }}" alt="..."
                                                            class="img-thumbnail border-0">
                                                        @php
                                                            $text = '';
                                                            $css = '';
                                                            if ($item->status == 0) {
                                                                $text = 'belum bayar';
                                                                $css = 'danger';
                                                            } elseif ($item->status == 1) {
                                                                $text = 'dikemas';
                                                                $css = 'info';
                                                            } elseif ($item->status == 2) {
                                                                $text = 'dikirim';
                                                                $css = 'info';
                                                            } elseif ($item->status == 3) {
                                                                $text = 'diterima';
                                                                $css = 'success';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge badge-pill badge-{{ $css }} mx-auto mt-1">
                                                            {{ $text }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body py-3">
                                                            <h5 class="card-title">{{ ucwords($d->produk->nama_produk) }}
                                                            </h5>
                                                            <p class="card-text">
                                                                <small>{{ Str::limit($d->produk->keterangan, 80, '...') }}</small>
                                                            </p>
                                                            <p class="card-text mt-2">
                                                                <strong>{{ $d->qty }} barang </strong> x
                                                                <strong>Rp
                                                                    {{ number_format($d->produk->harga, 0, ',', '.') }}</strong>
                                                            </p>
                                                            <hr>
                                                            <div class="row">
                                                                <div
                                                                    class="col-sm-6 d-flex align-content-center flex-wrap">
                                                                    <a class="btn btn-dark btn-sm"
                                                                        href="{{ url('produk/detail/' . $d->produks_id) }}"
                                                                        role="button">Beli lagi</a>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <small>Total Belanja</small>
                                                                    <p class="card-text">
                                                                        <strong>Rp
                                                                            {{ number_format($d->produk->harga * $d->qty, 0, ',', '.') }}</strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="tab-pane" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        <div class="row">
                            @if (count($dikirim) == 0)
                                <div class="alert alert-danger" role="alert">
                                    Belum ada produk yg dikirim
                                </div>
                            @else
                                @foreach ($dikirim as $item)
                                    @foreach ($item->detail as $d)
                                        @php
                                            $img = explode(',', $d->produk->gambar);
                                        @endphp
                                        <div class="col-sm-6">
                                            <div class="card mb-3">
                                                <div class="row no-gutters">
                                                    <div class="col-md-4 d-flex align-content-start flex-wrap pt-3 mt-1">
                                                        <img src="{{ asset('produk/' . $img[0]) }}" alt="..."
                                                            class="img-thumbnail border-0">
                                                        @php
                                                            $text = '';
                                                            $css = '';
                                                            if ($item->status == 0) {
                                                                $text = 'belum bayar';
                                                                $css = 'danger';
                                                            } elseif ($item->status == 1) {
                                                                $text = 'dikemas';
                                                                $css = 'info';
                                                            } elseif ($item->status == 2) {
                                                                $text = 'dikirim';
                                                                $css = 'info';
                                                            } elseif ($item->status == 3) {
                                                                $text = 'diterima';
                                                                $css = 'success';
                                                            }
                                                        @endphp
                                                        <span
                                                            class="badge badge-pill badge-{{ $css }} mx-auto mt-1">
                                                            {{ $text }}
                                                        </span>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="card-body py-3">
                                                            <h5 class="card-title">{{ ucwords($d->produk->nama_produk) }}
                                                            </h5>
                                                            <p class="card-text">
                                                                <small>{{ Str::limit($d->produk->keterangan, 80, '...') }}</small>
                                                            </p>
                                                            <p class="card-text mt-2">
                                                                <strong>{{ $d->qty }} barang </strong> x
                                                                <strong>Rp
                                                                    {{ number_format($d->produk->harga, 0, ',', '.') }}</strong>
                                                            </p>
                                                            <hr>
                                                            <div class="row">
                                                                <div
                                                                    class="col-sm-6 d-flex align-content-center flex-wrap">
                                                                    <a class="btn btn-dark btn-sm"
                                                                        href="{{ url('produk/detail/' . $d->produks_id) }}"
                                                                        role="button">Beli lagi</a>
                                                                </div>
                                                                <div class="col-sm-6 text-right">
                                                                    <small>Total Belanja</small>
                                                                    <p class="card-text">
                                                                        <strong>Rp
                                                                            {{ number_format($d->produk->harga * $d->qty, 0, ',', '.') }}</strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $(function() {
                // $('#myTab li:last-child button').tab('show')
            })
        });
    </script>
@endsection
