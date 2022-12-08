@extends('templates.layout')

@section('title')
    <title>Pelanggan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pelanggan
@endsection

@section('breadcrumb')
@parent
    Pelanggan
@endsection

@push('styles')
    
@endpush

@section('contents')
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Form Pelanggan</h3>
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
                        <label for="nama">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Pelanggan" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="alamat">Alamat Pelanggan</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="3" rows="4" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tlp">Telepon</label>
                        <input type="text" class="form-control" id="tlp" placeholder="Telepon" name="tlp"  required>
                    </div>
                </div>
                <div class="form-group row mb-4">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin" required>
                            <option value="" disabled="disabled" selected="true">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                            <option value="Other">Lainnya</option>
                        </select>
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