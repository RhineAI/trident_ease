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
    input:focus {outline:none!important;}
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

    /* input [aria_controls]    { 
        width: 100px; 
    } */
    @media (min-width: 1025px) {
        .h-custom {
            height: 100vh !important;
        }
    }

    .number-input input[type="number"] {
        -webkit-appearance: textfield;
        -moz-appearance: textfield;
        appearance: textfield;
    }

    .number-input input[type=number]::-webkit-inner-spin-button,
    .number-input input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
    }

    .number-input button {
        -webkit-appearance: none;
        background-color: transparent;
        border: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin: 0;
        position: relative;
    }

    .number-input button:before,
    .number-input button:after {
        display: inline-block;
        position: absolute;
        content: '';
        height: 2px;
        transform: translate(-50%, -50%);
    }

    .number-input button.plus:after {
        transform: translate(-50%, -50%) rotate(90deg);
    }

    .number-input input[type=number] {
        text-align: center;
    }

    .number-input.number-input {
        border: 1px solid #ced4da;
        width: 10rem;
        border-radius: .25rem;
    }

    .number-input.number-input button {
        width: 2.6rem;
        height: .7rem;
    }

    .number-input.number-input button.minus {
        padding-left: 10px;
    }

    .number-input.number-input button:before,
    .number-input.number-input button:after {
        width: .7rem;
        background-color: #495057;
    }

    .number-input.number-input input[type=number] {
        max-width: 4rem;
        padding: .5rem;
        border: 1px solid #ced4da;
        border-width: 0 1px;
        font-size: 1rem;
        height: 2rem;
        color: #495057;
    }

    @media not all and (min-resolution:.001dpcm) {
        @supports (-webkit-appearance: none) and (stroke-color:transparent) {

            .number-input.def-number-input.safari_only button:before,
            .number-input.def-number-input.safari_only button:after {
                margin-top: -.3rem;
            }
        }
    }

    .shopping-cart .def-number-input.number-input {
        border: none;
    }

    .shopping-cart .def-number-input.number-input input[type=number] {
        max-width: 4rem;
        border: none;
    }

    .shopping-cart .def-number-input.number-input input[type=number].black-text,
    .shopping-cart .def-number-input.number-input input.btn.btn-link[type=number],
    .shopping-cart .def-number-input.number-input input.md-toast-close-button[type=number]:hover,
    .shopping-cart .def-number-input.number-input input.md-toast-close-button[type=number]:focus {
        color: #212529 !important;
    }

    .shopping-cart .def-number-input.number-input button {
        width: 1rem;
    }

    .shopping-cart .def-number-input.number-input button:before,
    .shopping-cart .def-number-input.number-input button:after {
        width: .5rem;
    }

    .shopping-cart .def-number-input.number-input button.minus:before,
    .shopping-cart .def-number-input.number-input button.minus:after {
        background-color: #9e9e9e;
    }

    .shopping-cart .def-number-input.number-input button.plus:before,
    .shopping-cart .def-number-input.number-input button.plus:after {
        background-color: #4285f4;
    }

    .balloon {
        display: inline-block;
        width: 100%;
        margin-right: -140px;
        padding: 8px 0 2px 5px;
        font-family: "Open Sans", sans;
        font-weight: 400;
        color: #111;
        direction: rtl;
        /* background: #ece9e9; */
        border: 0;
        border-radius: 3px;
        outline: 0;
        text-indent: 2px;
        transition: all .3s ease-in-out;
    }

    /*Wide Version - can be applied to more elements*/
    .balloon.wide {
        text-indent: 200px;
    }

    .balloon::-webkit-input-placeholder {
        color: #747373;
        text-indent: 0;
        font-weight: 300;
    }

    .balloon+label {
        display: inline-block;
        position: absolute;
        top: 8px;
        left: 0;
        bottom: 8px;
        padding: 5px 15px;
        color: #032429;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        text-shadow: 0 1px 0 rgba(19, 74, 70, 0);
        transition: all .3s ease-in-out;
        border-radius: 3px;
        background: rgba(122, 184, 147, 0);
    }

    .balloon+label:after {
        position: absolute;
        content: "";
        width: 0;
        height: 0;
        top: 100%;
        /* left: 50%; */
        margin-left: -3px;
        border-left: 3px solid transparent;
        border-right: 3px solid transparent;
        border-top: 3px solid rgba(122, 184, 147, 0);
        transition: all .3s ease-in-out;
    }

    .balloon:focus,
    .balloon:active {
        color: #377D6A;
        /*Note !important*/
        text-indent: 0 !important;
        background: #fff;
    }

    .balloon:focus::-webkit-input-placeholder,
    .balloon:active::-webkit-input-placeholder {
        color: #aaa;
    }

    .balloon:focus+label,
    .balloon:active+label {
        color: #fff;
        text-shadow: 0 1px 0 rgba(19, 74, 70, 0.4);
        background: #ffffff;
        transform: translateY(-40px);
        padding-bottom: 20px;
    }

    .balloon:focus+label:after,
    .balloon:active+label:after {
        border-top: 4px solid #7ab893;
    }

    label { order: 1; }
    input { order: 2; }

