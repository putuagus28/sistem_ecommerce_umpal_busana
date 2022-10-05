@extends('frontend.layouts.app')

@section('title', $description)

@section('content')

    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url({{ asset('ecommerce/images/bg-01.jpg') }});">
        <h2 class="ltext-105 cl0 txt-center">
            {{ $description }}
        </h2>
    </section>

    <!-- Product -->
    <section class="bg0 p-t-50 p-b-140">
        <div class="container">
            <div class="p-b-10">
                <h3 class="cl5">
                    Pencarian berdasarkan : {{ $keyword }}
                </h3>
            </div>

            <div class="row">
                {{-- produk --}}
                <div class="col-sm-12 col-md-9">
                    <div class="row isotope-grid mt-5">
                        @if (count($produk) == 0)
                            <div class="alert alert-danger mx-3" role="alert">
                                <strong>Oops, </strong> produk nggak ditemukan
                            </div>
                        @else
                            @foreach ($produk as $i => $item)
                                @php
                                    $img = explode(',', $item->gambar);
                                @endphp
                                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{ $item->kategori->id }}">
                                    <!-- Block2 -->
                                    <div class="block2 border">
                                        <div class="block2-pic hov-img0">
                                            <img src="{{ asset('produk/' . $img[0]) }}" alt="IMG-PRODUCT">

                                            <a href="#"
                                                class="block2-btn flex-c-m stext-103 cl0 size-102 bg1 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal"
                                                data-id="{{ $i }}">
                                                Lihat
                                            </a>
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

                                                <span
                                                    class="badge badge-pill badge-warning mt-1"><small>Denpasar</small></span>

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

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    {{-- <img class="icon-heart1 dis-block trans-04"
                                            src="{{ asset('ecommerce/images/icons/icon-heart-01.png') }}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                            src="{{ asset('ecommerce/images/icons/icon-heart-02.png') }}" alt="ICON"> --}}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal{{ $i }} -->
                                <div class="wrap-modal1 js-modal{{ $i }} p-t-60 p-b-20"
                                    id="modal_{{ $item->id }}">
                                    <div class="overlay-modal1 js-hide-modal"></div>

                                    <div class="container">
                                        <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                                            <button class="how-pos3 hov3 trans-04 js-hide-modal">
                                                <img src="{{ asset('ecommerce/images/icons/icon-close.png') }}"
                                                    alt="CLOSE">
                                            </button>

                                            <div class="row">
                                                <div class="col-md-6 col-lg-7 p-b-30">
                                                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                                                        <div class="wrap-slick3 flex-sb flex-w">
                                                            <div class="wrap-slick3-dots"></div>
                                                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                                            <div class="slick3 gallery-lb">

                                                                @foreach ($img as $imgs)
                                                                    <div class="item-slick3"
                                                                        data-thumb="{{ asset('produk/' . $imgs) }}">
                                                                        <div class="wrap-pic-w pos-relative">
                                                                            <img src="{{ asset('produk/' . $imgs) }}"
                                                                                alt="IMG-PRODUCT">

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
                                                        <h3 class="mtext-105 cl2 js-name-detail p-b-14">
                                                            {{ ucwords($item->nama_produk) }}
                                                        </h3>

                                                        <span class="mtext-106 cl2">
                                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                                        </span>

                                                        <p class="stext-102 cl3 p-t-23">
                                                            {{ $item->keterangan }}
                                                        </p>

                                                        <!--  -->
                                                        <div class="p-t-33">
                                                            <div class="flex-w flex-l-m p-b-10">
                                                                <div class="size-203 flex-l-m respon6">
                                                                    Stok Tersedia
                                                                </div>

                                                                <div class="size-204 respon6-next">
                                                                    {{ ucwords($item->stok) }}
                                                                </div>
                                                            </div>

                                                            <div class="flex-w flex-l-m p-b-10">
                                                                <div class="size-203 flex-l-m respon6">
                                                                    Size
                                                                </div>

                                                                <div class="size-204 respon6-next">
                                                                    {{ ucwords($item->size) }}
                                                                </div>
                                                            </div>

                                                            <div class="flex-w flex-l-m p-b-10">
                                                                <div class="size-203 flex-l-m respon6">
                                                                    Jumlah
                                                                </div>

                                                                <div class="size-204 respon6-next">
                                                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                                        <div
                                                                            class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                                                        </div>

                                                                        <input class="mtext-104 cl3 txt-center num-product"
                                                                            type="number" name="jumlah" value="1">

                                                                        <div
                                                                            class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="flex-w flex-l-m p-b-10">
                                                                <div class="size-204 respon6-next">
                                                                    <button
                                                                        class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                                        Add to cart
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

                    </div>
                </div>

                {{-- categori --}}
                <div class="col-sm-12 col-md-3">
                    <div class="m-t-50 p-t-20 p-b-20 px-4 border">
                        <h4 class="mtext-112 cl2 p-b-27">
                            Category
                        </h4>

                        <div class="flex-w m-r--5">
                            @foreach ($kategori as $item)
                                @php
                                    $css = '';
                                    if ($item->nama_kategori == $keyword) {
                                        $css = 'bg1 bor1';
                                    } else {
                                        $css = 'cl6 bg2 bor7';
                                    }
                                @endphp
                                <form action="{{ url('product/search') }}" method="get">
                                    <input type="hidden" name="category" value="{{ $item->nama_kategori }}">
                                    <button type="submit"
                                        class="flex-c-m stext-107 size-301 {{ $css }}  p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                        {{ $item->nama_kategori }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@section('script')
    <script>
        var ke = '';
        $('.js-show-modal').on('click', function(e) {
            e.preventDefault();
            ke = $(this).data('id');
            $('.js-modal' + ke).addClass('show-modal1');
        });

        $('.js-hide-modal').on('click', function() {
            $('.js-modal' + ke).removeClass('show-modal1');
        });
    </script>
@endsection
