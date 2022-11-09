@extends('templates.layout')

@section('title')
<title>Perusahaan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Perusahaan
@endsection

@section('breadcrumb')
@parent
Perusahaan
@endsection

@push('styles')

@endpush

@section('contents')
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
              <h3 class="text-center mt-3 mb-5">Set Perusahaan</h3>
                <div class="box-body table-responsive d-flex">
                    <div class="col-lg-12 justify-content-center" >
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $cPerusahaan->id }}">
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="nama">Nama Perusahaan</label>
                                    <input type="text" class="form-control" id="nama" placeholder="Nama Perusahaan" name="nama"
                                        value="{{ $cPerusahaan->nama }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="alamat">Alamat Perusahaan</label>
                                    <textarea type="text" class="form-control" id="alamat" placeholder="Alamat Perusahaan" cols="6" rows="3"
                                        name="alamat" value="">{{ $cPerusahaan->alamat }}</textarea>
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group col-md-5" style="width: 95%; margin: auto;">
                                    <label for="pemilik">Pemilik Perusahaan</label>
                                    <input type="text" class="form-control" id="pemilik" placeholder="Pemilik Perusahaan"
                                        name="pemilik" value="{{ $cPerusahaan->pemilik }}">
                                </div>
                                <div class="form-group col-md-6" style="width: 95%; margin: auto;">
                                    <label for="tlp">Telepon Perusahaan</label>
                                    <input type="number" class="form-control" id="tlp" placeholder="Telepon Perusahaan" name="tlp"
                                        value="{{ $cPerusahaan->tlp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group col-md-5" style="width: 95%; margin: auto;">
                                    <label for="email">Email Perusahaan</label>
                                    <input type="email" class="form-control" id="email" placeholder="Email Perusahaan" name="email"
                                        value="{{ $cPerusahaan->email }}">
                                </div>
                                <div class="form-group col-md-6" style="width: 95%; margin: auto;">
                                    <label for="npwp">NPWP Perusahaan</label>
                                    <input type="text" class="form-control" id="npwp" placeholder="NPWP Perusahaan" name="npwp"
                                        value="{{ $cPerusahaan->npwp }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group col-md-5" style="width: 95%; margin: auto;">
                                    <label for="bank">Bank Perusahaan</label>
                                    <input type="text" class="form-control" id="bank" placeholder="Bank Perusahaan" name="bank"
                                        value="{{ $cPerusahaan->bank }}">
                                </div>
                                <div class="form-group col-md-6" style="width: 95%; margin: auto;">
                                    <label for="no_rekening">No Rekening Perusahaan</label>
                                    <input type="text" class="form-control" id="no_rekening" placeholder="No Rekening Perusahaan"
                                        name="no_rekening" value="{{ $cPerusahaan->no_rekening }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="slogan">Slogan Perusahaan</label>
                                    <input type="text" class="form-control" id="slogan" placeholder="Slogan Perusahaan"
                                        name="slogan" value="{{ $cPerusahaan->slogan }}">
                                </div>
                            </div>
            
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="file">Logo Sebelumnya</label>
                                    <br>
                                    <img src="{{ $cPerusahaan->logo }}" alt="{{ $cPerusahaan->nama }}" width="200">
                                    <input type="file" name="logo" id="file" style="display: none;" class="form-control">
            
                                </div>
                                <div class="col-md-6">
                                    <label>Logo Baru | <a href="#" id="fileSelect">Pilih Logo Baru</a></label>
                                    <div id="fileDisplay" style="margin-top: 15px;">
                                        <i style="font-size:14px;">Logo Baru Belum Dipilih</i>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1 mt-2"></div>
                            <button type="button" id="tombol" class="btn btn-primary" style="display: none; margin-left: 0,25rem; margin-right: 10px;">Reset Image</a>
                            <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script src="/assets/js/previewImage.js"></script>
@endpush