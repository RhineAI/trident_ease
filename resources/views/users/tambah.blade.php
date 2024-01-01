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

            <form action="" method="POST" id="formPegawai">
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
                        <small id="messageTrue" class="text-success">Username Tersedia</small>
                        <small id="messageFalse" class="text-danger">Username Telah Digunakan</small>
                        <input type="hidden" id="check">
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
                <div class="form-group row mb-4">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="hak_akses">Hak Akses User</label>
                      <select class="form-control" name="hak_akses" id="hak_akses">
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

        @if(auth()->user()->hak_akses == 'admin') 
            var routeM = "{{ route('admin.getUsername') }}";
        @elseif(auth()->user()->hak_akses == 'owner') 
            var routeM = "{{ route('owner.getUsername') }}";
        @endif
        
        $('#messageTrue').hide()
        $('#messageFalse').hide()

        $('#username').on('change', function(){
            $('#btn-submit').attr('disabled', 'disabled')

            $.ajax({
                type: 'POST',
                url: routeM,
                data: {
                    _token: "{{ csrf_token() }}",
                    username: $('#username').val()
                },
                cache: false,
                success: function(response){
                    // $('#btn-submit').removeAttr('disabled')
                    // console.log(response)
                    if(response === 'true'){
                        $('#messageTrue').show()
                        $('#messageFalse').hide()
                        $('#check').val("true")
                        $('#btn-submit').removeAttr('disabled')
                    } else {
                        $('#messageFalse').show()
                        $('#messageTrue').hide()
                        $('#check').val("false")
                    }
                }
            })
        });


        $('#formPegawai').on('submit', function(){
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const tlp = $('#tlp').val()
            const salesman = $('#salesman').val()
            const jenis_kelamin = $('#jenis_kelamin').val()
            const username = $('#username').val()
            const password = $('#password').val()
            const password_confirmation = $('#password_confirmation').val()
            const hak_akses = $('#hak_akses').val()
            const check = $('#check').val()
            
            if(nama == "") {
                Swal.fire('Nama Pegawai Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            if(alamat == "") {
                Swal.fire('Alamat Pegawai Harus Diisi!')
                return false;
            } else {
                $('#alamat').val();
            }

            if(tlp == "") {
                Swal.fire('Telepon Pegawai Harus Diisi!')
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

            if(username == "") {
                Swal.fire('Username Harus Diisi!')
                return false;
            } else {
                $('#username').val();
            }

            if(password == "") {
                Swal.fire('Password Harus Diisi!')
                return false;
            } else {
                $('#password').val();
            }

            if(password_confirmation == "") {
                Swal.fire('Konfirmasi Password Harus Diisi!')
                return false;
            } else {
                $('#password_confirmation').val();
            }

            if(hak_akses == "") {
                Swal.fire('Hak Akses Harus Diisi!')
                return false;
            } else {
                $('#hak_akses').val();
            }

            if(check === "false") {
                Swal.fire('Username telah digunakan!')
                return false;
            } else {
                $('#check').val();
            }
        })
    </script>
@endpush