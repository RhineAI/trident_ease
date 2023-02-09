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
            <h3 class="card-title">Form Pegawai</h3>
          </div>
          
          @if ($errors->any())
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
          <div class="card-body">

            <form action="" method="POST">
                @csrf
                <div id="method"></div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Pegawai" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="alamat">Alamat Pegawai</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="3" rows="4" required></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tlp">Telepon</label>
                        <input type="text" class="form-control" id="tlp" placeholder="Telepon" name="tlp" required>
                    </div>
                </div>
                <div class="form-group row">
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
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
                    </div>
                </div>
                <div class="form-group row" id="hpsPassword">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="password">Password</label>
                      <input type="password" minlength="6" class="form-control" id="password" placeholder="Password" name="password" required>
                  </div>
              </div>
              <div class="form-group row" id="hpsPassword2">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="password_confirmation">Ketik Ulang Password</label>
                      <input type="password" minlength="6" class="form-control" id="password_confirmation" placeholder="Password" name="password_confirmation" required>
                  </div>
              </div>
                <div class="form-group row mb-4">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="hak_akses">Hak Akses User</label>
                      <select class="form-control" name="hak_akses" id="hak_akses" required>
                          <option value="" disabled="disabled" selected="true">Choose Hak Akses User</option>
                          <option value="admin">Administrator</option>
                          <option value="kasir">Kasir</option>
                          {{-- <option value="owner">Owner</option> --}}
                      </select>
                  </div>
                </div>
                <input type="hidden" name="id_perusahaan" value="{{ $cPerusahaan->id }}">
                <button type="submit" class="btn btn-primary mt-2" id="btn-submit" style="margin-left: 1rem;">Simpan Data</button>
            </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $('#nama').on('keypress', function(e){
            restrictChar(e);
        });
        $('#alamat').on('keypress', function(e){
            restrictChar(e);
        });
        $('#username').on('keypress', function(e){
            restrictChar(e);
        });
        $('#tlp').on('keypress', function(e){
            restrictWord(e);
        });
    </script>
@endpush