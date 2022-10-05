@extends('backend.layouts.app')

@section('title', 'Data Pesanan')

@section('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <style>
        .tb tr td {
            padding: 5px 8px;
        }
    </style>
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
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex flex-row align-items-center">
                            <h3 class="card-title">
                                List Pesanan
                            </h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover" id="tb_view">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pelanggan</th>
                                        <th>Jumlah Pesanan</th>
                                        <th>Total</th>
                                        <th>Kurir</th>
                                        <th>Status</th>
                                        <th>Bukti</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/. container-fluid -->
    </section>

    <!-- Modal -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="modalForm">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="modal-body">
                        <h5><strong>Transaksi</strong></h5>
                        <table class="tb">
                            <tr>
                                <td>No Pemesanan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Tanggal Pesan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>

                        <h5 class="mt-3"><strong>Pelanggan</strong></h5>
                        <table class="tb">
                            <tr>
                                <td>Nama Pelanggan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Alamat Pelanggan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>No Telepon</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Ongkir</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Catatan Pelanggan</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Status Pembayaran</td>
                                <td>:</td>
                                <td></td>
                            </tr>
                        </table>

                        <h5 class="mt-3"><strong>Daftar Pesanan</strong></h5>
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
                </form>
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
    <script src="{{ asset('assets/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Sweetalert2 -->
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            var table = $('#tb_view').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('json.pesanan') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'pelanggan.name',
                        name: 'pelanggan.name'
                    },
                    {
                        data: 'detail',
                        render: function(data, type, row, meta) {
                            return row.detail.length + ' item';
                        },
                    },
                    {
                        data: 'total_bayar',
                        name: 'total_bayar'
                    },
                    {
                        data: 'kurir',
                        name: 'kurir'
                    },
                    {
                        data: 'status',
                        render: function(data, type, row, meta) {
                            var btn = '';
                            if (row.status == 0) {
                                if (row.bukti != null) {
                                    btn =
                                        '<span class="px-2 py-1 bg-warning text-white">menunggu konfirmasi anda</span>';
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
                            } else if (row.status == 3) {
                                btn =
                                    '<span class="px-2 py-1 bg-info text-white">paket telah diterima</span>';
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
                                    '<span class="px-2 py-1 bg-danger">belum transfers</span>';
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
                ]
            });

            // open modal tambah
            $('#tambah').click(function(e) {
                e.preventDefault();
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Tambah');
            });

            // reset all input in form after clicking modal
            $('#modal').on('hidden.bs.modal', function(e) {
                // validator.resetForm();
                $("#modal").find('.is-invalid').removeClass('is-invalid');
                $(this)
                    .find("input,textarea,select")
                    .not('input[name="_token"]')
                    .val('')
                    .end()
                    .find("input[type=checkbox], input[type=radio]")
                    .prop("checked", "")
                    .end();
            });

            // modal show 
            $('#modal').on('shown.bs.modal', function() {
                $(this).find('#nim').focus();
            });

            // detail
            table.on("click", "#lihat", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modal').find('#id').val(id);
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Detail Pesanan');
                $.ajax({
                    url: "{{ route('detail.pesanan') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        $('#modal').find('table').eq(0).find('tr:nth-child(1) td').eq(2).text(
                            data.no);
                        $('#modal').find('table').eq(0).find('tr:nth-child(2) td').eq(2).text(
                            data.tanggal_pesan);
                        // pelanggan
                        $('#modal').find('table').eq(1).find('tr:nth-child(1) td').eq(2).text(
                            data.nama_pelanggan);
                        $('#modal').find('table').eq(1).find('tr:nth-child(2) td').eq(2).text(
                            data.alamat_pengiriman);
                        $('#modal').find('table').eq(1).find('tr:nth-child(3) td').eq(2).text(
                            data.no_telp);
                        $('#modal').find('table').eq(1).find('tr:nth-child(4) td').eq(2).text(
                            data.ongkir);
                        $('#modal').find('table').eq(1).find('tr:nth-child(5) td').eq(2).text(
                            data.catatan);
                        $('#modal').find('table').eq(1).find('tr:nth-child(6) td').eq(2).html(
                            data.status_pembayaran);
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
                        $('#modal').find('table').eq(2).find('tbody').html(html);
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

            // konfirmasi & dikemas
            table.on("click", "#dikemas", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin untuk konfirmasi ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Konfirmasi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('update.status.pesanan') }}",
                            type: "GET",
                            dataType: "json",
                            data: {
                                'id': id,
                                'status': 1,
                            },
                            success: function(res) {
                                if (res) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: res.message,
                                    });
                                    table.ajax.reload();
                                }
                            },
                            error: function(res) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps!',
                                    text: 'server error!'
                                });
                                console.log(res);
                            }
                        });
                    }
                })
            });

            // dikirim
            table.on("click", "#dikirim", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var no_resi = '';
                Swal.fire({
                    title: "Masukan No Resi Kurir",
                    input: 'number',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'No Resi Wajib diisi !'
                        } else {
                            no_resi = value;
                        }
                    },
                    confirmButtonText: 'Simpan',
                    showCancelButton: true
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "{{ route('update.status.pesanan') }}",
                            type: "GET",
                            dataType: "json",
                            data: {
                                'id': id,
                                'status': 2,
                                'kode_resi': no_resi,
                            },
                            success: function(res) {
                                if (res) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: res.message,
                                    });
                                    table.ajax.reload();
                                }
                            },
                            error: function(res) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Opps!',
                                    text: 'server error!'
                                });
                                console.log(res);
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection
