@extends('templates.layout')

@section('title')
    <title>Pembelian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Pembelian
@endsection

@section('breadcrumb')
@parent
    Pembelian
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

    .table-pembelian tbody tr:last-child {
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
        
                    <div class="box-body mx-2 my-2">

                        <form class="form-supplier" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="nama_supplier" class="col-lg-2">Supplier</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" required autofocus readonly>
                                        <span class="input-group-btn tampil-supplier">
                                            <button onclick="tampilSupplier()" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tlp" class="col-lg-2">Telepon Supplier</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="hidden" name="id_supplier" id="id_supplier">
                                        <input type="text" name="tlp" id="tlp" class="form-control" required readonly>
                                    </div>
                                </div>
                            </div>
                        <br>
                            
                            <div class="form-group row">
                                <label for="kode_produk" class="col-lg-2">Tambah Produk</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
                                        <input type="hidden" name="id_produk" id="id_produk">
                                        <input type="hidden" class="form-control" name="kode_produk" id="kode_produk">
                                        <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                        <span class="input-group-btn tampil-produk">
                                            {{-- <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button> --}}
                                            <button onclick="tampilProduk()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
        
                        <div class="table-responsive">
                            <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered" id="buffer_table">
                                <thead>
                                   <tr>
                                    <th class="text-center" width="8.2%"> Kode</th>
                                    <th class="text-center" width="18%">Nama</th>
                                    <th class="text-center" width="15%">Harga</th>
                                    <th class="text-center" width="9%">Jumlah</th>
                                    <th class="text-center" width="10.7%">Diskon</th>
                                    <th class="text-center" width="13%">Subtotal</th>
                                    <th class="text-center" width="9%">Aksi</th>
                                   </tr>
                                </thead>
                                <tbody id="t_pembelian">
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
                                <div class="tampil-bayar bg-default mb-4" id="total_bayar_gede">Rp. 0</div>
                                <div class="tampil-terbilang">Nol Rupiah</div>
                            </div>
                            <div class="col-lg-5">
                                       	<!-- TOTAL pembelian  -->
                                    <input class="form-control" type="hidden" name="total_pembelian" value="" data-bv-trigger="blur"
                                    id="total_pembelian" readonly="true">

                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-lg-3 control-label">Jenis Pembayaran</label>
                                        <div class="col-lg-8">
                                            <select class="form-control" name="jenis_pembayaran" data-bv-trigger="blur" id="jenis_pembayaran">
                                                <option value="1">Cash</option>
                                                <option value="2">Kredit</option>
                                                <option value="3" selected="selected">Transfer</option>
                                            </select>
                                        </div>
                                    </div>
                             
                                    <div class="form-group row mt-4" id="tampil_total">
                                        <label for="total_bayar" class="col-lg-3 control-label">Total</label>
                                        <div class="col-lg-8 ">
                                            <div class="input-group-prepend input-primary"> 
                                                <span class="input-group-text">RP.</span> 
                                                <input type="text" data-bv-trigger="blur" id="total_bayar" name="total_bayar" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4" id="tampil_bayar">
                                        <label for="uang_bayar" class="col-lg-3 control-label">Bayar</label>
                                        <div class="col-lg-8 ">
                                            <div class="input-group-prepend input-primary"> 
                                                <span class="input-group-text">RP.</span> 
                                                <input type="text" data-bv-trigger="blur" id="uang_bayar" name="uang_bayar" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4" id="tampil_kembali">
                                        <label for="uang_kembali" class="col-lg-3 control-label">Kembalian</label>
                                        <div class="col-lg-8 ">
                                            <div class="input-group-prepend input-primary"> 
                                                <span class="input-group-text">RP.</span> 
                                                <input type="text" data-bv-trigger="blur" id="uang_kembali" name="uang_kembali" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4" id="tampil_kredit">
                                        <label for="bayar_kredit" class="col-lg-3 control-label">DP</label>
                                        <div class="col-lg-8 ">
                                            <div class="input-group-prepend input-primary"> 
                                                <span class="input-group-text">RP.</span> 
                                                <input type="text" data-bv-trigger="blur" id="bayar_kredit" name="bayar_kredit" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row mt-4" id="tampil_sisa">
                                        <label for="sisa_kredit" class="col-lg-3 control-label">Sisa</label>
                                        <div class="col-lg-8 ">
                                            <div class="input-group-prepend input-primary"> 
                                                <span class="input-group-text">RP.</span> 
                                                <input type="text" readonly data-bv-trigger="blur" id="sisa_kredit" name="sisa_kredit" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="box-footer mb-4 btn-submit">
                        <button type="submit" id="submit" class="btn btn-outline-primary btn-sm pull-right btn-simpan" onkeypress="preventEnter(this)"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
  
        @include('transaksi-pembelian.formBarang')
        @include('transaksi-pembelian.formSupplier')
      </section>
      <!-- /.content -->
@endsection

@push('scripts') 
    <script>
        $(document).on('click', '#submit', function(){
            let id_supplier = $('#id_supplier').val();
            let produk = $('.produk').val();
            let bayar = $('#bayar').val();
            let bayar_kredit = $('#bayar_kredit').val();
            let jenis_pembayaran = $('#jenis_pembayaran').val();
            console.log(jenis_pembayaran)

            if(id_supplier == 0) {
                Swal.fire('Isi data supplier terlebih dahulu')
                return false;
            } else {
                $('#id_supplier').val();
            }

            if(produk == 0) {
                Swal.fire('Tambahkan produk terlebih dahulu')
                return false;
            } else {
                $('#id_produk').val();
            }
            
            if(jenis_pembayaran == 2) {
                if(bayar_kredit == 0) {
                    Swal.fire('Masukan jumlah uang dp terlebih dahulu')
                    return false;
                } else {
                    $('#bayar_kredit').val();
                }
            }          
        });

        $('body').addClass('sidebar-collapse');

        $('div#tampil_kredit').hide();
        $('div#tampil_sisa').hide();
        $('div#tampil_bayar').hide();
        $('div#tampil_kembali').hide();

        $(document).on('change', '#jenis_pembayaran', function () {  
            var isiJenis = $("#jenis_pembayaran").val();
            if (isiJenis == '2') {
                $('div#tampil_kredit').show();
                $('div#tampil_sisa').show();
                $('div#tampil_bayar').hide();
                $('div#tampil_kembali').hide();
            } else if(isiJenis == '1') {
                $('div#tampil_kredit').hide();
                $('div#tampil_sisa').hide();
                $('div#tampil_bayar').show();
                $('div#tampil_kembali').show();
            } else {
                $('div#tampil_kredit').hide();
                $('div#tampil_sisa').hide();
                $('div#tampil_bayar').hide();
                $('div#tampil_kembali').hide();
            }
        });

        function tampilProduk() {
            $('#formModalBarangPembelian').modal('show');
            $('#tbl-data-barang-pembelian').DataTable();
        }

        function preventEnter(e){
            if(e.keyCode === 13){
                return false
            }
        }

        function hideProduk() {
            $('#formModalBarangPembelian').modal('hide');
        }

        function tampilSupplier() {
            $('#formModalSupplierPembelian').modal('show');
            $('#tbl-data-supplier-pembelian').DataTable();
        }

        function hideSupplier() {
            $('#formModalSupplierPembelian').modal('hide');
        }

            function cekDiscount(qty) {
                if(Number(qty.value) < 0){
                    qty.value = 0; 
                } else if(Number(qty.value) > 100) {
                    qty.value = 100;
                } else {
                    qty.value = qty.value;
                }
            }

        $(document).ready(function(){
            var subtotal=0;
            var discount=0;
            var total=0;
            var count=0;

            	//UBAH DISCOUNT
                $(document).on('keyup', '.discount', function () {

                    var id = $(this).data("idbuffer");
                    var harga_beli = $('#harga_beli' + id).val();
                    var qty = $('#qty' + id).val();
                    var discount = $('#discount' + id).val();
                    var convert = String(harga_beli).replaceAll(".", '');
                    
                    var hasil = (parseInt(convert) *qty) * discount/100;
                    $('#subtotal' + id).val((parseInt(convert) * qty) - hasil);
                    GetTotalBayar();
                    //GetKeuntungan();
                    //alert(id);
                });

                $(document).on('keyup', '#uang_bayar', function (e) {
                    var tb = $("#total_bayar").val();
                    var bayar = $(this).val();
                    var harga = String(bayar).replaceAll(".", '');

                    let pengurangan = parseInt(harga) - tb;
                    let total = Math.round(Number(pengurangan)).toLocaleString("id-ID", {
                                style:"currency", 
                                currency:"IDR", 
                                maximumSignificantDigits: (pengurangan + '').replace('.', '').length
                            });
                    let cek_bayar = Number(tb).toLocaleString("id-ID", {
                                style:"currency",
                                currency:"IDR",
                                maximumSignificantDigits: (tb + '').replace('.', '').length
                            });
                    let ubah_int = cek_bayar.replace(/Rp/g, '');
                    let jadi_harga = ubah_int.replaceAll('.', '');
                    // console.log(jadi_harga)
                    let pengurangan2 = parseInt(jadi_harga - tb);
                    
                    $('#uang_bayar').val(bayar)
                    $('#uang_kembali').val(total.replace(/Rp/g, '').substr(1));
                            // console.log(total)
                    $(document).on('change', '#bayar', function(){
                        if(bayar <= tb) {
                            $('#bayar_kredit').val(0);
                            $('#sisa_kredit').val(0);
                            $('#uang_bayar').val(cek_bayar.replace(/Rp/g, '').substr(1));
                            $('#uang_kembali').val(pengurangan2);
                        } else {
                            $('#bayar_kredit').val(0);
                            $('#sisa_kredit').val(0);
                            $('#uang_bayar').val(bayar)
                            $('#uang_kembali').val(total.replace(/Rp/g, '').substr(1));
                        }
                    });   
                    
                    // $(document).on('submit', '#submit', function(){ 
                    //     if(bayar <= tb ) {
                    //         $('#bayar').val(total);
                    //     } else {
                    //         $('#bayar').val(bayar);
                    //     }
                    // });
                });

                $(document).on('keyup', '.harga_beli', function () {
                    var id = $(this).data("idbuffer");
                    var harga_beli = $('#harga_beli' + id).val();
                    var qty = $('#qty' + id).val();
                    var discount = $('#discount' + id).val();
                    var hasil = (harga_beli *qty) * discount/100;
                    var convert = String(harga_beli).replaceAll(".", '');

                    $('#subtotal' + id).val((parseInt(convert) * qty) - hasil);
                    GetTotalBayar();
                    //GetKeuntungan();
                    //alert(id);
                });

                $(document).on('keyup', '#bayar_kredit', function () {
                    var dp = $(this).val();
                    var total = $('#total_bayar').val();
                    var bayardp = String(dp).replaceAll(".", '');
                    var sisa = total - parseInt(bayardp);
                    let formatRupiah = Number(sisa).toLocaleString("id-ID", {
                                        style:"currency",
                                        currency:"IDR",
                                        maximumSignificantDigits: (sisa + '').replace('.', '').length
                                    });
                    let ubah_int = formatRupiah.replace(/Rp/g, '');
                    let sisabayar = ubah_int.replaceAll('.', '');

                    $('#sisa_kredit').val(parseInt(sisabayar));
                });
                    
                //UBAH QTY
                // $(document).on('keyup', '.qty_pembelian', function (e) {
                //     // if (e.keyCode === 13) {
                //         var id = $(this).data("idbuffer");
                //         var harga_beli = $('#harga_beli' + id).val();
                //         var qty = $('#qty' + id).val();
                //         var discount = $('#discount' + id).val();
                //         $('#subtotal' + id).val((harga_beli * qty) - discount);
                //         GetTotalBayar();
                //     // }
                // });

                //UBAH QTY
                $(document).on('keyup', '.qty_pembelian', function () {

                    var id = $(this).data("idbuffer");
                    var harga_beli = $('#harga_beli' + id).val();

                    var qty = $('#qty' + id).val();
                    var convert = String(harga_beli).replaceAll(".", '');
                    
                    var discount = $('#discount' + id).val();
                    $('#subtotal' + id).val((parseInt(convert) * qty) - discount/100);
                    GetTotalBayar();
                });


                $(document).on('click','.add_barang',function(){
                    var id = $(this).data("id_barang");
                    var kode = $(this).data("kode_barang");
                    var nama = $(this).data("nama_barang");
                    var harga_beli = $(this).data("harga_beli");
                    var stock = $(this).data("stock");
                    // function getStock(){
                    //     return stock;
                    // }
                    TambahDataPembelian(id,kode,nama,harga_beli,stock);
                });

                $(document).on('click','.add_supplier',function(){
                    var id = $(this).data("id_supplier");
                    var nama = $(this).data("nama_supplier");
                    var alamat = $(this).data("alamat");
                    var tlp = $(this).data("tlp");
                    $('#id_supplier').val(id);
                    $('#nama_supplier').val(nama);
                    $('#tlp').val(tlp);
                });

                function TambahDataPembelian(id,kode,nama,harga_beli,stock){
                    var id_barang=id;
                    var kode_barang=kode;
                    var nama_barang=nama;
                    var harga_beli=harga_beli;
                    var stock=stock;

                    var barang=CariIdBarang(id_barang);

                    if(barang==false){
                        //HAPUS BARIS 1
                        $('#buffer100').remove();
                        count++;
                        //alert(count);
                        var rowBarang="<tr id='buffer"+count+"'>";
                        rowBarang+="<td style='text-align:center'><input type='hidden' name='item["+count+"][id_barang]' value='"+id_barang+"'> <input class='form-control' type='text' name='item["+count+"][kode]' value='"+kode_barang+"' readonly='true'></td>";
                        rowBarang+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang]' value='"+nama_barang+"' readonly='true'></td>";
                        rowBarang+="<td style='text-align:center'><div class='input-group-prepend input-primary'><span class='input-group-text'>Rp.</span><input style='text-align:right' type='text' class='form-control harga_beli' name='item["+count+"][harga_beli]' value='0' id='harga_beli"+count+"' data-idbuffer='"+count+"'></div></td>";
                        rowBarang+="<td style='text-align:center'><input type='number' class='form-control qty_pembelian' name='item["+count+"][qty]' value='1' id='qty"+count+"' data-idbuffer='"+count+"' onchange='cekQty(this)' ></td>";
                        rowBarang+="<td style='text-align:center'><div class='input-group-prepend input-primary'><input onchange='cekDiscount(this)' max='100' style='text-align:right' type='number' class='form-control discount' name='item["+count+"][discount]' value='0' id='discount"+count+"' data-idbuffer='"+count+"'><span class='input-group-text'>%</span></div></td>";
                        rowBarang+="<td style='text-align:center'><input style='text-align:right' type='number' class='form-control' name='item["+count+"][subtotal]' value='0' readonly='true' id='subtotal"+count+"'></td>";
                        rowBarang+="<td style='text-align:center;'><button type='button' class='btn btn-danger hapus_pembelian' data-idbuffer='"+count+"' ><i class='fa fa-trash'></i></button></td>";
                        rowBarang+="</tr>";
                        $('#t_pembelian').append(rowBarang);
                    }else{
                        var posisi=CariPosisi(id_barang);
                        var qty=Number($('#qty'+posisi).val())+1;
                        $('#qty'+posisi).val(qty);
                        $('#subtotal'+posisi).val(harga_beli*qty);
                    }
                        GetTotalBayar();
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

                    rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
                }

                function generateRupiah(elemValue) {
                    return $(elemValue).val(formatRupiah($(elemValue).val(), 'Rp. '))
                }

            $(document).on('keyup', '#bayar_kredit', function(e){
                generateRupiah(this);
            })

            $(document).on('keyup', '.harga_beli', function(e){
                generateRupiah(this);
            })
  

            // $(document).on('change', '#dp', function(e) {
            //     var tb = $("#total_bayar").val();
            //     var dp = $(this).val();
            //     var harga = String(dp).replace(".", '');
            //     console.log(harga)
            //     $('#sisa').val(tb - parseInt(harga) );
            // })

            //KEMBALIAN
            $(document).on('keyup', '#bayar', function (e) {
                var tb = $("#total_bayar").val();
                var bayar = $(this).val();
                $('#kembali').val(bayar - tb);
            });


            $(document).on('click','.hapus_pembelian',function(){
                var delete_row=$(this).data("idbuffer");
            
                //hapus pada table
                $('#buffer'+delete_row).remove(); 
                count--;
                GetTotalBayar();
                //GetKeuntungan();
            });


            function GetTotalBayar(){
                var total_pembelian=0;
                //HASILKAN TOTAL BAYAR
                for(x=1;x<=count;x++){
                    total_pembelian+= Number($("input[name='item["+x+"][subtotal]']").val());
                }
        			$('#total_bayar').val(Number(total_pembelian));
                    // console.log(total_pembelian)
                    var total = Math.round(total_pembelian).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (total_pembelian + '').replace('.', '').length
                                });
                                // console.log(total)
        			$('#total_bayar_gede').text(total);
                    $('#total_pembelian').val(Number(total_pembelian));	
            }
                
            });


    </script>
@endpush
