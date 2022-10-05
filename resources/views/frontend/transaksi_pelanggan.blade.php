@extends('frontend.layouts.app')

@section('title', $title)
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        div.dataTables_filter label {
            text-align: right !important;
        }

        .modal-backdrop {
            background-color: rgba(0, 0, 0, 0.923);
        }

        ol li {
            list-style-type: decimal !important;
        }
    </style>
@endsection
@section('content')
    <div class="container my-5">
        <div class="row">
            {{-- @include('frontend.layouts.sidebar') --}}
            <div class="col-sm-12 col-md-12 table-responsive">
                <h4>{{ $title }}</h4>
                <a class="btn btn-dark my-3" href="{{ route('pelanggan.dashboard') }}" role="button">Kembali</a>
                <button class="btn btn-warning" id="tutorial"><i class="fa fa-share" aria-hidden="true"></i> Cara
                    Pembayaran</button>
                <br>
                <table class="table table-bordered table-responsive table-sm" id="tb_view">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jumlah</th>
                            <th>Total Pembayaran</th>
                            <th>Tgl Pesan</th>
                            <th>Estimasi Tiba</th>
                            <th>Kurir</th>
                            <th>Ongkir</th>
                            <th>Status</th>
                            <th width="200px">Upload Bukti</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal1 -->
    <div class="modal fade" id="modal" tabindex="-1" style="z-index: 9999" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Panduan Pembayaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ol class="px-5">
                        <li>Silahkan transfers sesuai dengan <strong>total pembayaran</strong> yang tertera pada transaksi
                        </li>
                        <li>Transfers melalui Bank BNI <br> <strong>( 0866230053 - I MADE IRVAN
                                WIDIATMIKA )</strong></li>
                        <li>Upload bukti transfers pada masing-masing column <strong>Upload Bukti > Choose File > Tekan
                                Upload</strong>
                        </li>
                        <li>Selanjutnya admin akan melakukan pengecekan dan melakukan <strong>konfirmasi</strong>.</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal2 -->
    <div class="modal fade" id="modalDetail" style="z-index: 9999" tabindex="-1" role="dialog"
        aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered" id="tb_detail">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah Pesan</th>
                                <th>Harga Total</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- DataTables -->
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- JQuery mask -->
    <script src="{{ asset('assets/plugins/jquery-mask/jquery.mask.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            var table = $('#tb_view').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('pelanggan.transaksi') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'detail',
                        render: function(data, type, row, meta) {
                            return row.detail.length +
                                ' item';
                        },
                    },
                    {
                        data: 'total_bayar',
                        name: 'total_bayar'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'estimasi',
                        name: 'estimasi'
                    },
                    {
                        data: 'kurir',
                        name: 'kurir'
                    },
                    {
                        data: 'ongkir',
                        name: 'ongkir'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row, meta) {
                            var btn = '';
                            if (row.status == 0) {
                                if (row.bukti != null) {
                                    btn =
                                        '<span class="px-2 py-1 bg-warning text-white">menunggu konfirmasi</span>';
                                } else {
                                    btn =
                                        '<span class="px-2 py-1 bg-danger text-white">belum bayar</span>';
                                }
                            } else if (row.status == 1) {
                                btn =
                                    '<span class="px-2 py-1 bg-info text-white"><i class="fa fa-box"></i> dikemas</span>';
                            } else if (row.status == 2) {
                                btn =
                                    '<span class="px-2 py-1 bg-success text-white"><i class="fas fa-truck"></i> dikirim</span>';
                                btn +=
                                    '<span class="mt-1 d-block px-2 py-1 bg-dark text-white">No Resi : ' +
                                    row
                                    .kode_resi + '</span>';
                            } else if (row.status == 3) {
                                btn =
                                    '<span class="px-2 py-1 bg-info text-white">paket telah diterima</span>';
                                btn +=
                                    '<span class="mt-1 d-block px-2 py-1 bg-dark text-white">No Resi : ' +
                                    row
                                    .kode_resi + '</span>';
                            }

                            return btn;
                        },
                    },
                    {
                        data: 'bukti',
                        render: function(data, type, row, meta) {
                            var btn = '';
                            if (row.status == 0 && row.bukti == null) {
                                btn =
                                    '<form method="post">@csrf<input type="hidden" name="id" value="' +
                                    row.id +
                                    '"><input type="file" name="bukti" id="bukti" required class="form-control"><button type="submit" class="btn btn-sm btn-dark mt-1" name="upload_bukti">Upload</button></form>';
                            } else {
                                btn =
                                    '<a href="{{ asset('bukti') }}' + '/' + row.bukti +
                                    '" target="_blank"><img src="{{ asset('bukti') }}' + '/' + row
                                    .bukti +
                                    '" class="img-fluid" width="100"></a>';
                            }
                            return btn;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                order: [
                    [1, "desc"]
                ]
            });

            $('#tutorial').on('click', function() {
                $('#modal').modal('show');
            });

            // upload bukti pembayaran
            table.on('submit', 'form', function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('pelanggan.uploadbukti') }}",
                    dataType: "JSON",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: new FormData(this),
                    success: function(res) {
                        if (res.status) {
                            swal({
                                title: 'Berhasil',
                                text: res.message,
                                icon: "success",
                                button: "Ok",
                            });
                            table.ajax.reload();
                        }
                    }
                });
            });

            // batalkan pesanan
            table.on('click', '#batalkan', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                swal({
                        title: "Yakin ingin membatalkan pesanan anda ?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "POST",
                                url: "{{ route('pelanggan.batalkan') }}",
                                data: {
                                    'id': id,
                                    "_token": "{{ csrf_token() }}",
                                },
                                dataType: "JSON",
                                success: function(res) {
                                    if (res) {
                                        swal({
                                            title: "Pesanan dibatalkan!",
                                            icon: "success",
                                            button: "Ok",
                                        });
                                        table.ajax.reload();
                                    }
                                }
                            });
                        }
                    });

            });

            // detail
            table.on("click", "#detail", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modalDetail').find('#id').val(id);
                $('#modalDetail').modal('show');
                $('#modalDetail').find('.modal-title').text('Detail Pesanan');
                $.ajax({
                    url: "{{ route('detail.pesanan') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        var html = '';
                        $.each(data.detail, function(i, v) {
                            var imgs =
                                '<img src="{{ asset('produk') }}/' + v.gambar +
                                '" class="img-fluid rounded m-2 border p-1 d-block" width="60px">'
                            html += '<tr>';
                            html += '<td>' + (i + 1) + '</td>';
                            html += '<td>' + imgs + v.produk + '</td>';
                            html += '<td>' + v.harga_satuan + '</td>';
                            html += '<td>' + v.qty + '</td>';
                            html += '<td>' + v.total + '</td>';
                            html += '</tr>';
                        });
                        html += '<tr>';
                        html += '<td colspan="3"></td>';
                        html += '<td><strong>Ongkir</strong></td>';
                        html += '<td>' + data.ongkir + '</td>';
                        html += '</tr>';
                        html += '<tr>';
                        html += '<td colspan="3"></td>';
                        html += '<td><strong>Sub Total</strong></td>';
                        html += '<td>' + data.total_bayar + '</td>';
                        html += '</tr>';
                        $('#modalDetail').find('table').find('tbody').html(html);
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opps!',
                            text: 'server error!'
                        });
                        console.log(response);
                    }
                });
            });
        });
    </script>
@endsection
