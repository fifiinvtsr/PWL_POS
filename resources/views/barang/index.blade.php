@extends('layouts.template') 

@section('content') 
  <div class="card card-outline card-primary"> 
      <div class="card-header"> 
        <h3 class="card-title">Daftar Barang</h3> 
        <div class="card-tools">
            <button onclick="modalAction('{{ url('/barang/import') }}')" class="btn btn-sm btn-info mt-1">Impor Barang</button>
            {{-- JS08 Praktikum 2 --}}
            <a href="{{ url('/barang/export_excel') }}" class="btn btn-sm btn-info mt-1"><i class="fa fa-file-excel"></i> Export Barang</a>
            {{-- JS08 Praktikum 3 --}}
            <a href="{{ url('/barang/export_pdf') }}" class="btn btn-warning"><i class="fa fa-filepdf"></i> Export Barang</a>
            <button onclick="modalAction('{{url('barang/create_ajax')}}')" class="btn btn-sm btn-success mt-1">Tambah Data (Ajax)</button>

        </div>          
      </div> 
      <div class="card-body">
        <!-- untuk Filter Data -->
        <div id="filter" class="form-horizontal filter-date p-2 border bottom mb-2">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group form-group-sm row text-sm mb-0">
                <label for="filter_date" class="col-md-1 col-form-label">Filter</label>
                <div class="col-md-3">
                  <select name="kategori_id" class="form-control form-control-sm kategori_id">
                    <option value="">- Semua -</option>
                    @foreach ($kategori as $k)
                      <option value="{{ $k->kategori_id }}">{{ $k->kategori_nama }}</option>
                    @endforeach
                  </select>
                  <small class="form-text text-muted">Kategori Barang</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }} </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }} </div>
        @endif
        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang"> 
          <thead> 
            <tr><th>ID</th><th>Kode Barang</th><th>Nama Barang</th><th>Harga Beli</th><th>Harga Jual</th><th>Kategori Barang</th><th>Aksi</th></tr> 
          </thead> 
      </table> 
    </div> 
  </div>
  <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div>
@endsection 

@push('css') 
@endpush 

@push('js') 
<script>
    function modalAction(url = ''){
      $('#myModal').load(url,function(){
        $('#myModal').modal('show');
      });
    }
  
    var tableBarang;
    $(document).ready(function() { 
      tableBarang = $('#table_barang').DataTable({ 
        processing: true,
        serverSide: true,      
        ajax: { 
          "url": "{{ url('barang/list') }}", 
          "dataType": "json", 
          "type": "POST",
          "data": function (d){
            // Mengambil nilai dari dropdown filter
            d.kategori_id = $('.kategori_id').val();
          }
        }, 
        columns: [ 
          { 
            data: "DT_RowIndex",             
            className: "text-center",
            width: "5%",
            orderable: false, 
            searchable: false     
          },
          { 
            data: "barang_kode",                
            className: "",
            width: "10%",
            orderable: true,     
            searchable: true     
          },
          { 
            data: "barang_nama",                
            className: "",
            width: "30%",
            orderable: true,     
            searchable: true     
          },
          { 
            data: "harga_beli",                
            className: "",
            width: "10%",
            orderable: true,     
            searchable: false,
            render: function(data, type, row){
              return new Intl.NumberFormat('id-ID').format(data);
            }     
          },
          { 
            data: "harga_jual",                
            className: "",
            width: "10%",
            orderable: true,     
            searchable: false,
            render: function(data, type, row){
              return new Intl.NumberFormat('id-ID').format(data);
            }
          },
          { 
            data: "kategori.kategori_nama",                
            className: "",
            width: "14%",
            orderable: true,     
            searchable: false     
          },
          { 
            data: "aksi",                
            className: "text-center",
            width: "14%",
            orderable: false,     
            searchable: false
          } 
        ] 
      });
  
      // Filter pencarian ketika pengguna menekan enter
      $('#table-barang_filter input').unbind().bind().on('keyup', function(e){
        if(e.keyCode == 13){ // enter key
          tableBarang.search(this.value).draw();
        }
      });
  
      // Menambahkan event listener ketika dropdown kategori diubah
      $('.kategori_id').change(function() {
        tableBarang.draw();
      });
    }); 
  </script>   
@endpush