</style>
@endpush

@section('contents')
  
<section class="content" >
    <div class="row mx-4" >
        <div class="col-lg-12 rounded" style="background-color: white;">
            <div class="box-body">

                @if (Auth::user()->hak_akses == 'admin')
                    <form class="form-pelanggan mt-3" method="post" id="form-transaksi" action="">
                @elseif (Auth::user()->hak_akses == 'kasir')
                    <form class="form-pelanggan mt-3" method="post" id="form-transaksi" action="{{ route('kasir.transaksi-penjualan.store') }}">
                @endif
                    @csrf
                {{-- <div class="form-group row">
                    <label for="nama_pelanggan" class="col-lg-2">Pelanggan</label>
                    <div class="col-lg-3">
                        <div class="input-group">
                            <input type="text" name="nama_pelanggan" required id="nama_pelanggan" class="form-control" required readonly>
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
                            <input type="text"  name="barcode" id="barcode" class="form-control" required autofocus placeholder="Masukkan Barcode..">
                            <span class="input-group-btn tampil-produk">
                                <button onclick="tampilProduk()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                <button onclick="enterProduk()" id="enter" class="btn btn-info btn-flat add_barang" type="button"><i class="fa-solid fa-arrow-right"></i></button>
                            </span>
                        </div>
                    </div>
                </div> --}}
                <div class="container h-100 py-3">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col">
                            <div class="card shopping-cart" style="border-radius: 15px;">
                                <div class="card-body text-black">

                                    <div class="row">
                                        <div class="col-lg-8 px-2 py-2">
                                            {{-- <h3 class="mb-5 pt-2 text-center fw-bold text-uppercase">Your products</h3> --}}
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="table-responsive">
                                                    <table class="table" id="t_penjualan">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" class="border-0 bg-light">
                                                                    <div class="p-1 px-2 text-uppercase">Produk</div>
                                                                </th>
                                                                <th scope="col" class="border-0 bg-light">
                                                                    <div class="py-1 px-2 text-uppercase">Harga</div>
                                                                </th>
                                                                <th scope="col" class="border-0 bg-light">
                                                                    <div class="py-1 text-uppercase">Diskon(%)</div>
                                                                </th>
                                                                <th scope="col" class="border-0 bg-light">
                                                                    <div class="py-1 text-uppercase">Aksi</div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <th></th>
                                                                <td></td>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                  </div>
                                            </div>
                                            <hr class="mb-4" style="height: 2px; background-color: #1266f1; opacity: 1;">
                                            <p class="text-center align-middle" style="font-size: 14px">List Produk</p>
                                        </div>
                                        
                                        <div class="col-lg-4 py-2">
                                            <div class="card mb-4">
                                                <div class="card-header py-3">
                                                    <h5 class="mb-0">Detail</h5>
                                                </div>
                                                <div class="card-body">
                                                    <h6>Pilih Barang</h6>
                                                    <div class="input-group">
                                                        <input type="hidden" required name="id_produk" id="id_produk">
                                                        <input type="hidden" class="form-control" name="kode_produk" id="kode_produk">
                                                        <input type="text" style="border-radius: 0 13px 13px 0;"  name="barcode" id="barcode" class="form-control" required autofocus placeholder="Masukkan Barcode..">
                                                        <span class="input-group-btn tampil-produk">
                                                            <button style="border-radius: 13px;" onclick="tampilProduk()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                            <button style="border-radius: 13px 0 0 13px;" onclick="enterProduk()" id="enter" class="btn btn-info btn-flat add_barang" type="button"><i class="fa-solid fa-arrow-right"></i></button>
                                                        </span>
                                                    </div>
                                                    <br>

                                                    <h6>Pilih Pelanggan</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                                                        <input type="text" style="border-radius: 0 13px 13px 0;" name="nama_pelanggan" required id="nama_pelanggan" class="form-control" required readonly value="{{ $pelangganUmum->nama }}">
                                                        <span class="input-group-btn tampil-pelanggan">
                                                            <button style="border-radius: 13px 0 0 13px;" onclick="tampilPelanggan()" class="btn btn-info btn-flat" type="button" ><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                                        </span>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <input type="text" style="border-radius: 13px;" name="tlp" id="tlp" class="form-control" required readonly value="Telepon : {{ $pelangganUmum->tlp }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card mb-4">
                                                <div class="card-header py-3">
                                                    <h5 class="mb-0">Pembayaran</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class=""> 
                                                        
                                                        <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                            <p class="mb-2">Total</p>
                                                            <p class="mb-2" id="displayTotal">Rp. 0</p>
                                                            <input type="hidden" data-bv-trigger="blur" id="total_bayar" name="total_bayar" class="form-control" readonly>
                                                            <input class="form-control" type="hidden" name="total_penjualan" data-bv-trigger="blur" id="total_penjualan" readonly="true">
                                                        </div>

                                                        <hr class="my-3">

                                                        <div class="d-flex justify-content-between mb-1" style="font-weight: 500;">
                                                          <p class="mb-2">Bayar</p>
                                                          <span>
                                                            <input class="balloon  bayar" id="bayar" name="bayar" type="text" placeholder="0" />
                                                          </span>
                                                        </div>

                                                        <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                                            <p class="mb-2">Kembalian</p>
                                                            <span>
                                                                <input type="text" data-bv-trigger="blur" id="kembali" readonly name="kembali" class="balloon mb-2 kembali" value="0">
                                                            </span>
                                                        </div>

                                                        <button type="button" id="simpan" class="submit btn btn-primary btn-lg btn-block">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</form>

