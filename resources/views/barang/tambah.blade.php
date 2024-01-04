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
    <section class="content">
        <div class="card">
          <div class="card-header">
            <h1 class="card-title">Form Barang</h1>
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
                    <label for="nama" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Nama</h6>
                    </label>
                    <div class="col-md-4">
                        <input type="text" name="nama" id="nama" class="form-control"autofocus>
                        <span class="help-block with-errors"></span>
                    </div>

                    <label for="kode" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Kode</h6>
                    </label>
                    <div class="col-md-4">
                        <input type="text" name="kode" id="kode" class="form-control" placeholder="Contoh : 001 ">
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="barcode" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Barcode</h6>
                    </label>
                    <div class="col-md-4">
                        <input type="text" name="barcode" id="barcode" class="form-control">
                        <span class="help-block with-errors"></span>
                    </div>

                    <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Kategori</h6>
                    </label>
                    <div class="col-md-4">
                        <select name="id_kategori" id="id_kategori" class="form-control">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach ($categories as $item )
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_satuan" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Satuan</h6>
                    </label>
                    <div class="col-md-4">
                        <select name="id_satuan" id="id_satuan" class="form-control">
                            <option value="" disabled selected>Pilih Satuan</option>
                            @foreach ($satuan as $item )
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>

                    <label for="id_merek" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Merek </h6>
                    </label>
                    <div class="col-md-4">
                        <select name="id_merek" id="id_merek" class="form-control">
                            <option value="" disabled selected>Pilih Merek</option>
                            @foreach ($merek as $item )
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <hr>
                <h5 class="text-center my-2 mt-2 mb-5">Informasi Harga dan Stok</h5>

                <div class="form-group row">
                    <label for="harga_beli" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Harga Beli</h6>
                    </label>
                    <div class="input-group mb-3 col-md-5">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        </div>
                        <input type="text" name="harga_beli" autocomplete="off" id="harga_beli" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                    </div>

                    <label for="keuntungan" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Keuntungan</h6>
                    </label>
                    <div class="input-group mb-3 col-md-3">
                        <input max="100" maxlength="3" type="text" name="keuntungan" id="keuntungan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                        <div class="input-group-prepend">
                          <span class="input-group-text" id="basic-addon1">%<span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="harga_jual" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Harga Jual</h6>
                    </label>
                    <div class="input-group mb-3 col-md-5">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                        </div>
                        <input type="text" autocomplete="off" id="harga_jual" class="form-control" aria-label="Username" readonly aria-describedby="basic-addon1">
                    </div>

                    <label for="status" class="col-md-2 col-md-offset-1 control-label">
                        <h6 class="my-2">Status</h6>
                    </label>
                    <div class="col-md-3">
                        <select name="status" id="status" class="form-control">
                            <option value="1" selected>Aktif</option>
                            <option value="2">Tidak Aktif</option>
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="stock" class="col-md-1 control-label">
                        <h6 class="my-2">Stok </h6>
                    </label>
                    <div class="col-md-3">
                        <input type="number" name="stock" id="stock" class="form-control" autofocus>
                        <span class="help-block with-errors"></span>
                    </div>

                    <label for="stock_minimal" class="col-md-1 control-label" style="width: 12.19%; flex: 0 0 12.19%;max-width: 12.19%;">
                        <h6 class="my-2">Min. Stok</h6>
                    </label>
                    <div class="col-md-2" style="width: 21%; flex: 0 0 21%;max-width: 21%;">
                        <input type="number" name="stock_minimal" id="stock_minimal" class="form-control" autofocus>
                        <span class="help-block with-errors"></span>
                    </div>

                    <label for="keterangan" class="col-md-1 control-label">
                        <h6 class="my-2">Jenis</h6>
                    </label>
                    <div class="col-md-3">
                        <select name="keterangan" id="keterangan" class="form-control">
                            <option selected disabled value="">Pilih Produk</option>
                            <option value="utama">Produk Utama</option>
                            <option value="konsinyasi">Produk Konsinyasi</option>
                        </select>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <input type="text" class="form-control" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
                <button type="submit" class="btn btn-primary mr-3 my-3" id="btn-submit" style="float: right;">Simpan Data</button>
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
            // const id_supplier = $('#id_supplier').val()
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

        $(document).on('keyup change', '#keuntungan', function (e) {
            var keuntungan = $(this).val();

            if (keuntungan > 100) {
                keuntungan = 100
                $(this).val(100)
            }
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