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
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Keuntungan</h3>
  
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
                        <label for="keuntungan">Persen Keuntungan</label>
                        <div class='input-group-prepend input-primary'>
                          <input type="number" min="1" max="100" class="form-control" id="keuntungan" placeholder="Jumlah keuntungan yang ingin anda ambil" name="keuntungan"><span class='input-group-text'>%</span>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="id_kategori">Target Kategori</label>
                        <select class="form-control" name="id_kategori" id="id_kategori">
                            <option value="" disabled="disabled" selected="true">Choose Kategori</option>
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
                            <option value="" disabled="disabled" selected="true">Choose Merek</option>
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
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection