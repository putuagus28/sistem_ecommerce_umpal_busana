<aside class="main-sidebar sidebar-dark-info elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url(auth()->user()->role == 'mahasiswa' ? 'setprivilege' : '') }}" class="brand-link">
        <img src="{{ asset('/ecommerce/images/icons/favicon.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-bold">UMPAL BUSANA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image my-auto">
                @if (auth()->user()->foto == null)
                    <i class="fas fa-user-circle text-white fa-3x"></i>
                @else
                    <img src="{{ asset('users/' . auth()->user()->foto . '') }}" class="brand-image img-circle">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block font-weight-bold">
                    @auth
                        {{ strtoupper(auth()->user()->role == 'mahasiswa' ? auth()->user()->mhs->name : auth()->user()->name) }}
                    @endauth
                </a>
                <span class="badge badge-pill badge-info">
                    {{ auth()->user()->role == 'mahasiswa' ? Session::get('jabatan') : auth()->user()->role }}
                </span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item has-treeview {{ request()->is('admin/dashboard') ? 'menu-open' : '' }}">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                @if (in_array(auth()->user()->role, ['admin']))
                    <li class="nav-item has-treeview">
                        <a href="{{ route('user') }}" class="nav-link {{ request()->is('user') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-user-secret"></i>
                            <p>
                                Data Admin
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('kategori') }}"
                            class="nav-link {{ request()->is('kategori') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-file"></i>
                            <p>
                                Data Kategori
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item {{ request()->is('general/produk') || request()->is('auditstok') ? 'menu-open' : '' }}">
                        <a href="#"
                            class="nav-link {{ request()->is('general/produk') || request()->is('auditstok') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-inbox"></i>
                            <p>
                                Produk
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('produk') }}"
                                    class="nav-link {{ request()->is('general/produk') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>List Produk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('auditstok') }}"
                                    class="nav-link {{ request()->is('auditstok') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Audit Stok</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('pelanggan') }}"
                            class="nav-link {{ request()->is('pelanggan') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-users"></i>
                            <p>
                                Data Pelanggan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview">
                        <a href="{{ route('pesanan') }}"
                            class="nav-link {{ request()->is('general/pesanan') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-cart-plus"></i>
                            <p>
                                Data Pemesanan
                            </p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->is('laporan/*') ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link {{ request()->is('laporan/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-print"></i>
                            <p>
                                Laporan
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ url('laporan/penjualan') }}"
                                    class="nav-link {{ request()->is('laporan/penjualan') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Laporan Penjualan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('laporan/stok') }}"
                                    class="nav-link {{ request()->is('laporan/stok') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Laporan Stok</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('laporan/pemesanan') }}"
                                    class="nav-link {{ request()->is('laporan/pemesanan') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Laporan Pemesanan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('laporan/pembayaran') }}"
                                    class="nav-link {{ request()->is('laporan/pembayaran') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Laporan Pembayaran</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('laporan/stok_opname') }}"
                                    class="nav-link {{ request()->is('laporan/stok_opname') ? 'active' : '' }}">
                                    <i class="fa fa-angle-right nav-icon"></i>
                                    <p>Laporan Stok Opname</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- <li class="nav-item has-treeview">
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-user"></i>
                        <p>
                            Profile
                        </p>
                    </a>
                </li> --}}
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
