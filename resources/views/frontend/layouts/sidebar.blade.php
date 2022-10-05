<div class="col-sm-12 col-md-3">
    <div class="card border">
        <img class="card-img-top" src="{{ asset('ecommerce/images/bg-01.jpg') }}" alt="">
        <div class="card-body">
            <h5 class="card-title">Selamat Datang,<br>
                @auth
                    @php
                        echo ucwords(Auth::guard('pelanggan')->user()->name);
                    @endphp
                @endauth
            </h5>
            <p class="card-text">
                @auth
                    <span class="badge badge-pill badge-warning text-white">
                        @php
                            echo Auth::guard('pelanggan')->user()->role;
                        @endphp
                    </span>
                @endauth
            </p>
            <hr>
            <a class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer"
                href="{{ route('logout') }}" onclick="return confirm('Anda yakin ?')" role="button">Logout</a>
        </div>
    </div>
    <br>
    <p class="mb-2"><strong>Pembelian</strong></p>
    <div class="list-group">
        <a href="{{ route('pelanggan.transaksi') }}"
            class="list-group-item list-group-item-action {{ request()->is('pelanggan/dashboard/transaksi') ? 'active' : '' }}">
            <i class="fa fa-angle-right" aria-hidden="true"></i> Daftar Transaksi Saya
        </a>
        {{-- <a href="#" class="list-group-item list-group-item-action">
            <i class="fa fa-angle-right" aria-hidden="true"></i> Menunggu Pembayaran
        </a> --}}
    </div>
    <br>
    <p class="mb-2"><strong>Profil Saya</strong></p>
    <div class="list-group">
        <a href="{{ route('pelanggan.profile') }}"
            class="list-group-item list-group-item-action {{ request()->is('pelanggan/setting/profile') ? 'active' : '' }}">
            <i class="fa fa-angle-right" aria-hidden="true"></i> Pengaturan
        </a>
    </div>
</div>
