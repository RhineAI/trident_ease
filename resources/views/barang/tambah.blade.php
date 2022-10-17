@extends('templates.layout')

@push('styles')
    
@endpush

@section('title')
  <title>Barang Page | {{ $cPerusahaan->nama }}</title>
@endsection

@section('contents')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Barang Page</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active">Barang Page</li>
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
            <h3 class="card-title">Data Barang</h3>
  
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
            <form action="" method="POST">
                @csrf
                <div id="method"></div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="kode">Kode Barang</label>
                        <input type="text" class="form-control" id="kode" placeholder="Kode Barang" name="kode">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Barang" name="nama">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="barcode">Barcode Barang</label>
                        <input type="text" class="form-control" id="barcode" placeholder="Barcode Barang" name="barcode">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tebal">Tebal Barang</label>
                        <input type="text" class="form-control" id="tebal" placeholder="Tebal Barang" name="tebal">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="panjang">Panjang Barang</label>
                        <input type="text" class="form-control" id="panjang" placeholder="Panjang Barang" name="panjang">
                    </div>
                </div>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_kategori">Kategori Barang</label>
                    <select class="form-control" name="id_kategori" id="id_kategori">
                        <option value="" disabled="disabled" selected="true">Choose Category</option>
                        @foreach($categories as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_supplier">Supplier Barang</label>
                    <select class="form-control" name="id_supplier" id="id_supplier">
                        <option value="" disabled="disabled" selected="true">Choose Supplier</option>
                        @foreach($supplier as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_satuan">Satuan Barang</label>
                    <select class="form-control" name="id_satuan" id="id_satuan">
                        <option value="" disabled="disabled" selected="true">Choose Satuan</option>
                        @foreach($satuan as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_merek">Merek Barang</label>
                    <select class="form-control" name="id_merek" id="id_merek">
                        <option value="" disabled="disabled" selected="true">Choose Merek</option>
                        @foreach($merek as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <input type="text" class="form-control" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="stock">Stock Barang</label>
                        <input type="number" class="form-control" id="stock" placeholder="Stock Barang" name="stock">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="stock_minimal">Stock Minimal Barang</label>
                        <input type="number" class="form-control" id="stock_minimal" placeholder="Stock Minimal Barang" name="stock_minimal">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="harga_beli">Harga Beli Barang</label>
                        <input type="number" class="form-control" id="harga_beli" placeholder="Harga Beli Barang" name="harga_beli">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="keuntungan">Keuntungan Barang</label>
                        <input type="number" min="1" max="100" class="form-control" id="keuntungan" placeholder="Keuntungan Barang" name="keuntungan">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="keterangan">Keterangan Barang</label>
                        <input type="text" class="form-control" id="keterangan" placeholder="Keterangan Barang" name="keterangan">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="status">Status Barang</label>
                        <select class="form-control" name="status" id="status">
                            <option value="" disabled="disabled" selected="true">Choose Status</option>
                            <option value="1">Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="btn-submit" style="margin-left: 0.25rem;">Simpan Data</button>
            </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection