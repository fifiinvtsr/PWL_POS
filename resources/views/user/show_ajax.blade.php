@empty($user)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Terjadi kesalahan!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i>Terjadi kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan!</div>
                <a href="{{ url('/user') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detil Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr><th class="text-right col-4">Level Pengguna :</th><td class="col-9">{{$user->level->level_nama }}</td></tr>
                    <tr><th class="text-right col-4">Username :</th><td class="col-9">{{$user->username }}</td></tr>
                    <tr><th class="text-right col-4">Nama :</th><td class="col-9">{{ $user->nama }}</td></tr>
                    <tr><th class="text-right col-4">Foto :</th><td class="col-9">
                        @if($user->foto && file_exists(public_path($user->foto)))
                            <img width="150px" src="{{ asset($user->foto) }}">
                        @else
                            <span>Foto kosong</span>
                        @endif
                    </td></tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
            </div>
        </div>
    </div>
@endempty