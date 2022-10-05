@extends('frontend.layouts.app')

@section('title', $title)

@section('content')
    <section class="bg-img1 txt-center p-lr-15 p-tb-92"
        style="background-image: url({{ asset('ecommerce/images/bg-02.jpg') }});">
        <h2 class="ltext-105 cl0 txt-center">
            {{ $title }}
        </h2>
    </section>

    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4"> {{ $title }}</span>
        </div>
    </div>

    <section class="bg0 p-t-50 p-b-116">
        <div class="container">
            @if (session('info'))
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i></strong>
                    {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md mx-auto">
                    <form method="POST">
                        @csrf
                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="name"
                                name="name" placeholder="Nama">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-name.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="email" id="email"
                                name="email" placeholder="Email">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-email.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="number" id="no_telp"
                                name="no_telp" placeholder="No telp / wa">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-telp.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="alamat"
                                name="alamat" placeholder="Alamat">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/pin.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="text" id="username"
                                name="username" placeholder="Username">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-user.png') }}"
                                alt="ICON">
                        </div>

                        <div class="bor8 m-b-20 how-pos4-parent">
                            <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30" type="password" id="password"
                                name="password" placeholder="Password">
                            <img class="how-pos4 pointer-none" src="{{ asset('ecommerce/images/icons/icon-lock.png') }}"
                                alt="ICON" style="position: absolute;top: 25%;">
                        </div>
                        <a href="{{ route('login.member') }}" class="stext-115 cl1 size-213 p-t-18 d-block">Sudah punya
                            akun ?
                            Klik disini</a>
                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 mt-3 hov-btn1 p-lr-15 trans-04 pointer">
                            Daftar Sekarang
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                var name = $("#name").val();
                var email = $("#email").val();
                var no_telp = $("#no_telp").val();
                var alamat = $("#alamat").val();
                var username = $("#username").val();
                var password = $("#password").val();
                var token = $("input[name='_token']").val();
                if (name == '') {
                    swal('Info', "Inputan Nama Kosong!", "error");
                } else if (email == '') {
                    swal('Info', "Inputan Email Kosong!", "error");
                } else if (no_telp == '') {
                    swal('Info', "Inputan No Telp Kosong!", "error");
                } else if (alamat == '') {
                    swal('Info', "Inputan Alamat Kosong!", "error");
                } else if (username == '') {
                    swal('Info', "Inputan Username Kosong!", "error");
                } else if (password == '') {
                    swal('Info', "Inputan Password Kosong!", "error");
                } else {
                    $.ajax({
                        url: "{{ route('postregister.member') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        data: {
                            "name": name,
                            "email": email,
                            "no_telp": no_telp,
                            "alamat": alamat,
                            "username": username,
                            "password": password,
                            "_token": token
                        },
                        success: function(response) {
                            if (response.success) {
                                swal('Info', response.message, "success").then((value) => {
                                    window.location.href =
                                        "{{ route('login.member') }}";
                                });
                                $('.container').find('form')[0].reset();
                            } else {
                                swal('Info', response.message, "error");
                            }

                        },
                        error: function(response) {
                            swal('Opps!', response, "error");
                            $('.container').find('form')[0].reset();
                        }
                    });
                }

            });
        });
    </script>
@endsection
