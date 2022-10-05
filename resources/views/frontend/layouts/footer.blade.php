<!-- Footer -->
<footer class="bg3 p-t-75 p-b-32">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-4 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Categories
                </h4>
                @php
                    $kategori = App\Kategori::all();
                @endphp
                <ul>
                    @foreach ($kategori as $item)
                        <li class="p-b-10">
                            <a href="{{ url('/product/search?category=' . str_replace(' ', '+', $item->nama_kategori)) }}"
                                class="stext-107 cl7 hov-cl1 trans-04">
                                {{ $item->nama_kategori }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-sm-6 col-lg-4 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    Sitemap
                </h4>

                <ul>
                    <li class="p-b-10">
                        <a href="{{ route('home') }}" class="stext-107 cl7 hov-cl1 trans-04">
                            Home
                        </a>
                    </li>

                    <li class="p-b-10">
                        <a href="{{ route('contact') }}" class="stext-107 cl7 hov-cl1 trans-04">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </div>

            <div class="col-sm-6 col-lg-4 p-b-50">
                <h4 class="stext-301 cl0 p-b-30">
                    UMPAL BUSANA
                </h4>

                <p class="stext-107 cl7 size-201">
                    Jalan Ahmad Yani Utara no. 316, Br. Tek Tek, Peguyangan, Denpasar, Bali, Indonesia, 80115
                </p>

                <div class="p-t-27">
                    <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-instagram"></i>
                    </a>

                    <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                        <i class="fa fa-pinterest-p"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="p-t-40">
            <div class="flex-c-m flex-w p-b-18">
                <a href="#" class="m-all-1">
                    <img src="{{ asset('ecommerce/images/icons/icon-pay-01.png') }}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{ asset('ecommerce/images/icons/icon-pay-02.png') }}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{ asset('ecommerce/images/icons/icon-pay-03.png') }}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{ asset('ecommerce/images/icons/icon-pay-04.png') }}" alt="ICON-PAY">
                </a>

                <a href="#" class="m-all-1">
                    <img src="{{ asset('ecommerce/images/icons/icon-pay-05.png') }}" alt="ICON-PAY">
                </a>
            </div>

            <p class="stext-107 cl6 txt-center">
                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                Copyright &copy;
                <script>
                    document.write(new Date().getFullYear());
                </script> All rights reserved
            </p>
        </div>
    </div>
</footer>


<!-- Back to top -->
<div class="btn-back-to-top" id="myBtn">
    <span class="symbol-btn-back-to-top">
        <i class="zmdi zmdi-chevron-up"></i>
    </span>
</div>
