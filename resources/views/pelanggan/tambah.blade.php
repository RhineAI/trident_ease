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
            <form action="" method="POST" id="formPelanggan">
                @csrf
                <div id="method"></div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Pelanggan" name="nama">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="alamat">Alamat Pelanggan</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="3" rows="4"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tlp">Telepon</label>
                        <input type="text" class="form-control" id="tlp" placeholder="Telepon" name="tlp" >
                    </div>
                </div>
                <div class="form-group row mb-4">
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

@push('scripts')
    <script>
        $('#nama').on('keypress', function(e){
            restrictChar(e);
        });
        $('#alamat').on('keypress', function(e){
            restrictChar(e);
        });
        $('#tlp').on('keypress', function(e){
            restrictWord(e);
        });

        $('#formPelanggan').on('submit', function(){
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const tlp = $('#tlp').val()
            const jenis_kelamin = $('#jenis_kelamin').val()

            if(nama == "") {
                Swal.fire('Nama Pelanggan Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            if(alamat == "") {
                Swal.fire('Alamat Pelanggan Harus Diisi!')
                return false;
            } else {
                $('#alamat').val();
            }

            if(tlp == "") {
                Swal.fire('Telepon Pelanggan Harus Diisi!')
                return false;
            } else {
                $('#tlp').val();
            }

            if(jenis_kelamin == null) {
                Swal.fire('Jenis Kelamin Harus Diisi!')
                return false;
            } else {
                $('#jenis_kelamin').val();
            }
        })
    </script>
@endpush