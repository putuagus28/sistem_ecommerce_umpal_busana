@extends('backend.layouts.app')

@section('title', 'Data Produk')

@section('css')
    <!-- Sweetalert2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                                <i class="fas fa-boxes"></i> Produk
                            </h3>
                            <button class="btn btn-info ml-auto" id="tambah">Tambah</button>
                            <button class="btn btn-danger ml-1" id="tambah_stok">Tambah Stok</button>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="100">Foto</th>
                                        <th>Nama Produk</th>
                                        <th>Kategori</th>
                                        <th>Size</th>
                                        <th>Berat Satuan</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
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

    <!-- Modal1 -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="">Nama Produk</label>
                                    <input type="text" name="nama_produk" id="nama_produk" class="form-control"
                                        autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="">Kategori</label>
                                    <select name="kategoris_id" id="kategoris_id" class="form-control select2">
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach ($kategori as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <input type="number" name="harga" id="harga" class="form-control">
                                </div>
                            </div>

                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <label for="">Size</label>
                                    <select name="size" id="size" class="form-control select2">
                                        <option value="" disabled selected>Pilih</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label for="">Berat Satuan (gram)</label>
                                        <input type="number" name="berat_satuan" id="berat_satuan" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Stok</label>
                                        <input type="number" name="stok" id="stok" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="">Tanggal Masuk</label>
                                        <input type="date" name="tgl_masuk" id="tgl_masuk" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <label for="">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="">Foto</label>
                                    <input type="file" name="gambar[]" id="gambar" multiple class="form-control">
                                </div>
                            </div>

                            <div class="col-12 col-sm-12" id="imgPlace">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-info">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal2 -->
    <div class="modal fade" id="modalStok" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
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
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Nama Produk</label>
                                    <select name="nama_produk" id="nama_produk" class="form-control select2">
                                        <option value="" disabled selected>Pilih</option>
                                        @foreach ($produk as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_produk }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Stok Sebelumnya</label>
                                    <input type="number" name="stok_old" id="stok_old" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="">Stok Sebelumnya</label>
                                    <input type="number" name="stok_new" id="stok_new" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info">Tambah</button>
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
    <!-- SELECT2 -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.fn.modal.Constructor.prototype._enforceFocus = function() {};
            var table = $('table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: "{{ route('json.produk') }}",
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                    },
                    {
                        data: 'gambar',
                        name: 'gambar'
                    },
                    {
                        data: 'nama_produk',
                        name: 'nama_produk'
                    },
                    {
                        data: 'kategori.nama_kategori',
                        name: 'kategori.nama_kategori'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'berat_satuan',
                        render: function(data, type, row, meta) {
                            return row.berat_satuan + ' gram';
                        },
                    },
                    {
                        data: 'harga',
                        name: 'harga'
                    },
                    {
                        data: 'stok',
                        name: 'stok'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            $('.select2').select2({
                theme: 'bootstrap4',
                container: 'body'
            });

            // open modal tambah
            $('#tambah').click(function(e) {
                e.preventDefault();
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Tambah');
            });

            // stok
            $('#tambah_stok').click(function(e) {
                e.preventDefault();
                $('#modalStok').modal('show');
                $('#modalStok').find('.modal-title').text('Tambah Stok');
            });

            // reset all input in form after clicking modal
            $('#modal,#modalStok').on('hidden.bs.modal', function(e) {
                validator.resetForm();
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
                // $(this).find('#nim').focus();
            });

            $('#modalStok #nama_produk').on('change', function(e) {
                e.preventDefault();
                var id = $(this).val();
                $.get("{{ route('edit.produk') }}", {
                        'id': id
                    },
                    function(data, textStatus, jqXHR) {
                        $('#stok_old').val(data.stok);
                        $('#stok_new').val(0);
                    },
                    "json"
                );
            });

            // edit
            table.on("click", "#edit", function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#modal').find('#id').val(id);
                $('#modal').modal('show');
                $('#modal').find('.modal-title').text('Form Edit');
                $.ajax({
                    url: "{{ route('edit.produk') }}",
                    type: "GET",
                    dataType: "json",
                    data: {
                        'id': id
                    },
                    success: function(data) {
                        $('#modal').find('#nama_produk').val(data.nama_produk);
                        $('#modal').find('#kategoris_id').val(data.kategoris_id).change();
                        $('#modal').find('#tgl_masuk').val(data.tgl_masuk).change();
                        $('#modal').find('#harga').val(data.harga);
                        $('#modal').find('#size').val(data.size);
                        $('#modal').find('#berat_satuan').val(data.berat_satuan);
                        $('#modal').find('#stok').val(data.stok);
                        $('#modal').find('#keterangan').val(data.keterangan);
                        var img = data.gambar.split(',');
                        var imgs = '';
                        for (let i = 0; i < img.length; i++) {
                            imgs +=
                                '<img src="{{ asset('produk') }}/' + img[i] +
                                '" class="img-fluid rounded m-2 border p-2" width="100px">'
                        }
                        $('#modal').find('#imgPlace').html(imgs);
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

            // tambah data
            var validator = $("#modal #modalForm").validate({
                rules: {
                    nama_produk: {
                        required: true,
                    },
                    kategoris_id: {
                        required: true,
                    },
                    harga: {
                        required: true,
                    },
                    size: {
                        required: true,
                    },
                    berat_satuan: {
                        required: true,
                    },
                    stok: {
                        required: true,
                    },
                    tgl_masuk: {
                        required: true,
                    },
                    keterangan: {
                        required: true,
                    },
                    'gambar[]': {
                        required: function() {
                            return $('#modalForm #id').val() == "";
                        },
                        extension: "jpeg|png|jpg",
                    }
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
                    var id = $(form).find('#id').val();
                    if (id == "") {
                        $.ajax({
                            url: "{{ route('insert.produk') }}",
                            type: "POST",
                            dataType: "JSON",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: new FormData(form),
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.message,
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        $('#modal').modal('hide');
                                        table.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.message,
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        table.ajax.reload();
                                    });
                                }
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
                    } else {
                        $.ajax({
                            url: "{{ route('update.produk') }}",
                            type: "POST",
                            dataType: "JSON",
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: new FormData(form),
                            success: function(response) {
                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: response.message,
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        $('#modal').modal('hide');
                                        table.ajax.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: response.message,
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        table.ajax.reload();
                                    });
                                }
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
                    }

                }
            });

            var validator = $("#modalStok #modalForm").validate({
                rules: {
                    nama_produk: {
                        required: true,
                    },
                    stok_new: {
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
                    $.ajax({
                        url: "{{ route('update.stok') }}",
                        type: "POST",
                        dataType: "JSON",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: new FormData(form),
                        success: function(response) {
                            if (response.status) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    $('#modalStok').modal('hide');
                                    table.ajax.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: response.message,
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    table.ajax.reload();
                                });
                            }
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
                }
            });
        });
    </script>
@endsection
