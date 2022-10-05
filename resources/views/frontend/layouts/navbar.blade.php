@php
$kategori = App\Kategori::all();
@endphp
<!-- Header -->
<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Toko Spesialis Busana Adat Bali
                </div>
                <div class="right-top-bar flex-w h-full">
                    @if (Auth::guard('admin')->check() || Auth::guard('pelanggan')->check())
                        @if (Auth::guard('admin')->check())
                            <a href="{{ route('admin.dashboard') }}" class="flex-c-m trans-04 p-lr-25">
                                Dashboard Saya
                            </a>
                        @else
                            <a href="{{ route('pelanggan.dashboard') }}" class="flex-c-m trans-04 p-lr-25">
                                Dashboard Saya
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login.member') }}" class="flex-c-m trans-04 p-lr-25">
                            Login
                        </a>

                        <a href="{{ route('register.member') }}" class="flex-c-m trans-04 p-lr-25">
                            Daftar
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop how-shadow1">
            <nav class="limiter-menu-desktop container">

                <!-- Logo desktop -->
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ asset('ecommerce/images/icons/logo.png') }}" alt="IMG-LOGO">
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="{{ request()->is('/') ? 'active-menu' : '' }}">
                            <a href="{{ url('') }}">Home</a>
                        </li>
                        <li class="{{ request()->is('produk/categori/*') ? 'active-menu' : '' }}">
                            <a href="#">Category</a>
                            <ul class="sub-menu">
                                @foreach ($kategori as $item)
                                    <li>
                                        <a
                                            href="{{ url('/product/search?category=' . str_replace(' ', '+', $item->nama_kategori)) }}">
                                            {{ $item->nama_kategori }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                        <li class="{{ request()->is('contact-us') ? 'active-menu' : '' }}">
                            <a href="{{ route('contact') }}">Contact Us</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>
                    @php
                        if (Auth::guard('admin')->check() || Auth::guard('pelanggan')->check()) {
                            if (Auth::guard('pelanggan')->check()) {
                                $user = Auth::guard('pelanggan')->user()->id;
                            } else {
                                $user = Auth::guard('admin')->user()->id;
                            }
                        } else {
                            $user = null;
                        }
                        
                        $user = $cart = App\Cart::where([
                            'users_global' => $user,
                        ])->count();
                    @endphp
                    <a href="{{ route('cart') }}"
                        class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        data-notify="{{ $cart }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </a>

                    {{-- <a href="#"
                        class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        data-notify="0">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a> --}}
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="{{ url('') }}"><img src="{{ asset('ecommerce/images/icons/logo.png') }}"
                    alt="IMG-LOGO"></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>


    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over Rp100
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        Help & FAQs
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        My Account
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        EN
                    </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04">
                        USD
                    </a>
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li class="active-menu">
                <a href="{{ url('') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('') }}">Category</a>
                <ul class="sub-menu">
                    <li><a href="{{ url('') }}">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
            </li>
            <li>
                <a href="{{ url('') }}">Contact Us</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="{{ asset('ecommerce/images/icons/icon-close2.png') }}" alt="CLOSE">
            </button>

            <form action="{{ url('product/search') }}" class="wrap-search-header flex-w p-l-15" method="GET">
                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search...">
            </form>
        </div>
    </div>
</header>
