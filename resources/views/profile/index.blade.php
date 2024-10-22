@extends('layouts.template')
@section('content')
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
    <div class="container rounded bg-white border">
        <div class="row" id="profile">
            <div class="col-md-4 border-right">
                <div class="p-3 py-5">
                    <div class="d-flex flex-column align-items-center text-center p-3">
                        <!-- Menampilkan foto profil -->
                        <img class="rounded mt-3 mb-2" width="250px" src="{{ asset($user->foto ? $user->foto : 'adminlte/dist/img/logo wiko.png') }}?{{ time() }}" alt="Foto Profil">
                    </div>
                    <!-- Hapus tombol Edit Foto -->
                    <!-- <div onclick="modalAction('{{ url('/profile/' . session('user_id') . '/edit_foto') }}')" class="mt-4 text-center">
                        <button class="btn btn-primary profile-button" type="button">Edit Foto</button>
                    </div> -->
                </div>
            </div>
            <div class="col-md-8 border-right">
                <div class="p-3 py-4">
                    <div class="d-flex align-items-center">
                        <h4 class="text-right">Pengaturan Profil</h4>
                    </div>
                    <div class="row mt-3">
                        <!-- Menampilkan detail profil pengguna -->
                        <table class="table table-bordered table-striped table-hover table-sm">
                            <tr>
                                <th>ID</th>
                                <td>{{ $user->user_id }}</td>
                            </tr>
                            <tr>
                                <th>Level</th>
                                <td>{{ $user->level->level_nama }}</td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                            <tr>
                                <th>Nama</th>
                                <td>{{ $user->nama }}</td>
                            </tr>
                            <tr>
                                <th>Password</th>
                                <td>********</td>
                            </tr>
                        </table>
                    </div>
                    <!-- Tombol untuk mengedit profil -->
                    <div class="mt-3 text-center">
                        <button onclick="modalAction('{{ url('/profile/' . session('user_id') . '/edit_ajax') }}')" class="btn btn-primary profile-button">Edit Profil</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
@endpush

@push('js')
    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }
        var profile;
        $(document).ready(function() {
            profile = $('#profile').on({
                autoWidth: false,
                serverSide: true,
                ajax: {
                    "url": "{{ url('penjualan/list') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(d) {
                        d.user_id = $('#user_id').val();
                    }
                },
            });
            $('#profile').on('change', function() {
                profile.ajax.reload();
            });
        });
    </script>
@endpush