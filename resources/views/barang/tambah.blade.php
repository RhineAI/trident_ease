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
            <form action="" method="POST" id="formBarang">
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
                        <div class="input-group-prepend input-primary"> 
                            <span class="input-group-text">RP.</span> 
                            <input type="text" class="form-control" id="harga_beli" placeholder="Harga Beli Barang" name="harga_beli">
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="keuntungan">Keuntungan Barang</label>
                        <div class="input-group-prepend input-primary"> 
                            <input type="number" min="1" max="100" class="form-control" id="keuntungan" placeholder="Keuntungan Barang" name="keuntungan">
                            <span class="input-group-text">%</span> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="harga_jual">Harga Jual Barang</label>
                        <div class="input-group-prepend input-primary"> 
                            <span class="input-group-text">RP.</span> 
                            <input type="number" class="form-control" id="harga_jual" readonly> 
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="keterangan">Keterangan Barang</label>
                        {{-- <input type="text" class="form-control" id="keterangan" placeholder="Keterangan Barang" name="keterangan"> --}}
                        <select class="form-control" name="keterangan" id="keterangan">
                            <option value="" disabled="disabled" selected="true" value="">Pilih Jenis Produk</option>
                            <option value="utama">Produk Utama</option>
                            <option value="konsinyasi">Produk Konsinyasi</option>
                        </select>
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
@push('scripts')
    <script>
        $('#formBarang').on('submit', function(){
            const nama = $('#nama').val()
            const barcode = $('#barcode').val()
            const kode = $('#kode').val()
            const id_kategori = $('#id_kategori').val()
            const id_satuan = $('#id_satuan').val()
            const id_supplier = $('#id_supplier').val()
            const id_merek = $('#id_merek').val()
            const stock = $('#stock').val()
            const stock_minimal = $('#stock_minimal').val()
            const harga_beli = $('#harga_beli').val()
            const keuntungan = $('#keuntungan').val()
            const status = $('#status').val()
            const keterangan = $('#keterangan').val()

            if(nama == "") {
                Swal.fire('Nama Produk Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            // if(barcode == "") {
            //     Swal.fire('Barcode Barang Harus Diisi!')
            //     return false;
            // } else {
            //     $('#barcode').val();
            // }

            if(kode == "") {
                Swal.fire('Kode Barang Harus Diisi!')
                return false;
            } else {
                $('#kode').val();
            }

            if(id_kategori == null) {
                Swal.fire('Kategori Harus Diisi!')
                return false;
            } else {
                $('#id_kategori').val();
            }

            if(id_satuan == null) {
                Swal.fire('Satuan Harus Diisi!')
                return false;
            } else {
                $('#id_satuan').val();
            }

            if(id_supplier == null) {
                Swal.fire('Supplier Harus Diisi!')
                return false;
            } else {
                $('#id_supplier').val();
            }

            if(id_merek == null) {
                Swal.fire('Merek Harus Diisi!')
                return false;
            } else {
                $('#id_merek').val();
            }

            if(stock == "") {
                Swal.fire('Stock Harus Diisi!')
                return false;
            } else {
                $('#stock').val();
            }

            if(stock_minimal == "") {
                Swal.fire('Stock Minimal Harus Diisi!')
                return false;
            } else {
                $('#stock_minimal').val();
            }

            if(harga_beli == "") {
                Swal.fire('Harga Beli Harus Diisi!')
                return false;
            } else {
                $('#harga_beli').val();
            }

            if(keuntungan == "") {
                Swal.fire('Keuntungan Harus Diisi!')
                return false;
            } else {
                $('#keuntungan').val();
            }

            if(status == null) {
                Swal.fire('Status Harus Diisi!')
                return false;
            } else {
                $('#status').val();
            }

            if(keterangan == null) {
                Swal.fire('Keterangan Harus Diisi!')
                return false;
            } else {
                $('#keterangan').val();
            }
        })

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

        function roundToThousands(value) {
    	    return Math.ceil(value / 1000) * 1000;
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
                $("#harga_jual").val(roundToThousands(hj))
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
                $("#harga_jual").val(roundToThousands(hj))
        });
    </script>
@endpush