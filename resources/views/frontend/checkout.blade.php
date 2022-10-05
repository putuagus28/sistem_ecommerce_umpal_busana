@extends('frontend.layouts.app')

@section('title', $description)

@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4"> Checkout </span>
        </div>
    </div>

    <!-- Checkout -->
    <form class="bg0 p-t-75 p-b-85" action="{{ route('submit.checkout') }}" method="POST">
        @csrf
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-xl-12 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    $('.alert').fadeOut();
                                }, 4500);
                            </script>
                        @endif
                        @if (session()->has('error'))
                            <div class="alert alert-danger">
                                {{ session()->get('error') }}
                            </div>
                            <script>
                                setTimeout(() => {
                                    $('.alert').fadeOut();
                                }, 4500);
                            </script>
                        @endif
                        <div class="wrap-table-shopping-cart">
                            <table class="table table-bordered">
                                <tr class="table_head">
                                    <th class="column-1">No</th>
                                    <th class="column-2">Gambar</th>
                                    <th class="column-3">Nama Produk</th>
                                    <th class="column-4">Size</th>
                                    <th class="column-5">Harga Satuan</th>
                                    <th class="column-6">Jumlah</th>
                                    <th class="column-7">Total</th>
                                </tr>
                                @if (count($cart) == 0)
                                    <tr>
                                        <td colspan="8" class="text-center">Keranjangmu kosong nih, yuk belanja</td>
                                    </tr>
                                @else
                                    @php
                                        $subtotal = 0;
                                        $total_berat = 0;
                                    @endphp
                                    @foreach ($cart as $i => $item)
                                        @php
                                            $img = explode(',', $item->produk->gambar);
                                            $harga = $item->produk->harga;
                                            $total = $item->produk->harga * $item->qty;
                                            $subtotal += $total;
                                            $total_berat += $item->qty * $item->produk->berat_satuan;
                                            
                                        @endphp
                                        <tr class="table_row">
                                            <td class="column-1">{{ $i + 1 }}</td>
                                            <td class="column-2">
                                                <div class="how-itemcart1">
                                                    <img src="{{ asset('produk/' . $img[0]) }}" alt="IMG" />
                                                </div>
                                            </td>
                                            <td class="column-3">
                                                {{ $item->produk->nama_produk }}
                                            </td>
                                            <td class="column-4">
                                                M
                                            </td>
                                            <td class="column-5">Rp {{ number_format($harga, 0, ',', '.') }}</td>
                                            <td class="column-6">{{ $item->qty }}</td>
                                            <td class="column-7">Rp
                                                {{ number_format($total, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="5"></td>
                                        <td><strong>Sub Total</strong></td>
                                        <td><strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong></td>
                                    </tr>
                                @endif

                            </table>
                        </div>

                        <div class="bor15 p-t-18">
                            <div class="flex-w">
                                <div class="col-sm-4">
                                    <h5><strong>Lengkapi</strong></h5>
                                    <hr>
                                    <div class="form-group">
                                        <label for="">Nama</label>
                                        <input type="text" name="nama" id="nama" class="form-control"
                                            placeholder="Masukan nama penerima paket" readonly
                                            value="{{ auth()->user()->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">No Hp</label>
                                        <input type="number" name="no" id="no" class="form-control"
                                            placeholder="" readonly value="{{ auth()->user()->no_telp }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="">Alamat Lengkap</label>
                                        <input type="text" name="alamat" id="alamat" class="form-control"
                                            placeholder="Alamat lengkap seperti jalan, gang dll" readonly
                                            value="{{ auth()->user()->alamat }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="">Berikan Pesan untuk penjual</label>
                                        <textarea name="pesan" id="pesan" rows="4" class="form-control" placeholder="..."></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-8 bor15">
                                    <h5><strong>Cek Ongkir</strong></h5>
                                    <div class="alert alert-warning mt-1" role="alert">
                                        <strong>INFO</strong> Mohon masukan dan pilih alamat anda dengan benar agar sesuai
                                        dengan lokasi anda
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-6 d-none">
                                            <label for="">Lokasi Toko</label>
                                            <select name="province_origin" id="province_origin" class="form-control"
                                                required disabled>
                                                <option value="" disabled selected>-- pilih provinsi asal --</option>
                                                @foreach ($provinces as $province => $value)
                                                    <option value="{{ $province }}"
                                                        {{ $value == 'Bali' ? 'selected' : '' }}>
                                                        {{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6 d-none">
                                            <label for="">&nbsp;</label>
                                            <select name="city_origin" id="city_origin" class="form-control" required
                                                disabled></select>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Provinsi Tujuan</label>
                                            <select name="province_destination" id="province_destination"
                                                class="form-control" required>
                                                <option value="" disabled selected>-- pilih provinsi tujuan --
                                                </option>
                                                @foreach ($provinces as $province => $value)
                                                    <option value="{{ $province }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="provinsi" id="provinsi">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="">Kabupaten Tujuan</label>
                                            <select name="city_destination" id="city_destination" class="form-control"
                                                required></select>
                                            <input type="hidden" name="kota" id="kota">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="">Pilih Kurir</label>
                                            <select name="courier" id="courier" class="form-control" required>
                                                <option value="" disabled selected>-- pilih kurir --</option>
                                                <option value="jne">JNE</option>
                                                <option value="pos">POS</option>
                                                <option value="tiki">TIKI</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-sm-3">
                                            <label for="">Berat (gram)</label>
                                            <input type="text" class="form-control" name="weight" id="weight"
                                                readonly value="{{ $total_berat }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-3">
                                            <button type="button" class="btn btn-dark btn-check">CEK ONGKIR</button>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <div class="card d-none list_ongkir">
                                                <div class="card-body">
                                                    <strong>Pilih</strong>
                                                    <ul class="list-group" id="list_ongkir">

                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group mt-3">
                                                <label for="">Ongkir</label>
                                                <input type="text" class="form-control" name="ongkir" id="ongkir"
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group mt-3">
                                                <label for="">Sub Total Pembayaran</label>
                                                <input type="text" class="form-control" name="sub_total_pembyaaran"
                                                    id="sub_total_pembayaran" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mt-3">
                                                <label for="">Via Transfers Bank BNI</label>
                                                <select name="bank" id="bank" class="form-control" disabled>
                                                    <option value="" disabled selected>0866230053 - I MADE IRVAN
                                                        WIDIATMIKA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="flex-w flex-col-r bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                            <div class="flex-w">
                                <a href="{{ url('cart') }}"
                                    class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10 m-r-5">
                                    Kembali
                                </a>
                                <button type="submit"
                                    class="stext-101 cl0 size-119 bg1 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                                    Bayar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <!-- SELECT2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        function formatMoney(num) {
            var p = num.toFixed(2).split(".");
            return "Rp " + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
                return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
            }, "");
        }


        $(document).ready(function() {
            var sub_total = '{{ $subtotal }}';

            $('select').select2({
                theme: 'bootstrap4',
                container: 'body'
            });

            //ajax select kota asal
            var pr = $('select[name="province_origin"] option:selected').val();
            if (pr != '') {
                jQuery.ajax({
                    url: '/cities/' + pr,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $('select[name="city_origin"]').empty();
                        $('select[name="city_origin"]').append(
                            '<option value="">-- pilih kota asal --</option>');
                        $.each(response, function(key, value) {
                            var selected = (value == "Denpasar" ? "selected" : "");
                            $('select[name="city_origin"]').append(
                                '<option value="' + key +
                                '" ' + selected + '>' + value +
                                '</option>');
                        });
                    },
                });
            }
            $('select[name="province_origin"]').on('change', function() {
                let provindeId = $(this).val();
                if (provindeId) {
                    jQuery.ajax({
                        url: '/cities/' + provindeId,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_origin"]').empty();
                            $('select[name="city_origin"]').append(
                                '<option value="">-- pilih kota asal --</option>');
                            $.each(response, function(key, value) {
                                $('select[name="city_origin"]').append(
                                    '<option value="' + key +
                                    '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_origin"]').append(
                        '<option value="">-- pilih kota asal --</option>');
                }
            });

            //ajax select kota tujuan
            $('select[name="province_destination"]').on('change', function() {
                let provindeId = $(this).val();
                $('#provinsi').val(provindeId);
                if (provindeId) {
                    jQuery.ajax({
                        url: '/cities/' + provindeId,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_destination"]').empty();
                            $('select[name="city_destination"]').append(
                                '<option value="">-- pilih kota tujuan --</option>');
                            $.each(response, function(key, value) {
                                $('select[name="city_destination"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_destination"]').append(
                        '<option value="">-- pilih kota tujuan --</option>');
                }
            });

            //ajax check ongkir
            let isProcessing = false;
            $('.btn-check').click(function(e) {
                e.preventDefault();
                $(this).attr('disabled', true).text('Loading...');

                let token = $("meta[name='csrf-token']").attr("content");
                let city_origin = $('select[name=city_origin]').val();
                let city_destination = $('select[name=city_destination]').val();
                let courier = $('select[name=courier]').val();
                let weight = $('#weight').val();
                $('#kota').val(city_destination);

                if (city_destination == null || courier == null) {
                    alert('Inputan cek ongkir masih kosong, Harap periksa Kabupaten tujuan dan Kurir !');
                    $(this).attr('disabled', false).text('CEK ONGKIR');
                    return false;
                }

                if (isProcessing) {
                    return;
                }

                isProcessing = true;
                jQuery.ajax({
                    url: "{{ url('ongkir') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        city_origin: city_origin,
                        city_destination: city_destination,
                        courier: courier,
                        weight: weight,
                    },
                    dataType: "JSON",
                    type: "POST",
                    success: function(response) {
                        isProcessing = false;
                        $('.btn-check').attr('disabled', false).text('CEK ONGKIR');
                        if (response) {
                            $('#list_ongkir').empty();
                            $('.list_ongkir').addClass('d-block');
                            var html = '';
                            var ongkir = [];
                            $.each(response[0]['costs'], function(key, value) {
                                var val = value.cost[0].value + ',' + response[0].code
                                    .toUpperCase() + ' : ' + value.service +
                                    ',' + '(' + value.cost[0].etd +
                                    ' hari)';
                                ongkir.push(value.cost[0].value);
                                html +=
                                    '<li class="list-group-item">' +
                                    '<div class="form-check">' +
                                    '<input class="form-check-input ml-0" type="radio" name="cek_ongkir" id="cek_ongkir_' +
                                    key + '" value="' + val + '" ' + (key == 0 ?
                                        'checked' : '') +
                                    '>' +
                                    '<label class="form-check-label" for="cek_ongkir_' +
                                    key + '">' +
                                    response[0].code.toUpperCase() + ' : <strong>' +
                                    value.service + '</strong> - Rp. ' + value.cost[
                                        0].value + ' (' + value.cost[0].etd +
                                    ' hari)' +
                                    '</label>' +
                                    '</div>' +
                                    '</li>';
                            });

                            var ong = formatMoney(parseInt(ongkir[0]));
                            var total = formatMoney(parseInt(ongkir[0]) + parseInt(
                                sub_total));

                            $('#ongkir').val(ong);
                            $('#sub_total_pembayaran').val(total);
                            $('#list_ongkir').html(html);
                        }

                        $('[name*="cek_ongkir"]').change(function(e) {
                            e.preventDefault();
                            var v = $(this).val().split(',');
                            var ong = formatMoney(parseInt(v[0]));
                            var total = formatMoney(parseInt(v[0]) + parseInt(
                                sub_total));

                            $('#ongkir').val(ong);
                            $('#sub_total_pembayaran').val(total);
                        });
                    }
                });

            });



        });
    </script>
@endsection
