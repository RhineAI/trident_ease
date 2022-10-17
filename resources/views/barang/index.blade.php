


@extends('templates.layout')

@push('styles')
    
@endpush

@section('title')
  <title>Barang Page | {{ $cPerusahaan->nama }}</title>
@endsection

@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Barang Page</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Barang Page</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Barang</h3>
  
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
                <!-- Button trigger modal -->
                @if(session('success'))
                    <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                @endif
                @if(session('delete'))
                    <div class="alert alert-danger" role="alert" id="success-danger">
                    {{ session('delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModalBarang">
                    <i class="fas fa-plus"></i>&nbsp; Tambah Data
                </button>
                <br><br>
                <div>
                    @include('barang.form')
                </div>
                <div style="width: 100%;">
                    @include('barang.data')
                </div>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $('#tbl-data-barang').DataTable({
          scrollX: true,
        });
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalBarang').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_barang = btn.data('id_barang')
            const kode = btn.data('kode')
            const nama_barang = btn.data('nama_barang')
            const barcode = btn.data('barcode')
            const tebal = btn.data('tebal')
            const panjang = btn.data('panjang')
            const id_kategori = btn.data('id_kategori')
            const id_supplier = btn.data('id_supplier')
            const id_satuan = btn.data('id_satuan')
            const id_merek = btn.data('id_merek')
            const id_perusahaan = btn.data('id_perusahaan')
            const stock = btn.data('stock')
            const stock_minimal = btn.data('stock_minimal')
            const harga_beli = btn.data('harga_beli')
            const keuntungan = btn.data('keuntungan')
            const keterangan = btn.data('keterangan')
            const status = btn.data('status')
            const mode = btn.data('mode')
            const modal = $(this)
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data barang")
                modal.find('.modal-body #kode').val(kode)
                modal.find('.modal-body #nama').val(nama_barang)
                modal.find('.modal-body #barcode').val(barcode)
                modal.find('.modal-body #tebal').val(tebal)
                modal.find('.modal-body #panjang').val(panjang)
                modal.find('.modal-body #id_kategori').val(id_kategori)
                modal.find('.modal-body #id_supplier').val(id_supplier)
                modal.find('.modal-body #id_satuan').val(id_satuan)
                modal.find('.modal-body #id_merek').val(id_merek)
                modal.find('.modal-body #id_perusahaan').val(id_perusahaan)
                modal.find('.modal-body #stock').val(stock)
                modal.find('.modal-body #stock_minimal').val(stock_minimal)
                modal.find('.modal-body #harga_beli').val(harga_beli)
                modal.find('.modal-body #keuntungan').val(keuntungan)
                modal.find('.modal-body #keterangan').val(keterangan)
                modal.find('.modal-body #status').val(status)
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/barang/' + id_barang)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                modal.find('#modal-title').text("Tambah Data barang")
                modal.find('.modal-body #id_barang').val('')
                modal.find('.modal-body #nama_barang').val('')
                modal.find('.modal-footer #btn-submit').text('Submit')
                modal.find('.modal-body #method').html('')
            }
          });
        });
      </script>
      <script>
          $('.delete-data').on('click', function(e){
            e.preventDefault();
            Swal.fire({
            title: 'Apakah Kamu Yakin Menghapus Data Ini?',
            text: "Data tidak akan bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus data ini!'
            }).then((result) => {
            if (result.isConfirmed) {
                $(e.target).closest('form').submit()
            } else {
                swal.close()
            }
            })
          });
      </script>
@endpush