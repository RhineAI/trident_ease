@extends('templates.layout')

@push('styles')
    
@endpush

@section('title')
  <title>Change Password Page | {{ $cPerusahaan->nama }}</title>
@endsection

@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Change Password Page</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Change Password Page</li>
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
            <h3 class="card-title">Change Password</h3>
  
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
            @if(session('success'))
              <div class="alert alert-success" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </div>
            @endif
            @if(session('error'))
              <div class="alert alert-danger" role="alert" id="danger-alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </div>
            @endif
            <form action="" method="POST">
                @csrf
                <div class="form-group row" id="hpsPassword">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="password">Password Lama</label>
                      <input type="password" class="form-control" id="password" placeholder="Password Lama" name="password">
                  </div>
                </div>
                <div class="form-group row" id="hpsPassword">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="new_password">Password Baru</label>
                      <input type="password" class="form-control" id="new_password" placeholder="Password Baru" name="new_password">
                  </div>
                </div>
                <div class="form-group row" id="hpsPassword">
                  <div class="form-group" style="width: 95%; margin: auto;">
                      <label for="new_password_confirmation">Password Baru</label>
                      <input type="password" class="form-control" id="new_password_confirmation" placeholder="Password Baru" name="new_password_confirmation">
                  </div>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-submit" style="margin-left: 1rem;">Simpan Data</button>
            </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection