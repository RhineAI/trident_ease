@extends('templates.layout')

@section('title')
    <title>Pembelian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pembelian
@endsection

@section('breadcrumb')
@parent
    Pembelian
@endsection

@push('styles')
    
@endpush


@section('contents')
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pembelian</h3>
  
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
                <a href="{{ route('admin.pembelian.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>&nbsp; Tambah Data
                </a>
                <br><br>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $('#tbl-data-pembelian').DataTable();
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalPembelian').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const mode = btn.data('mode')
            const modal = $(this)
        
            modal.find('#modal-title').text("Pilih Supplier")
            modal.find('.modal-body #method').html('')
            
          });
        });
      </script>
@endpush