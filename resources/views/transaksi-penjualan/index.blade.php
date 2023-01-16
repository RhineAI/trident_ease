@extends('templates.layout')

@section('title')
    <title>Penjualan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Penjualan
@endsection

@section('breadcrumb')
@parent
    Penjualan
@endsection

@push('styles')
<style>
    .tampil-bayar {
        font-size: 3em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        color: white;
        background: #615d5d;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    .btn-simpan {
        float: right;
        margin-top: 10px;
        margin-right: 30px;
        margin-bottom: 40px;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('contents')
  
      <!-- Main content -->
      <section class="content">
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
        <div class="row mx-4">
            <div class="col-lg-12" style="background-color: white;">
                <div class="box-body">
        
                    <div class="box-body">

                            @if (Auth::user()->hak_akses == 'admin')
                                <form class="form-pelanggan mt-3" method="post" id="form-transaksi" action="">
                            @elseif (Auth::user()->hak_akses == 'kasir')
                                <form class="form-pelanggan mt-3" method="post" id="form-transaksi" action="{{ route('kasir.transaksi-penjualan.store') }}">
                            @endif
                                @csrf
                            <div class="form-group row">
                                <label for="nama_pelanggan" class="col-lg-2">Pelanggan</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="text" name="nama_pelanggan" required id="nama_pelanggan" class="form-control" required autofocus readonly>
                                        <span class="input-group-btn tampil-pelanggan">
                                            <button onclick="tampilPelanggan()" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tlp" class="col-lg-2">Telepon Pelanggan</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                                        <input type="text" name="tlp" id="tlp" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            
                            <div class="form-group row">
                                <label for="kode_produk" class="col-lg-2">Tambah Produk</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="hidden" required name="id_produk" id="id_produk">
                                        <input type="hidden" class="form-control" name="kode_produk" id="kode_produk">
                                        <input type="text"  name="barcode" id="barcode" class="form-control" required autofocus>
                                        <span class="input-group-btn tampil-produk">
                                            {{-- <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button> --}}
                                            <button onclick="tampilProduk()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                            <button onclick="enterProduk()" id="enter" class="btn btn-info btn-flat add_barang" type="button"><i class="fa-solid fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
        
                            <div class="table-responsive">
                                <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered dt-responsive" id="buffer_table">
                                    <thead>
                                    <tr width="90%">
                                            <th class="text-center" width="8.2%"> Kode</th>
                                            <th class="text-center" width="18%">Nama</th>
                                            <th class="text-center" width="12%">Harga</th>
                                            <th class="text-center" width="9%">Jumlah</th>
                                            <th class="text-center" width="10.7%">Diskon</th>
                                            <th class="text-center" width="13%">Subtotal</th>
                                            <th class="text-center" width="9%">Aksi</th>
                                    </tr>
                                    </thead>
                                    <tbody id="t_penjualan">
                                        <tr id="buffer100" height="50px">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
        
                            <div class="row mt-4">
                                <div class="col-lg-7">
                                    <div class="tampil-bayar bg-default mb-4" id="total_bayar_gede">RP. 0</div>
                                    <div class="tampil-terbilang"></div>
                                </div>
                                <div class="col-lg-5">
                                            <!-- TOTAL PENJUALAN  -->
                                        <input class="form-control" type="hidden" name="total_penjualan" data-bv-trigger="blur"
                                        id="total_penjualan" readonly="true">

                                        <input type="hidden" data-bv-trigger="blur" id="total_bayar" name="total_bayar" class="form-control" readonly>

                                        <div class="form-group row mt-4">
                                            <label for="inputEmail3" class="col-lg-3 control-label">Jenis Pembayaran</label>
                                            <div class="col-lg-8">
                                                <select class="form-control" name="jenis_pembayaran" data-bv-trigger="blur" id="jenis_pembayaran">
                                                    <option value="1" selected="selected">CASH</option>';
                                                    <option value="2">KREDIT</option>';
                                                </select>
                                            </div>
                                        </div>
                                
                                        {{-- <div class="form-group row mt-4">
                                            <label for="bayar" class="col-lg-3 control-label">Total</label>
                                            <div class="col-lg-8 ">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="text" data-bv-trigger="blur" id="total_bayar" name="total_bayar" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="form-group row mt-4" id="tampil_bayar">
                                            <label for="diterima" class="col-lg-3 control-label">Bayar</label>
                                            <div class="col-lg-8 ">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="text" data-bv-trigger="blur" id="bayar" name="bayar" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row mt-4" id="tampil_kembali">
                                            <label for="diterima" class="col-lg-3 control-label">Kembalian</label>
                                            <div class="col-lg-8 ">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="text" data-bv-trigger="blur" id="kembali" readonly name="kembali" class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>
            
                                        <div class="form-group row mt-4" id="tampil_dp">
                                            <label for="inputEmail3" class="col-lg-3 control-label">DP</label>
                                            <div class="col-lg-8 ">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="text" data-bv-trigger="blur" id="dp" name="dp" class="form-control" autocomplete="off">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mt-4" id="tampil_sisa">
                                            <label for="inputEmail3" class="col-lg-3 control-label">Sisa</label>
                                            <div class="col-lg-8 ">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="number" data-bv-trigger="blur" id="sisa" name="sisa" class="form-control" readonly value="0">
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="form-group row" style="display: none;" id="tampil_dp">
                                            <label for="inputEmail3" class="col-lg-3 control-label">DP</label>
                                            <div class="col-lg-8">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="text" id="dp" class="form-control" name="dp">
                                                </div>
                                            </div>
                                        </div> --}}
                    
                                        {{-- <div class="form-group" style="display: none;" id="tampil_sisa">
                                            <label for="inputEmail3" class="col-lg-3 control-label">SISA</label>
                                            <div class="col-lg-8">
                                                <div class="input-group-prepend input-primary"> 
                                                    <span class="input-group-text">RP.</span> 
                                                    <input type="text" id="sisa" class="form-control" name="sisa">
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="box-footer mb-4 btn-submit">
                                            <button type="submit" id="submit" class="btn btn-outline-primary btn-sm pull-right btn-simpan" onkeypress="preventEnter(this)"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        {{-- <div class="col-md-11"></div> --}}
                        {{-- <div class="box-footer mb-4 btn-submit">
                            <button type="submit" id="submit" class="col-md-3 btn btn-outline-primary btn-sm btn-simpan" onkeypress="preventEnter(this)"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                        </div> --}}
                </div>
            </div>  
        </div>
    </form>
  
        @include('transaksi-penjualan.formBarang')
        @include('transaksi-penjualan.formPelanggan')
      </section>
      <!-- /.content -->

      @includeIf('transaksi-penjualan.barang')
@endsection

@push('scripts')
    {{-- <script>
        //Generate custom message
        $(document).ready(function(){
            ('#form-transaksi').bootstrapValidator({
                message: 'Data yang di input tidak sesuai ketentuan',
                feedbackIcons: {
                    valid: 'fa-sollid fa-success',
                    invalid: 'fa-solid fa-x',
                    validating: 'fa-solid fa-arrows-rotate'
                },
                fields: {
                    nama_pelanggan: {
                        validators: {
                            notEmpty: {
                                message: 'Data harus diisi',
                            },						
                        },
                    },
                    id_pelanggan: {
                        validators: {
                            notEmpty: {
                                message: 'Data harus diisi'
                            }
                        }
                    },
                    bayar: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan jumlah uang terlebih dahulu'
                            },
                            regexp: {
                                regexp: /^[0-9 ()-]+$/i,
                                message: 'Data harus diisi angka',
                            }
                        }
                    },
                    dp: {
                        validators: {
                            notEmpty: {
                                message: 'Masukan jumlah dp terlebih dahulu'
                            },
                            regexp: {
                                regexp: /^[0-9 ()-]+$/i,
                                message: 'Data harus diisi angka',
                            }
                        }
                    }
                }
            });
        });
    </script> --}}
   

    <script>
        $(document).on('click', '#submit', function(){
            let id_pelanggan = $('#id_pelanggan').val();
            let produk = $('.produk').val();
            let jenis_pembayaran = $('#jenis_pembayaran').val();

            let tb = $("#total_bayar").val();
            let bayar = $('#bayar').val();
            let harga = String(bayar).replaceAll(".", '');

            let dp = $('#dp').val();
            let bayardp = String(dp).replaceAll(".", '');
            // console.log(tb)
            // console.log(bayardp)
            let sisa = tb - parseFloat(bayardp);
            let formatRupiah = Number(sisa).toLocaleString("id-ID", {
                                style:"currency",
                                currency:"IDR",
                                maximumSignificantDigits: (sisa + '').replace('.', '').length
                            });
            let ubah_int = formatRupiah.replace(/Rp/g, '');
            let sisabayar = ubah_int.replaceAll('.', '');
            // console.log(jenis_pembayaran)

            if(id_pelanggan == 0) {
                Swal.fire('Isi data pelanggan terlebih dahulu')
                return false;
            } else {
                $('#id_pelanggan').val();
            }

            if(produk == 0) {
                Swal.fire('Tambahkan produk terlebih dahulu')
                return false;
            } else {
                $('#id_produk').val();
            }
            
            if(jenis_pembayaran == 1) {
                if(bayar == 0) {
                    Swal.fire('Masukan jumlah uang bayar terlebih dahulu')
                    return false;
                } else {
                    if(parseFloat(harga) < tb) {
                        Swal.fire('Jumlah uang bayar kurang')
                        return false;
                    } else {
                        $('#bayar').val();
                    }    
                }
            }else{
                if(dp == 0) {
                    Swal.fire('Masukan jumlah uang dp terlebih dahulu')
                    return false;
                } else {
                    if(parseFloat(bayardp) > tb) {
                        Swal.fire('Jumlah dp melebihi total bayar, Silahkan ganti jenis pembayaran')
                        return false;
                    } else {
                        $('#dp').val();
                    }    
                }
            }          
        });
      

        $('body').addClass('sidebar-collapse');

        function enterProduk() {
            var barcode = $('#barcode').val();
            var enter = $('#enter').val(barcode);

            @if(auth()->user()->hak_akses == 'admin') 
                var routeM = "{{ route('admin.barcode.data') }}";
            @elseif(auth()->user()->hak_akses == 'kasir') 
                var routeM = "{{ route('kasir.barcode.data') }}";
            @endif 

            $.ajax({
                    type: 'POST',
                    url: routeM,
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    success: function(response){
                        // console.log(response)
                        $('#t_penjualan').html(response);
                    }
                })
        }

        function tampilProduk() {
            $('#formModalBarangPenjualan').modal('show');
            $('#tbl-data-barang-penjualan').DataTable();
        }

        function preventEnter(e){
            if(e.keyCode === 13){
                return false
            }
        }

        function hideProduk() {
            $('#formModalBarangPenjualan').modal('hide');
        }

        function tampilPelanggan() {
            $('#formModalPelangganPenjualan').modal('show');
            $('#tbl-data-pelanggan-penjualan').DataTable();
        }

        function hidePelanggan() {
            $('#formModalPelangganPenjualan').modal('hide');
        }

        //Validasi Submit

            function cekDiscount(qty) {
                if(Number(qty.value) < 0){
                    qty.value = 0; 
                } else if(Number(qty.value) > 100) {
                    qty.value = 100;
                } else {
                    qty.value = qty.value;
                }
            }

            function cekQty(stock) {
                    // console.log(stock)
                    let id = stock.getAttribute("data-idbuffer");
                    // let qty = $('#qty' + id).val();
                    let discount = $('#discount' + id).val();
                    let harga_jual = $('#harga_jual' + id).val();
                    // console.log(harga_jual)
                    // console.log(discount)
                    


                    // console.log(cek)
                    if(Number(stock.value) < 0){
                        stock.value = 1;
                    } else if (Number(stock.value) > Number(stock.max)){
                        stock.value = stock.max;
                        // $('#subtotal' + id).val((harga_jual * stock.max) - discount/100);
                        // GetTotalBayar();
                        Swal.fire('QTY melebihi stock yang tersedia!')
                        return false;
                    } else {
                        stock.value = stock.value;
                    }
                }

           


        $(document).ready(function(){
            var subtotal=0;
            var discount=0;
            var total=0;
            var count=0;

            $('div#tampil_dp').hide();
            $('div#tampil_sisa').hide();

            $(document).on('change', '#jenis_pembayaran', function () {  
                var isiJenis = $("#jenis_pembayaran").val();
                if (isiJenis == '1') {
                    $("#bayar").val(0);
                    $("#kembali").val(0);
                    $("#tampil_dp").val("");
                    $("#tampil_sisa").val("");
                    $('div#tampil_bayar').show();
                    $('div#tampil_kembali').show();
                    $('div#tampil_dp').hide();
                    $('div#tampil_sisa').hide();

                } else {
                    $("#dp").val(0);
                    $("#sisa").val(0);
                    $("#tampil_bayar").val("");
                    $("#tampil_kembali").val("");
                    $('div#tampil_bayar').hide();
                    $('div#tampil_kembali').hide();
                    $('div#tampil_dp').show();
                    $('div#tampil_sisa').show();
                }
            });

            	//UBAH DISCOUNT
                $(document).on('keyup', '.discount', function () {
                    var id = $(this).data("idbuffer");
                    var harga_jual = $('#harga_jual' + id).val();
                    var qty = $('#qty' + id).val();
                    var discount = $('#discount' + id).val();
                    var hasil = (harga_jual *qty) * discount/100;
                    $('#subtotal' + id).val((harga_jual * qty) - hasil);
                    GetTotalBayar();
                    
                });

                $(document).on('change', '.discount', function () {
                    var id = $(this).data("idbuffer");
                    var harga_jual = $('#harga_jual' + id).val();
                    var qty = $('#qty' + id).val();
                    var discount = $('#discount' + id).val();
                    var hasil = (harga_jual *qty) * discount/100;
                    $('#subtotal' + id).val((harga_jual * qty) - hasil);
                    GetTotalBayar();
                    
                });
                    

                //UBAH QTY
                $(document).on('change', '.qty_penjualan', function () {
                    var id = $(this).data("idbuffer");
                    var harga_jual = $('#harga_jual' + id).val();

                    var qty = $('#qty' + id).val();
                    var discount = $('#discount' + id).val();
                    $('#subtotal' + id).val((harga_jual * qty) - discount/100);
                    GetTotalBayar();
                });

                // $(document).on('change', '.qty_penjualan', function () {
                //     var id = $(this).data("idbuffer");
                //     var harga_jual = $('#harga_jual' + id).val();

                //     var qty = $('#qty' + id).val();
                //     var discount = $('#discount' + id).val();
                //     $('#subtotal' + id).val((harga_jual * qty) - discount/100);
                //     GetTotalBayar();
                // });


                $(document).on('click','.add_barang',function(){
                    var id = $(this).data("id_barang");
                    var kode = $(this).data("kode_barang");
                    var nama = $(this).data("nama_barang");
                    var harga_beli = $(this).data("harga_beli");
                    var harga_jual = $(this).data("harga_jual");
                    var stock = $(this).data("stock");
                    var keuntungan = ($(this).data("harga_jual") - $(this).data("harga_beli"));
                    // function getStock(){
                    //     return stock;
                    // }
                    TambahDataPenjualan(id,kode,nama,harga_beli,harga_jual, stock, keuntungan);
                });

                $(document).on('click','.add_pelanggan',function(){
                    var id = $(this).data("id_pelanggan");
                    var nama = $(this).data("nama_pelanggan");
                    var alamat = $(this).data("alamat");
                    var tlp = $(this).data("tlp");

                    $('#id_pelanggan').val(id);
                    $('#nama_pelanggan').val(nama);
                    $('#tlp').val(tlp);
                });

                function TambahDataPenjualan(id,kode,nama,harga_beli,harga_jual,stock, keuntungan){
                    var id_barang=id;
                    var kode_barang=kode;
                    var nama_barang=nama;
                    var harga_beli=harga_beli;
                    var harga_jual=harga_jual;
                    var stock=stock;
                    var keuntungan=keuntungan;

                    var barang=CariIdBarang(id_barang);

                    if(barang==false){
                        //HAPUS BARIS 1
                        $('#buffer100').remove();
                        count++;
                        var rowBarang="<tr class='barang' id='buffer"+count+"'>";
                        rowBarang+="<td style='text-align:center'><input type='hidden' name='item["+count+"][id_barang]' value='"+id_barang+"'> <input class='form-control' type='text' name='item["+count+"][kode]' value='"+kode_barang+"' readonly='true'' style='width: 130px;'></td>";
                        rowBarang+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang]' value='"+nama_barang+"' readonly='true' style='width: 150px;'></td>";
                        rowBarang+="<td><input class='form-control' style='text-align:right; width: 200px;' type='text' name='item["+count+"][harga_jual]' value='"+harga_jual+"' id='harga_jual"+count+"' readonly='true'><input type='hidden' name='item["+count+"][harga_beli]' value='"+harga_beli+"'></td>";
                        rowBarang+="<td style='text-align:center'><input type='number' class='form-control qty_penjualan' name='item["+count+"][qty]' max='"+stock+"' value='1' id='qty"+count+"' data-idbuffer='"+count+"' onchange='cekQty(this)' style='width: 90px;'></td>";
                        rowBarang+="<td style='text-align:center'><div class='input-group-prepend input-primary'><input onchange='cekDiscount(this)' max='100' style='text-align:right; width: 70px;' type='number' class='form-control discount' name='item["+count+"][discount]' value='0' id='discount"+count+"' onkeypress='cek_number()' data-idbuffer='"+count+"'><span class='input-group-text'>%</span></div></td>";
                        rowBarang+="<td style='text-align:center'><input style='text-align:right; width: 200px;' type='number' class='form-control' name='item["+count+"][subtotal]' value='"+harga_jual+"' readonly='true' id='subtotal"+count+"'></td>";
                        rowBarang+="<input style='text-align:right' type='hidden' class='form-control' name='item["+count+"][keuntungan]' value='"+keuntungan+"' readonly='true' id='keuntungan"+count+"'>";
                        rowBarang+="<td style='text-align:center;'><button type='button' class='btn btn-danger hapus_penjualan' data-idbuffer='"+count+"' ><i class='fa fa-trash'></i></button></td>";
                        rowBarang+="</tr>";
                        $('#t_penjualan').append(rowBarang);
                    }else{
                        var posisi = CariPosisi(id_barang);
                        var qty = Number($('#qty'+posisi).val())+1;
                        $('#qty'+posisi).val(qty);
                        $('#subtotal'+posisi).val(harga_jual*qty);
                    }
                        GetTotalBayar();
                        // GetKeuntungan();
                }


            function CariIdBarang(cari){
                var found = false;
                var x = 1;
                while((x<=count) && ($("input[name='item["+x+"][id_barang]']").val()!=cari)){
                    x++
                }

                if($("input[name='item["+x+"][id_barang]']").val()==cari){
                    found=true;
                }

                return found;
            }

            function CariPosisi(cari){
                var found=false;
                var x=1;

                while((x<=count) && ($("input[name='item["+x+"][id_barang]']").val()!=cari)){
                    x++
                }

                if($("input[name='item["+x+"][id_barang]']").val()==cari){
                    found=true;
                }

                return x;
            }

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

            $(document).on('keyup', '#bayar', function(e){
                generateRupiah(this);
            })
            $(document).on('keyup', '#dp', function(e){
                generateRupiah(this);
            })

           //DP
            // $(document).on('keyup', '#dp', function(e) {
            //     var tb = $("#total_bayar").val();
            //     var dp = $(this).val();
            //     var bayardp = String(dp).replaceAll(".", '');
            //     // console.log(tb - bayardp)
            //     // console.log()
            //     var sisa = tb - parseFloat(bayardp);
            //     let formatRupiah = Math.round(Number(sisa)).toLocaleString("id-ID", {
            //                         style:"currency",
            //                         currency:"IDR",
            //                         maximumSignificantDigits: (sisa + '').replace('.', '').length
            //                     });
                
            //     // let ubah_int = formatRupiah.replace(/Rp/g, '');
            //     // let pengurangan2 = ubah_int.replaceAll('.', '');
            //     // console.log(makerp)

            //     // $('#dp').val(parseFloat(bayardp));
            //     $('#bayar').val(0);
            //     $('#sisa').val(formatRupiah.replace(/Rp/g, '').substr(1));
            //     // $('#sisa').val(tb-bayardp);
            // })

            $(document).on('keyup', '#dp', function () {
                    var dp = $(this).val();
                    var total = $('#total_bayar').val();
                    var bayardp = String(dp).replaceAll(".", '');

                    var sisa = total - parseFloat(bayardp);
                    let formatRupiah = Number(sisa).toLocaleString("id-ID", {
                                        style:"currency",
                                        currency:"IDR",
                                        maximumSignificantDigits: (sisa + '').replace('.', '').length
                                    });
                    let ubah_int = formatRupiah.replace(/Rp/g, '');
                    let sisabayar = ubah_int.replaceAll('.', '');
                    
                    $('#sisa').val(sisa);
                });

            //KEMBALIAN
            $(document).on('keyup', '#bayar', function (e) {
                var tb = $("#total_bayar").val();
                var bayar = $(this).val();
                var harga = String(bayar).replaceAll(".", '');

                let kembali = parseFloat(harga) - tb;
                let makerp = Math.round(Number(kembali)).toLocaleString("id-ID", {
                            style:"currency", 
                            currency:"IDR", 
                            maximumSignificantDigits: (kembali + '').replace('.', '').length
                            });

                $('#dp').val(0);
                $('#bayar').val(bayar);
                $('#kembali').val(makerp.replace(/Rp/g, '').substr(1));
                // $('#kembali').val(parseFloat(harga) - tb);  

                // let pengurangan = parseFloat(harga) - tb;
                // let dibayar = Math.round(Number(harga)).toLocaleString("id-ID", {
                //             style:"currency", 
                //             currency:"IDR", 
                //             maximumSignificantDigits: (harga + '').replace('.', '').length
                //         });
                // let kembali = Number(tb).toLocaleString("id-ID", {
                //             style:"currency",
                //             currency:"IDR",
                //             maximumSignificantDigits: (tb + '').replace('.', '').length
                //         });
                // let ubah_int = cek_bayar.replace(/Rp/g, '');
                // let jadi_harga = ubah_int.replaceAll('.', '');
                // console.log(jadi_harga)
                // let pengurangan2 = parseFloat(jadi_harga - tb);
                // console.log(pengurangan2)
                // $('#bayar').val(bayar)
                // $('#kembali').val(total.replace(/Rp/g, '').substr(1));
                        // console.log(total)
                // let hasil_akhir = String(bayar).replaceAll(".", "");
                // console.log(harga)         
            });

            // $(document).on('change', '#bayar', function() {
            //     var tb = $("#total_bayar").val();
            //     var bayar = $(this).val();
            //     var harga = String(bayar).replaceAll(".", '');
                
            //     if(parseFloat(harga) >= tb) {
            //         $('#dp').val(0);
            //         $('#bayar').val(parseFloat(harga));
            //         $('#kembali').val(parseFloat(harga) - tb);      
            //     } else if(parseFloat(harga) <= tb) {
            //         $('#dp').val(0);
            //         $('#bayar').val(tb);
            //         $('#kembali').val(0);
            //     }
                
            // })


            $(document).on('click','.hapus_penjualan',function(){
                var delete_row=$(this).data("idbuffer");
            
                //hapus pada table
                $('#buffer'+delete_row).remove(); 
                count--;
                GetTotalBayar();
                //GetKeuntungan();
            });
            
         
            // function GetKembali() {
            //     // var harga = number;
            //     var kembali = $('#bayar').val() - $("#total_bayar").val();
            //     // console.log(kembali)
            //     if (kembali >= 0) {
            //         $("#kembali").val(kembali);
            //     } else {
            //         var kurang = $('#total_penjualan').val();
            //         $('#bayar').val(kurang)
            //         $("#kembali").val(kembali);
            //     }
            // }

            // function terbilang(angka)
            // {
            //     var angka = Math.abs(angka);
            //     var baca = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
            //     var terbilang = '';

            //     if (angka < 12) { // 0 - 11
            //             terbilang = ' '+$baca[angka];
            //         } else if (angka < 20) { // 12 - 19
            //             terbilang = angka -10+' belas';
            //         } else if (angka < 100) { // 20 - 99
            //             terbilang = angka / 10+' puluh'+(angka % 10);
            //         } else if (angka < 200) { // 100 - 199
            //             terbilang = ' seratus'+(angka -100);
            //         } else if (angka < 1000) { // 200 - 999
            //             terbilang = angka / 100+' ratus'+(angka % 100);
            //         } else if (angka < 2000) { // +00 - +99
            //             terbilang = ' seribu'+(angka -1000);
            //         } else if (angka < 1000000) { // +00 - 99+99
            //             terbilang = angka / 1000+' ribu'+(angka % 1000);
            //         } else if (angka < 1000000000) { // 1000000 - 99+9+90
            //             terbilang = angka / 1000000+' juta'+(angka % 1000000);
            //         }

            //     return terbilang;
            // }

            function GetTotalBayar(){
                var total_penjualan = 0;
                //HASILKAN TOTAL BAYAR
                for(x=1;x<=count;x++){
                    total_penjualan += Number($("input[name='item["+x+"][subtotal]']").val());
                }
        			$('#total_bayar').val(Number(total_penjualan));
                    let total = Math.round(Number(total_penjualan)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (total_penjualan + '').replace('.', '').length
                                });
        			$('#total_bayar_gede').text(total);
                    $('#total_penjualan').val(Number(total_penjualan));	
                    // $('#tampil-terbilang').text(terbilang(Number(total_penjualan)));
            }
                
        });
    </script>
     <script>
        
    </script>
@endpush
