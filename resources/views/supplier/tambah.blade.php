@extends('templates.layout')

@section('title')
    <title>Supplier | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Supplier
@endsection

@section('breadcrumb')
@parent
    Supplier
@endsection

@push('styles')
    
@endpush

@section('contents')
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Supplier</h3>
  
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
            <form action="" method="POST">
                @csrf
                <div id="method"></div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama">Nama Supplier</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Supplier" name="nama">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="alamat">Alamat Supplier</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="3" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tlp">Telepon</label>
                        <input type="text" class="form-control" id="tlp" placeholder="Telepon" name="tlp">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="salesman">Salesman</label>
                        <input type="text" class="form-control" id="salesman" placeholder="Salesman" name="salesman">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="bank">Bank</label>
                        <input type="text" class="form-control" id="bank" placeholder="Bank" name="bank">
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="no_rekening">No Rekening</label>
                        <input type="number" class="form-control" id="no_rekening" placeholder="No Rekening" name="no_rekening">
                    </div>
                </div>
                <input type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
                <button type="submit" class="btn btn-primary mt-2" id="btn-submit" style="margin-left: 0.25rem;">Simpan Data</button>
            </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection