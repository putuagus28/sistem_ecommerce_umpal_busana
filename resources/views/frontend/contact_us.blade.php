@extends('frontend.layouts.app')

@section('title', $description)

@section('content')

    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url({{ asset('ecommerce/images/bg-01.jpg') }});">
        <h2 class="ltext-105 cl0 txt-center">
            {{ $description }}
        </h2>
    </section>

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4"> {{ $description }}</span>
        </div>
    </div>

    <!-- Contact Us -->
    <section class="bg0 pt-5 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
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
                    <form method="POST" action="{{ url('kirimemail') }}">
                        @csrf
                        <h4 class="mtext-105 cl2 txt-left p-b-30">
                            Send Us A Message
                        </h4>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="name"
                                placeholder="Nama anda">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-name.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" name="email"
                                placeholder="Email anda">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-email.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-30">
                            <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25" name="pesan"
                                placeholder="Masukan pesan yang ingin anda sampaikan"></textarea>
                        </div>

                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                            Submit
                        </button>
                    </form>
                </div>

                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                    <div class="flex-w w-full p-b-42">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-map-marker"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Address
                            </span>

                            <p class="stext-115 cl6 size-213 p-t-18">
                                Br. Tek Tek, Jl. Ahmad Yani Utara No.316, Peguyangan, Kec. Denpasar Utara, Kota Denpasar,
                                Bali 80115
                            </p>
                        </div>
                    </div>

                    <div class="flex-w w-full p-b-42">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-phone-handset"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Phone
                            </span>

                            <p class="stext-115 cl1 size-213 p-t-18">
                                0821-4704-2587
                            </p>
                        </div>
                    </div>

                    <div class="flex-w w-full">
                        <span class="fs-18 cl5 txt-center size-211">
                            <span class="lnr lnr-envelope"></span>
                        </span>

                        <div class="size-212 p-t-2">
                            <span class="mtext-110 cl2">
                                Email
                            </span>

                            <p class="stext-115 cl1 size-213 p-t-18">
                                umpalbusana@gmail.com
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('script')

@endsection
