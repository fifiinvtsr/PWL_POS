@extends('layouts.template') 

@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">Daftar Stok</h3> 
        <div class="card-tools">
          <button onclick="modalAction('{{ url('/stok/import') }}')" class="btn btn-info">Impor Stok</button>
          <a href="{{ url('/stok/export_excel') }}" class="btn btn-primary"><i class="fa fa-file-excel"></i> Ekspor Data Stok</a>
          <a href="{{ url('/stok/export_pdf') }}" class="btn btn-warning"><i class="fa fa-file-pdf"></i> Ekspor Data Stok</a>
          <button onclick="modalAction('{{url('stok/create_ajax')}}')" class="btn btn-sm btn-success mt-1">Tambah Data (Ajax)</button>
        </div>
      </div> 
      <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }} </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }} </div>
        @endif
        <div class="row">
          <div class="col-md-12">
              <div class="form-group row">
                  <label class="col-1 control-label col-form-label">Filter: </label>
                  <div class="col-3">
                      <select class="form-control" id="supplier_id" name="supplier_id" required>
                          <option value="">- Semua -</option>
                          @foreach ($supplier as $item)
                              <option value="{{ $item->supplier_id }}">{{ $item->supplier_nama }}</option>
                          @endforeach
                      </select>
                      <small class="form-text text-muted">Supplier Stok</small>
                  </div>
                  <div class="col-3">
                    <select class="form-control" id="barang_id" name="barang_id" required>
                        <option value="">- Semua -</option>
                        @foreach ($barang as $item)
                            <option value="{{ $item->barang_id }}">{{ $item->barang_nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Stok Barang</small>
                  </div>
                  <div class="col-3">
                    <select class="form-control" id="user_id" name="user_id" required>
                        <option value="">- Semua -</option>
                        @foreach ($user as $item)
                            <option value="{{ $item->user_id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Pengguna Stok</small>
                  </div>
              </div>
          </div>
      </div>
      <table class="table table-bordered table-striped table-hover table-sm" id="table_stok"> 
        <thead> 
          <tr><th>ID</th><th>Supplier Stok</th><th>Nama Barang</th><th>Pengguna Stok Barang</th><th>Waktu Stok</th><th>Jumlah Stok</th><th>Aksi</th></tr> 
        </thead> 
      </table> 
    </div> 
  </div>
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection 

@push('css')
<style>
    table.dataTable thead th {
        vertical-align: middle;   /* Align vertical to middle */
    }
</style>
@endpush 

@push('js') 
  <script>
    function modalAction(url = ''){
      $('#myModal').load(url,function(){
        $('#myModal').modal('show');
      });
    }

    var dataStok;
    $(document).ready(function() { 
      dataStok = $('#table_stok').DataTable({ 
          processing: true,
          serverSide: true,      
          ajax: { 
              "url": "{{ url('stok/list') }}", 
              "dataType": "json", 
              "type": "POST" ,
              "data": function (d){
                d.supplier_id = $('#supplier_id').val();
                d.barang_id = $('#barang_id').val();
                d.user_id = $('#user_id').val();
              }
          }, 
          columns: [ 
            { 
              // nomor urut dari laravel datatable addIndexColumn() 
              data: "DT_RowIndex",             
              className: "text-center",
              width: "5%",
              orderable: false, 
              searchable: false     
            },{ 
              // mengambil data supplier hasil dari ORM berelasi 
              data: "supplier.supplier_nama",                
              className: "",
              width: "10%",
              orderable: true,     
              searchable: true     
            },{ 
              // mengambil data barang hasil dari ORM berelasi 
              data: "barang.barang_nama",                
              className: "",
              width: "10%",
              orderable: true,     
              searchable: true     
            },{ 
              // mengambil data user hasil dari ORM berelasi 
              data: "user.nama",                
              className: "",
              width: "10%",
              orderable: true,     
              searchable: true     
            },{ 
              data: "stok_tanggal",                
              className: "",
              width: "10%",
              orderable: true,     
              searchable: true,
            },{ 
              data: "stok_jumlah",                
              className: "",
              width: "5%",
              orderable: true,     
              searchable: true     
            },{ 
              data: "aksi",                
              className: "",
              width: "15%",
              orderable: false,     
              searchable: false
            } 
          ] 
      });
      $('#supplier_id').on('change', function() {
        dataStok.ajax.reload();
      });
      $('#barang_id').on('change', function() {
        dataStok.ajax.reload();
      });
      $('#user_id').on('change', function() {
        dataStok.ajax.reload();
      });
    }); 
  </script>
@endpush