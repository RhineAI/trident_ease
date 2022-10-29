@extends('templates.layout')

@section('title')
<title>Keuntungan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Keuntungan
@endsection

@section('breadcrumb')
@parent
Keuntungan
@endsection

@push('styles')

@endpush

@section('contents')

<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
              <h3 class="text-center mt-3 mb-5">Set Keuntungan</h3>
                <div class="box-body table-responsive d-flex">
                    <div class="col-lg-12 justify-content-center" >
                        <form action="" method="POST">
                            @csrf
                            <div id="method"></div>
                            <div class="form-group row">
                                <div class="form-group row" style="width: 95%; margin: auto;">
                                    <label for="keuntungan">Persentase Keuntungan</label>
                                    <div class="input-group">
                                      <input type="number" min="1" max="100" maxlength="3" class="form-control" id="keuntungan" placeholder="Jumlah keuntungan yang ingin anda ambil" name="keuntungan">
                                      <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">%<span>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="id_kategori">Target Kategori</label>
                                    <select class="form-control" name="id_kategori" id="id_kategori">
                                        <option value="" disabled="disabled" selected="true">Pilih Kategori</option>
                                        <option value="semua">Semua Kategori</option>
                                        @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group" style="width: 95%; margin: auto;">
                                    <label for="id_merek">Target Merek</label>
                                    <select class="form-control" name="id_merek" id="id_merek">
                                        <option value="" disabled="disabled" selected="true">Pilih Merek</option>
                                        <option value="semua">Semua Merek</option>
                                        @foreach ($merek as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mt-4" id="btn-submit" style="margin-left: 0.25rem;">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection