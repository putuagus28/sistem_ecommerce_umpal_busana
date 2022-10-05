<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Umpal Busana - @yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('/ecommerce/images/icons/favicon.png') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/ecommerce/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/ecommerce/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/fonts/linearicons-v1.0.0/icon-font.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/animate/animate.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/css-hamburgers/hamburgers.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/animsition/css/animsition.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/select2/select2.min.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/daterangepicker/daterangepicker.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/slick/slick.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/vendor/MagnificPopup/magnific-popup.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/ecommerce/vendor/perfect-scrollbar/perfect-scrollbar.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/ecommerce/css/main.css') }}">
    <!--===============================================================================================-->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <style>
        .list-group-item.active {
            background-color: #d39117;
            border-color: #d39117;
        }
    </style>
    @yield('css')
</head>

<body class="animsition">
    @include('frontend.layouts.navbar')

    @yield('content')

    @include('frontend.layouts.footer')

    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/animsition/js/animsition.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('ecommerce/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/select2/select2.min.js') }}"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('ecommerce/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/slick/slick.min.js') }}"></script>
    <script src="{{ asset('ecommerce/js/slick-custom.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/parallax100/parallax100.js') }}"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/isotope/isotope.pkgd.min.js') }}"></script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/sweetalert/sweetalert.min.js') }}"></script>
    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/

        $('.js-addcart-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="{{ asset('ecommerce/js/main.js') }}"></script>
    @yield('script')
</body>

</html>
