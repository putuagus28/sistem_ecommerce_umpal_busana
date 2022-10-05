@extends('frontend.layouts.app')

@section('title', $title)

@section('content')
    <div class="container my-5">
        <div class="row">
            @include('frontend.layouts.sidebar')
            <div class="col-sm-12 col-md-9">
                @if (session()->has('success'))
                    <div class="alert alert-success">
                        {{ session()->get('success') }}
                    </div>
                    <script>
                        setTimeout(() => {
                            $('.alert').fadeOut();
                        }, 3500);
                    </script>
                @endif
                @if (session()->has('error'))
                    <div class="alert alert-danger">
                        {{ session()->get('error') }}
                    </div>
                    <script>
                        setTimeout(() => {
                            $('.alert').fadeOut();
                        }, 3500);
                    </script>
                @endif
                <h4>{{ $title }}</h4>
                <br>
                <form action="{{ route('pelanggan.post.profile') }}" method="post" class="row" id="form">
                    @csrf
                    <div class="form-group col-sm-4">
                        <label for="">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder=""
                            value="{{ auth()->user()->name }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder=""
                            value="{{ auth()->user()->email }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="">No Telp</label>
                        <input type="number" name="no_telp" id="no_telp" class="form-control" placeholder=""
                            value="{{ auth()->user()->no_telp }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="">Alamat</label>
                        <textarea name="alamat" id="alamat"class="form-control" rows="3">{{ trim(auth()->user()->alamat) }}</textarea>
                    </div>
                    <div class="w-100"></div>
                    <div class="form-group col-sm-4">
                        <label for="">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder=""
                            value="{{ auth()->user()->username }}">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="">Password Baru</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="">
                    </div>
                    <div class="w-100"></div>
                    <div class="form-group col-sm-3">
                        <button type="submit" class="btn btn-sm btn-dark" name="user_setting">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Jquery Validate -->
    <script src="{{ asset('assets/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var validator = $("#form").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    no_telp: {
                        required: true,
                    },
                    alamat: {
                        required: true,
                    },
                    username: {
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
                    $(form).ajaxSubmit();
                }
            });
        });
    </script>
@endsection
