


@extends('templates.layout')

@push('styles')
    
@endpush

@section('title')
  <title>Satuan Page | {{ $cPerusahaan->nama }}</title>
@endsection

@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Satuan Page</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Satuan Page</li>
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
            <h3 class="card-title">Data Satuan</h3>
  
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#formModalSatuan">
                    <i class="fas fa-plus"></i>&nbsp; Tambah Data
                </button>
                <br><br>
                <div>
                    @include('satuan.form')
                </div>
                <div>
                    @include('satuan.data')
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
        $('#tbl-data-satuan').DataTable();
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalSatuan').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_satuan = btn.data('id_satuan')
            const nama_satuan = btn.data('nama_satuan')
            const mode = btn.data('mode')
            const modal = $(this)
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data Satuan")
                modal.find('.modal-body #nama').val(nama_satuan)
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/satuan/' + id_satuan)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                modal.find('#modal-title').text("Tambah Data Satuan")
                modal.find('.modal-body #id_satuan').val('')
                modal.find('.modal-body #nama').val('')
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