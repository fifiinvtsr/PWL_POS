@empty($penjualan)
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
                <a href="{{ url('/penjualan') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Transaksi Penjualan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr><th class="text-right col-4">Kode :</th><td class="col-9">{{$penjualan->penjualan_kode }}</td></tr>
                    <tr><th class="text-right col-4">Nama Pembeli :</th><td class="col-9">{{$penjualan->pembeli }}</td></tr>
                    <tr><th class="text-right col-4">Tanggal :</th><td class="col-9">{{$penjualan->penjualan_tanggal }}</td></tr>
                    <tr><th class="text-right col-4">User Pembeli :</th><td class="col-9">{{$penjualan->user->nama }}</td></tr>
                </table>
                <h5>Detil Data:</h5>
                <table class="table table-sm table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualan->detail as $detail)
                            <tr>
                                <td>{{ $detail->barang->barang_nama }}</td>
                                <td>{{ $detail->harga }}</td>
                                <td>{{ $detail->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Tutup</button>
            </div>
        </div>
    </div>
@endempty