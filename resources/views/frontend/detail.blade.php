@extends('frontend.layouts.app')

@section('title', $description)

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4"> Produk
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </span>
            <span class="stext-109 cl4"> {{ ucwords($detail->nama_produk) }} </span>
        </div>
    </div>

    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                @php
                                    $img = explode(',', $detail->gambar);
                                @endphp
                                @foreach ($img as $imgs)
                                    <div class="item-slick3" data-thumb="{{ asset('produk/' . $imgs) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('produk/' . $imgs) }}" alt="IMG-PRODUCT">

                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                                href="{{ asset('produk/' . $imgs) }}">
                                                <i class="fa fa-expand"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    $('.alert').fadeOut();
                                }, 2500);
                            </script>
                        @endif
                        <h3 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ ucwords($detail->nama_produk) }}
                        </h3>

                        <span class="mtext-106 cl2">
                            Rp {{ number_format($detail->harga, 0, ',', '.') }}
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {{ $detail->keterangan }}
                        </p>


                        <div class="p-t-33">
                            <form action="{{ route('post.cart') }}" method="post">
                                @csrf
                                <input type="hidden" name="produks_id" value="{{ $id }}">
                                <div class="flex-w flex-l-m p-b-10">
                                    <div class="size-203 flex-l-m respon6">
                                        Size
                                    </div>

                                    <div class="size-204 respon6-next">
                                        {{ ucwords($detail->size) }}
                                    </div>
                                </div>

                                <div class="flex-w flex-l-m p-b-10">
                                    <div class="size-203 flex-l-m respon6">
                                        Jumlah
                                    </div>

                                    <div class="size-204 respon6-next">
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                name="qty" value="1" min="0" required>

                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-w flex-l-m p-b-10">
                                    <div class="size-204 respon6-next">
                                        <button type="submit"
                                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                            Add to cart
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#information" role="tab">Detail
                                Produk</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Categories
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                {{ ucwords($detail->kategori->nama_kategori) }}
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Size
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                {{ $detail->size }}
                                            </span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
                                            <span class="stext-102 cl3 size-205">
                                                Stok Tersedia
                                            </span>

                                            <span class="stext-102 cl6 size-206">
                                                {{ ucwords($detail->stok) }}
                                            </span>
                                        </li>


                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Related Products -->
    <section class="sec-relate-product bg6 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>

            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">
                    @foreach ($d_other as $item)
                        @php
                            $img = explode(',', $item->gambar);
                        @endphp
                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <div class="block2 border bg0">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ asset('produk/' . $img[0]) }}" alt="IMG-PRODUCT">

                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l p-3">
                                        <a href="{{ url('/produk/detail/' . $item->id) }}"
                                            class="stext-105 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            <strong>{{ ucwords($item->nama_produk) }}</strong>
                                        </a>

                                        <span class="stext-105 cl3">
                                            <strong> Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                        </span>

                                        <span class="badge badge-pill badge-warning mt-1"><small>Denpasar</small></span>

                                        <span class="stext-105 cl3 mt-3">
                                            <small>Terjual
                                                @php
                                                    $t = 0;
                                                @endphp
                                                @foreach ($item->terjual as $d)
                                                    @php
                                                        $t += $d->qty;
                                                    @endphp
                                                @endforeach
                                                {{ $t }}
                                            </small>
                                        </span>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
