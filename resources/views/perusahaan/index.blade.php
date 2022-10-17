


@extends('templates.layout')

@push('styles')
    
@endpush

@section('title')
  <title>Perusahaan Page | {{ $cPerusahaan->nama }}</title>
@endsection

@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Perusahaan Page</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Perusahaan Page</li>
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
            <h3 class="card-title">Data Perusahaan</h3>
  
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
                <form action="" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="id" value="{{ $cPerusahaan->id }}">
                  <div class="form-group row">
                      <div class="form-group" style="width: 95%; margin: auto;">
                          <label for="nama">Nama Perusahaan</label>
                          <input type="text" class="form-control" id="nama" placeholder="Nama Perusahaan" name="nama" value="{{ $cPerusahaan->nama }}">
                      </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="alamat">Alamat Perusahaan</label>
                        <input type="text" class="form-control" id="alamat" placeholder="Alamat Perusahaan" name="alamat" value="{{ $cPerusahaan->alamat }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tlp">Telepon Perusahaan</label>
                        <input type="text" class="form-control" id="tlp" placeholder="Telepon Perusahaan" name="tlp" value="{{ $cPerusahaan->tlp }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="pemilik">Pemilik Perusahaan</label>
                        <input type="text" class="form-control" id="pemilik" placeholder="Pemilik Perusahaan" name="pemilik" value="{{ $cPerusahaan->pemilik }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="bank">Bank Perusahaan</label>
                        <input type="text" class="form-control" id="bank" placeholder="Bank Perusahaan" name="bank" value="{{ $cPerusahaan->bank }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="no_rekening">No Rekening Perusahaan</label>
                        <input type="text" class="form-control" id="no_rekening" placeholder="No Rekening Perusahaan" name="no_rekening" value="{{ $cPerusahaan->no_rekening }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="npwp">NPWP Perusahaan</label>
                        <input type="text" class="form-control" id="npwp" placeholder="NPWP Perusahaan" name="npwp" value="{{ $cPerusahaan->npwp }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="slogan">Slogan Perusahaan</label>
                        <input type="text" class="form-control" id="slogan" placeholder="Slogan Perusahaan" name="slogan" value="{{ $cPerusahaan->slogan }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="email">Email Perusahaan</label>
                        <input type="email" class="form-control" id="email" placeholder="Email Perusahaan" name="email" value="{{ $cPerusahaan->email }}">
                    </div>
                  </div>
                  <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="file">Logo Sebelumnya | <a href="#" id="fileSelect">Pilih Logo Baru</a></label>
                      <br>
                      <img src="{{ $cPerusahaan->logo }}" alt="{{ $cPerusahaan->nama }}" width="200">
                      <input type="file" name="logo" id="file" style="display: none;" class="form-control">
                      
                      <br><br>
                      <label>Logo Baru</label>
                      <div id="fileDisplay" style="margin-top: 15px;">
                          <p>Logo Baru Belum Dipilih</p>
                      </div>
                    </div>
                  </div>
                  <button type="button" id="tombol" class="btn btn-primary" style="display: none; margin-left: 0,25rem; margin-right: 10px;">Reset Image</a>
                  <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
                </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
  <script src="/assets/js/previewImage.js"></script>
@endpush