<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup Pengguna</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- Custom Style -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Source Sans Pro', sans-serif;
            background: url("{{ asset('adminlte/dist/img/landing.jpg') }}") no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            width: 400px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            padding: 10px 15px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.8);
            color: #000000; /* Warna teks hitam */
        }

        .login-box p {
            text-align: center;
            color: #000000; /* Warna teks hitam */
        }

        .login-box h1 {
            font-size: 2rem;
            text-align: center;
            margin-bottom: 20px;
            color: #000000; /* Warna teks hitam */
        }

        .btn-primary {
            background-color: #000000; /* Warna tombol hitam */
            border-color: #000000;
            border-radius: 5px;
            color: #ffffff; /* Warna teks tombol putih */
        }

        .btn-primary:hover {
            background-color: #333333;
            border-color: #333333;
        }

        .btn-default {
            background-color: #dddddd;
            border-color: #dddddd;
            border-radius: 5px;
            color: #000000;
        }

        .btn-default:hover {
            background-color: #cccccc;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <h1>Daftar Akun</h1>
    <p class="login-box-msg">Silakan isi form di bawah ini untuk membuat akun baru</p>
    <form action="{{ url('signup') }}" method="POST" id="form-tambah">
        @csrf
        <div class="form-group">
            <label for="level_id">Level</label>
            <select class="form-control" id="level_id" name="level_id" required>
                <option value="">- Pilih Level -</option>
                @foreach($level as $item)
                    <option value="{{ $item->level_id }}">{{ $item->level_nama }}</option>
                @endforeach
            </select>
            <small id="error-level_id" class="error-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
            <small id="error-username" class="error-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
            <small id="error-nama" class="error-text text-danger"></small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <small id="error-password" class="error-text text-danger"></small>
        </div>
        <div class="row">
            <div class="col-6">
                <a class="btn btn-default btn-block" href="{{ url('/') }}">Kembali</a>
            </div>
            <div class="col-6">
                <button type="submit" class="btn btn-primary btn-block">Daftar</button>
            </div>
        </div>
    </form>
</div>

<!-- jQuery -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('adminlte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('adminlte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {
        $("#form-tambah").validate({
            rules: {
                level_id: {required: true, number: true},
                username: {required: true, minlength: 3, maxlength: 20},
                nama: {required: true, minlength: 3, maxlength: 100},
                password: {required: true, minlength: 5, maxlength: 20}
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.status){
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            }).then(function() {
                                window.location = response.redirect;
                            });
                        }else{
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-'+prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

</body>
</html>