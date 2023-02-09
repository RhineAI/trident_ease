@extends('templates.layout')

@section('title')
    <title>Produk Utama | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Produk Utama
@endsection

@section('breadcrumb')
@parent
    Produk Utama
@endsection

@push('styles')
    
@endpush

@section('contents')
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Form Barang</h3>
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
                        <input type="text" class="form-control" id="kode" placeholder="Kode Barang" name="kode" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Barang" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="barcode">Barcode Barang</label>
                        <input type="text" class="form-control" id="barcode" placeholder="Barcode Barang" name="barcode" required>
                    </div>
                </div>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_kategori">Kategori Barang</label>
                    <select class="form-control" name="id_kategori" id="id_kategori" required>
                        <option value="" disabled="disabled" selected="true">Choose Category</option>
                        @foreach($categories as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_supplier">Supplier Barang</label>
                    <select class="form-control" name="id_supplier" id="id_supplier" required>
                        <option value="" disabled="disabled" selected="true">Choose Supplier</option>
                        @foreach($supplier as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_satuan">Satuan Barang</label>
                    <select class="form-control" name="id_satuan" id="id_satuan" required>
                        <option value="" disabled="disabled" selected="true">Choose Satuan</option>
                        @foreach($satuan as $item)
                        <option value="{{$item->id}}">{{$item->nama}}</option>
                        @endforeach
                    </select>
                </div>
                <br>
                <div class="form-group" style="width: 97%; margin: auto;">
                    <label for="id_merek">Merek Barang</label>
                    <select class="form-control" name="id_merek" id="id_merek" required>
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
                        <input type="number" class="form-control" id="stock" placeholder="Stock Barang" name="stock" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="stock_minimal">Stock Minimal Barang</label>
                        <input type="number" class="form-control" id="stock_minimal" placeholder="Stock Minimal Barang" name="stock_minimal" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="harga_beli">Harga Beli Barang</label>
                        <div class="input-group-prepend input-primary"> 
                            <span class="input-group-text">RP.</span> 
                            <input type="number" class="form-control" id="harga_beli" placeholder="Harga Beli Barang" name="harga_beli" required>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="keuntungan">Keuntungan Barang</label>
                        <div class="input-group-prepend input-primary"> 
                            <input type="number" min="1" max="100" class="form-control" id="keuntungan" placeholder="Keuntungan Barang" name="keuntungan" required>
                            <span class="input-group-text">%</span> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="harga_jual">Harga Jual Barang</label>
                        <div class="input-group-prepend input-primary"> 
                            <span class="input-group-text">RP.</span> 
                            <input type="number" class="form-control" id="harga_jual" required readonly> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="keterangan">Keterangan Barang</label>
                        {{-- <input type="text" class="form-control" id="keterangan" placeholder="Keterangan Barang" name="keterangan" required> --}}
                        <select class="form-control" name="keterangan" id="keterangan" required>
                            <option value="" disabled="disabled" selected="true">Pilih Jenis Produk</option>
                            <option value="utama">Produk Utama</option>
                            <option value="konsinyasi">Produk Konsinyasi</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="status">Status Barang</label>
                        <select class="form-control" name="status" id="status" required>
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
@push('scripts')
    <script>
        $('#product_name').on('keypress', function(e){
            restrictChar(e);
        });
        $('#barcode').on('keypress', function(e){
            restrictChar(e);
        });
        $('#kode').on('keypress', function(e){
            restrictChar(e);
        });
        $('#stock').on('keypress', function(e){
            restrictWord(e);
        });
        $('#stock_minimal').on('keypress', function(e){
            restrictWord(e);
        });
        $('#harga_beli').on('keypress', function(e){
            restrictWord(e);
        });
        $('#keuntungan').on('keypress', function(e){
            restrictWord(e);
        });
    </script>
    <script>
        function formatRupiah(angka, prefix){
        var number_string   = angka.replace(/[^,\d]/g, '').toString(),
        split               = number_string.split(','),
        sisa                = split[0].length % 3,
        rupiah              = split[0].substr(0, sisa),
        ribuan              = split[0].substr(sisa).match(/\d{3}/gi);

        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }

        function generateRupiah(elemValue) {
            return $(elemValue).val(formatRupiah($(elemValue).val(), 'Rp. '))
        }

        $(document).on('keyup', '#harga_beli', function(e){
            generateRupiah(this);
        })

        $(document).on('keyup', '#harga_beli', function (e) {
                var keuntungan = $("#keuntungan").val();
                var hj;
                var hb = String($(this).val()).replaceAll(".", '');

                if(keuntungan == 0){
                    hj = hb;
                } else if(keuntungan > 0){
                    hj = parseFloat(hb) + parseFloat(hb) * keuntungan/100;
                }
                $("#harga_jual").val(hj)
        });

        $(document).on('keyup', '#keuntungan', function (e) {
                var keuntungan = $(this).val();
                var hb = String($("#harga_beli").val()).replaceAll(".", '');
                var hj;
                console.log(hb)

                if(hb == 0){
                    hj = 0 * keuntungan;
                } else if(hb > 0){
                    hj = parseFloat(hb) + parseFloat(hb) * keuntungan/100;
                }
                $("#harga_jual").val(hj)
        });
    </script>
@endpush