@include('transaksi-penjualan.formBarang')
@include('transaksi-penjualan.formPelanggan')
</section>

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
        // $(document).ready(function(){  
        // });
        // $(document).ready(function(){
        //     $('#datatable-buttons_filter').css({"position":"relative","left":"-100px"});
        // });
        
        var subtotal=0;
        var discount=0;
        var total=0;
        var count=0;

        $('div#tampil_dp').hide();
        $('div#tampil_sisa').hide();

        $('#simpan').on('click', function(){   
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
             
            @if(auth()->user()->hak_akses == 'admin')
                var newPage = "{{ route('admin.transaksi-penjualan.index') }}";
            @elseif(auth()->user()->hak_akses == 'kasir')
                var newPage = "{{ route('kasir.transaksi-penjualan.index') }}";
            @endif
            window.open(newPage)
            document.getElementById('form-transaksi').submit();
        });

        $('#barcode').on('keypress',function(e) {
            if(e.which == 13) {
                enterProduk()
            }
        });

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

        function TambahDataPenjualan(id,kode,nama,harga_beli,harga_jual,stock, keuntungan){
            var id_barang=id;
            var kode_barang=kode;
            var nama_barang=nama;
            var harga_beli=harga_beli;
            var harga_jual=harga_jual;
            var stock=stock;
            var keuntungan=keuntungan;
            var item_row = 1;
            // console.log(id_barang, kode_barang, nama_barang, harga_beli, harga_jual, stock, keuntungan, item_row)
            var barang=CariIdBarang(id_barang);
            var format_harga_jual = Math.round(Number(harga_jual)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (harga_jual + '').replace('.', '').length
                                    });

            if(barang==false){
                //HAPUS BARIS 1
                $('#buffer100').remove();
                count++;
                var rowBarang="<tr class='barang' id='buffer"+count+"'>";
                rowBarang+="<th scope='row' class='border-0'>";
                rowBarang+="<div class='1'>";
                rowBarang+="<img src='https://bootstrapious.com/i/snippets/sn-cart/product-1.jpg' alt='' width='70' class='img-fluid rounded shadow-sm'>";
                rowBarang+="<div class='ml-3 d-inline-block align-middle'>";
                rowBarang+="<input type='hidden' name='item["+count+"][id_barang]' value='"+id_barang+"'>"
                rowBarang+="<h5 style='font-size:18.5px;' class='mb-0'><a class='text-dark d-inline-block align-middle'>"+nama_barang+"</a><input type='hidden' name='item["+count+"][nama_barang]' value='"+nama_barang+"' type='number'></h5>";
                rowBarang+="<div class='def-number-input number-input safari_only'>";
                rowBarang+="<h6 style='font-size:16px;'><a class='text-dark'>"+format_harga_jual+"</a><input type='hidden' id='harga_jual"+count+"' name='item["+count+"][harga_jual]' value='"+harga_jual+"' type='text'></h6>"
                rowBarang+="<button data-idbuffer='"+count+"' id='minus' type='button' onclick='this.parentNode.querySelector";
                rowBarang+='("input[type=number]")';
                rowBarang+=".stepDown()' class='minus'></button>";
                rowBarang+="<input class='quantity fw-bold text-black qty_penjualan' name='item["+count+"][qty]' max='"+stock+"' value='1' id='qty"+count+"' data-idbuffer='"+count+"' onchange='cekQty(this)' type='number'>";
                rowBarang+="<button data-idbuffer='"+count+"' id='plus' type='button' onclick='this.parentNode.querySelector";
                rowBarang+='("input[type=number]")';
                rowBarang+=".stepUp()' class='plus'></button>";
                rowBarang+="</div'></div'></div'></th'>";
                rowBarang+="<td class='border-0 align-middle'><div class='input-group text-center align-middle'>";
                rowBarang+="<input class='balloon mb-2 text-center align-middle discount' onchange='cekDiscount(this)' max='100' type='number' class='form-control discount' name='item["+count+"][discount]' id='discount"+count+"' onkeypress='cek_number()' data-idbuffer='"+count+"' placeholder='0' style='max-width: 60%; direction:lrt; text-indent:0px;'/></div></td>";
                rowBarang+="<td class='border-0 align-middle'><input type='hidden' class='subtotal' type='number' class='form-control subtotal' name='item["+count+"][subtotal]' value='"+harga_jual+"' readonly='true' id='subtotal"+count+"'>";
                rowBarang+="<strong id='displayST"+count+"'>"+format_harga_jual+"</strong></td>"
                rowBarang+="<td class='border-0 align-middle'><button type='button' class='text-dark hapus_penjualan' data-idbuffer='"+count+"'><i class='fa fa-trash' style='outline:none;'></i></a></td>";
                $('#t_penjualan').append(rowBarang);
            } else{
                var posisi = CariPosisi(id_barang);
                var qty = Number($('#qty'+posisi).val())+1;
                var discount = $('#discount' + posisi).val();
                const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
                $('#qty'+posisi).val(qty);
                $('#subtotal'+posisi).val(subtotal);
                $('#displayST' + posisi).text(subtotal);

            }
                GetTotalBayar();
                // GetKeuntungan();
                var id = $('.qty_penjualan').data("idbuffer");
        //     var harga_jual = $('#harga_jual' + id).val();

        //     var qty = $('#qty' + id).val();
        //     $('#subtotal' + id).val(subtotal);
        //     console.log(harga_jual * qty)

        //     GetTotalBayar();
        }

        //UBAH DISCOUNT
        $(document).on('keyup', '.discount', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();
            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            var hasil = (harga_jual *qty) * discount/100;
            $('#subtotal' + id).val((harga_jual * qty) - hasil);
            var format_subtotal =   Math.round(Number((harga_jual * qty) - hasil)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: ((harga_jual * qty) - hasil + '').replace('.', '').length
                                    });
            $('#displayST' + id).text(format_subtotal);
            GetTotalBayar();
        });

        // $(document).on('change', '.discount', function () {
        //     var id = $(this).data("idbuffer");
        //     var harga_jual = $('#harga_jual' + id).val();
        //     var qty = $('#qty' + id).val();
        //     var discount = $('#discount' + id).val();
        //     var hasil = (harga_jual *qty) * discount/100;
        //     $('#subtotal' + id).val((harga_jual * qty) - hasil);
        //     GetTotalBayar();
            
        // });
            

        //UBAH QTY
        $(document).on('click', '#plus', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();

            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
            $('#subtotal' + id).val(subtotal);
            var format_subtotal =   Math.round(Number(subtotal)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (subtotal + '').replace('.', '').length
                                    });
            $('#displayST' + id).text(format_subtotal);
            // console.log(harga_jual * qty)
            GetTotalBayar();
        });

        $(document).on('click', '#minus', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();

            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
            $('#subtotal' + id).val(subtotal);
            var format_subtotal =   Math.round(Number(subtotal)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (subtotal + '').replace('.', '').length
                                    });
            $('#displayST' + id).text(format_subtotal);

            GetTotalBayar();
        });

        $(document).on('keyup', '.qty_penjualan', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();

            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
            $('#subtotal' + id).val(subtotal);
            $('#displayST' + id).text(subtotal);
            console.log(harga_jual * qty)

            GetTotalBayar();
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
            var tb = $("#total_penjualan").val();
            // console.log(tb)
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

        function GetTotalBayar(){
            // var subtotal = $("[class='form-control subtotal']").val();
            var subtotal = document.querySelectorAll('.subtotal');
            var totalP = 0;
            subtotal.forEach(function(item){
                totalP += parseFloat(item.value);
            });
            console.log(totalP)
            // console.log(totalP)
            // var total_penjualan = 0;
            //HASILKAN TOTAL BAYAR
            // for(x=1;x<=count;x++){
            //     if($("input[name='item["+x+"][subtotal]']").val() != undefined){
            //         total_penjualan += Number($("input[name='item["+x+"][subtotal]']").val());
            //     }
            // }
                let total = Math.round(Number(totalP)).toLocaleString("id-ID", {
                            style:"currency", 
                            currency:"IDR", 
                            maximumSignificantDigits: (totalP + '').replace('.', '').length
                        });
                $('#displayTotal').text(total)
                $('#total_bayar').val(Number(totalP));
                // $('#total_bayar_gede').text(total);
                $('#total_penjualan').val(Number(totalP));	
        }


        $(document).on('click','.hapus_penjualan',function(){
            var delete_row= $(this).data("idbuffer");
            let deleted_sub = Number($('#subtotal'+delete_row).val());
            let kurangiTotal = Number($('#total_penjualan').val());
            kurangiTotal -= deleted_sub;
            //hapus pada table
            $('#buffer'+delete_row).remove(); 
            // count--;

            // console.log(kurangiTotal)
            $('#total_bayar').val(Number(kurangiTotal));
                let total = Math.round(Number(kurangiTotal)).toLocaleString("id-ID", {
                                style:"currency", 
                                currency:"IDR", 
                                maximumSignificantDigits: (kurangiTotal + '').replace('.', '').length
                            });
            $('#total_bayar_gede').text(total);
            $('#total_penjualan').val(Number(kurangiTotal));	
            // GetTotalBayar();
            //GetKeuntungan();
        });

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

        $(document).on('click','.add_barang',function(){
            var id = $(this).data("id_barang");
            var kode = $(this).data("kode_barang");
            var nama = $(this).data("nama_barang");
            var harga_beli = $(this).data("harga_beli");
            var harga_jual = $(this).data("harga_jual");
            var stock = $(this).data("stock");
            var stock_minimal = $(this).data("stock_minimal");
            var keuntungan = ($(this).data("harga_jual") - $(this).data("harga_beli"));
            if (stock <= stock_minimal ) {
                let timerInterval
                Swal.fire({
                    title: 'Produk ini sudah mencapai stok minimum!',
                    html: 'Pesan akan hilang dalam <b></b> milidetik.',
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading()
                        const b = Swal.getHtmlContainer().querySelector('b')
                        timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft()
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    /* Read more about handling dismissals below */
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('Bye')
                    }
                })
                TambahDataPenjualan(id,kode,nama,harga_beli,harga_jual, stock, keuntungan);
            } else {
                TambahDataPenjualan(id,kode,nama,harga_beli,harga_jual, stock, keuntungan);
            }
        });

        // DISABLEEEE
        // $(document).bind("contextmenu",function(e) {
        //     e.preventDefault();
        // });
            
        // $(document).keyup(function(b) {     
        //     if (b.keyCode == 16) {return false;}
        //     if (b.keyCode == 17) {return false;}
        // });


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
                    barcode: barcode,
                    _token: "{{ csrf_token() }}"
                },
                cache: false,
                success: function(response){
                    if (!$.trim(response)){   
                        Swal.fire('Data Produk Yang Anda Maksud Tidak Ada');
                    }
                    // console.log(response)
                    TambahDataPenjualan(response.id,response.kode,response.nama,response.harga_beli,response.harga_jual,response.stock, response.keuntungan);
                    $('#barcode').val('');
                }
            })
        }

        // $(document).on('click', '#submit', function(){    
        // });
      

        $('body').addClass('sidebar-collapse');

        function tampilProduk() {
            const min_stock = $('#stok_minimal').val();
            const total_stock = $('#stok').val();
             if (total_stock <= min_stock) {
                let data_stok = "!"; 
                $('#alert_stock').addClass('position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger');       
                $('#alert_stock').append(data_stok);       
            }
            
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

        

    </script>
@endpush
