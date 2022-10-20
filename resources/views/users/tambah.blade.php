@extends('templates.layout')

@section('title')
    <title>Pegawai | {{ $cPerusahaan->nama }}</title>
@endsection

@section('breadcrumb')
@parent
    Pegawai
@endsection

@push('styles')
    
@endpush

@section('contents')

  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pegawai</h3>
  
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

            <form action="" method="POST">
                @csrf
                <div id="method"></div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Pegawai" name="nama">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="alamat">Alamat Pegawai</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10"></textarea>
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
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                            <option value="" disabled="disabled" selected="true">Pilih Jenis Kelamin</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                            <option value="Other">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username">
                    </div>
                </div>
                <div class="form-group row" id="hpsPassword">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="password">Password</label>
                      <input type="password" minlength="6" class="form-control" id="password" placeholder="Password" name="password">
                  </div>
              </div>
              <div class="form-group row" id="hpsPassword2">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="password_confirmation">Ketik Ulang Password</label>
                      <input type="password" minlength="6" class="form-control" id="password_confirmation" placeholder="Password" name="password_confirmation">
                  </div>
              </div>
                <div class="form-group row">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="hak_akses">Hak Akses User</label>
                      <select class="form-control" name="hak_akses" id="hak_akses">
                          <option value="" disabled="disabled" selected="true">Choose Hak Akses User</option>
                          <option value="1">Admnistrator</option>
                          <option value="2">Kasir</option>
                          {{-- <option value="owner">Owner</option> --}}
                      </select>
                  </div>
                </div>
                <input type="hidden" name="id_perusahaan" value="{{ $cPerusahaan->id }}">
                <button type="submit" class="btn btn-primary" id="btn-submit" style="margin-left: 1rem;">Simpan Data</button>
            </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection