@extends('templates.layout')

@section('title')
<title>Profile | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Profile
@endsection

@section('breadcrumb')
@parent
Profile
@endsection

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive">
                    <h2 class="text-center mt-3 mb-5">Data Pegawai</h2>
                    <div class="col-lg-10" style="margin: 0 auto">
                        <form action="" method="POST">
                            @csrf
                            <div class="form-group row">
                                <label for="nama">Nama Pegawai</label>
                                <input type="text" class="form-control" id="nama" placeholder="Nama Pegawai" name="nama" value="{{ auth()->user()->nama }}">
                            </div>
                            <div class="form-group row">
                                <label for="alamat">Alamat Pegawai</label>
                                <textarea class="form-control" name="alamat" id="alamat" cols="4" rows="3">{{ auth()->user()->alamat }}</textarea>
                            </div>
                            <div class="form-group row">
                                    <label for="tlp">Telepon</label>
                                    <input type="text" class="form-control" id="tlp" placeholder="Telepon" name="tlp" value="{{ auth()->user()->tlp }}">
                            </div>
                            <div class="form-group row">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" placeholder="Username"  name="username" value="{{ auth()->user()->username }}">
                            </div>
                            <div class="form-group row" id="hpsPassword">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                            </div>
                            <button type="submit" class="btn btn-outline-success my-3" id="btn-submit" style="float:right; margin-right:0.3rem;">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@endsection