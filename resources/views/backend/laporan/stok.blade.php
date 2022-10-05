@extends('backend.layouts.app')

@section('title', $title)

@section('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- DatePicker -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.min.css') }}">
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            @if (session('info'))
                <div class="alert alert-danger">
                    <strong><i class="fas fa-exclamation-triangle"></i></strong>
                    {{ session('info') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-info">
                        <div class="card-header d-flex flex-row align-items-center">
                            <h3 class="card-title">Laporan</h3>
                        </div>
                        <form method="POST">
                            @csrf
                            <input type="hidden" name="jenis" value="{{ $jenis }}">
                            <div class="card-body row">
                                <div class="col-12 col-md-1 my-auto">
                                    <label for="">Kategori</label>
                                </div>
                                <div class="col-12 col-md-3">
                                    <select name="kategori" id="kategori" class="form-control">
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer d-flex flex-row align-items-center">
                                <button type="submit" id="lihat" class="btn btn-info">Tampilkan</button>
                                <button type="button" id="cetak" class="btn btn-dark mx-1"><i class="fa fa-print"
                                        aria-hidden="true"></i> Cetak</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row" id="printable">
                {{-- Laporan Transaksi Simpanan --}}
                <div class="col-12 col-md-12">
                    <div class="card card-dark">
                        <div class="card-body">
                            <br>
                            <h4 class="text-center">{{ $title }} Umpal Busana</h4>
                            <p class="text-center">Kategori : <span id="d1"></span></p>
                            <br>
                            <table class="table table-bordered table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Stok Tersisa</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--/. container-fluid -->
    </section>

@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <!-- DatePicker -->
    <script src="{{ asset('assets/plugins/datepicker/bootstrap-datepicker.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/print/jQuery.print.js') }}"></script>
    <script>
        $(document).ready(function() {
            function formatMoney(num) {
                var p = num.toFixed(0).split(".");
                return "Rp " + p[0].split("").reverse().reduce(function(acc, num, i, orig) {
                    return num + (num != "-" && i && !(i % 3) ? "." : "") + acc;
                }, "");
            }

            function openInNewTab(url) {
                window.open(url, '_blank').focus();
            }

            $(function() {
                $("#cetak").on('click', function() {
                    $.print("#printable");
                });
            });

            var validator = $("form").validate({
                rules: {
                    kategori: {
                        required: true,
                    },
                },
                errorElement: "div",
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group, .form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    var data = $(form).serialize();
                    var d1 = $('#kategori option:selected').text();
                    $('#d1').text(d1);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('post.laporan') }}",
                        data: data,
                        dataType: "json",
                        success: function(res) {
                            if (res.query) {
                                $('#table1').find('tbody').html('');
                                var html = '';
                                if (res.query.length >= 1) {
                                    $.each(res.query, function(i, val) {
                                        var ket = '';
                                        if (val.stok > 10) {
                                            ket =
                                                '<strong class="bg-success px-3 py-1">Stok Aman</strong>';
                                        } else {
                                            ket =
                                                '<strong class="bg-warning px-3 py-1">Stok Hampir Habis</strong>';
                                        }
                                        html += '<tr>';
                                        html += '<td>' + (i + 1) + '</td>';
                                        html += '<td>' + val.nama_produk +
                                            '</td>';
                                        html += '<td>' + val.kategori
                                            .nama_kategori +
                                            '</td>';
                                        html += '<td>' + val.stok +
                                            '</td>';
                                        html += '<td>' + ket +
                                            '</td>';
                                        html += '</tr>';
                                    });
                                } else {
                                    html += '<tr>';
                                    html +=
                                        '<td colspan="7" class="text-center">No Data</td>';
                                    html += '</tr>';
                                }

                                $('#table1').find('tbody').append(html);
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection
