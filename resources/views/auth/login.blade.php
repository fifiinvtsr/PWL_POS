<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pengguna</title>
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

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Source Sans Pro', sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-container {
            width: 100%;
            max-width: 900px;
            display: flex;
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .left-section {
            flex: 1;
            background: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            border-radius: 15px 0 0 15px;
        }

        .left-section img {
            width: 150px;
        }

        .right-section {
            flex: 1;
            padding: 40px;
            background: #ffffff;
            border-radius: 0 15px 15px 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center; /* Memastikan isi di dalam right-section di tengah */
            color: #000000; /* Ubah seluruh teks di dalam right-section menjadi hitam */
            text-align: center; /* Untuk menengahkan teks */
        }

        .right-section h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            color: #000000; /* Ubah warna teks menjadi hitam */
        }

        .right-section p {
            margin-bottom: 30px;
            color: #000000; /* Ubah warna teks menjadi hitam */
        }

        .input-group {
            margin-bottom: 15px;
            width: 100%; /* Mengisi lebar penuh */
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            width: 100%;
            padding: 12px;
            background: #006631;
            border: none;
            border-radius: 5px;
            color: #ffffff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background: #ffffff;
        }

        .remember-me {
            margin-top: 10px;
            width: 100%; /* Tambahkan agar checkbox menyesuaikan dengan form */
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #000000; /* Ubah warna teks menjadi hitam */
            text-decoration: none;
        }

        .error-text {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #e7a33c;
        }
    </style>
</head>
<body class="hold-transition login-page">

<div class="login-container">
    <!-- Left Section with Logo -->
    <div class="left-section">
        <img src="{{ asset('adminlte/dist/img/logo wiko.png') }}" alt="Logo WIKO"> <!-- Replace with your logo -->
    </div>

    <!-- Right Section with Login Form -->
    <div class="right-section">
        <h2>WIKO "Wisata Kopi Jelajahi Nusantara"</h2>
        <p>SILAHKAN LOGIN </p>
        <form action="{{ url('login') }}" method="POST" id="form-login">
            @csrf
            <div class="input-group mb-3">
                <input type="text" id="username" name="username" class="form-control" placeholder="Username">
                <small id="error-username" class="error-text"></small>
            </div>
            <div class="input-group mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Password">
                <small id="error-password" class="error-text"></small>
            </div>

            <div class="remember-me icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-primary">Masuk</button>
        </form>

        <div class="register-link">
            <p>Belum Punya akun? <a href="{{ url('signup') }}">Daftar disini</a></p>
        </div>
    </div>
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
        $("#form-login").validate({
            rules: {
                username: {required: true, minlength: 4, maxlength: 20},
                password: {required: true, minlength: 5, maxlength: 20}
            },
            submitHandler: function(form) { // ketika valid, maka bagian yg akan dijalankan
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.status){ // jika sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            }).then(function() {
                                window.location = response.redirect;
                            });
                        } else { // jika error
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
                element.closest('.input-group').append(error);
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
