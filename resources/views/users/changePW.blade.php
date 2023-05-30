@extends('templates.layout')

@section('title')
<title>Ganti Password | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Ganti Password
@endsection

@section('breadcrumb')
@parent
Ganti Password
@endsection

@section('contents')
<section class="content">
  <div class="row mx-3">
      <div class="col-md-12 p-2 mb-3" style="background-color: white">
          <div class="box mb-4">
              <div class="box-body table-responsive">
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
                  <h2 class="text-center mt-3 mb-5">Ganti Password</h2>
                  
                  <div class="col-lg-10" style="margin: 0 auto">
                      <form action="" method="POST">
                        @csrf
                        <div class="form-group row" id="hpsPassword">
                            <label for="password">Password Lama</label>
                            <input type="password" class="form-control" id="password" placeholder="Password Lama" name="password">
                        </div>
                        <div class="form-group row" id="hpsPassword">
                            <label for="new_password">Password Baru</label>
                            <input type="password" class="form-control" id="new_password" placeholder="Password Baru" name="new_password">
                        </div>
                        <div class="form-group row" id="hpsPassword">
                            <label for="new_password_confirmation">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" placeholder="Konfirmasi Password Baru" name="new_password_confirmation">
                        </div>
                        <div class="btn"  style="float:right; margin-left: 2rem">
                          <button type="submit" class="btn btn-outline-success" id="btn-submit">Simpan Data</button>
                        </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  </div>
</section>
@endsection

@push('scripts')
    <script>
        $('#btn-submit').on('click', function(){   
            // Mengambil value / isi dari tiap inputan
            let password = $('#password').val();
            let new_password = $('#new_password').val();
            let new_password_confirmation = $('#new_password_confirmation').val();

            if(password == "") {
                Swal.fire('Isi password untuk mengubah profile')
                return false;
            } else {
                $('#password').val();
            }

            if(new_password == "") {
                Swal.fire('Isi password baru untuk mengubah profile')
                return false;
            } else {
                $('#new_password').val();
            }

            if(new_password_confirmation == "") {
                Swal.fire('Isi konfirmasi password baru untuk mengubah profile')
                return false;
            } else {
                $('#new_password_confirmation').val();
            }
        })
    </script>
@endpush