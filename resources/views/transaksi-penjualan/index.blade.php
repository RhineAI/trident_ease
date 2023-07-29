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
        margin-right: -15%;
        padding: 8px 0 2px 5px;
        font-family: "Open Sans", sans;
        font-weight: 400;
        color: #111;
        /* direction: rtl; */
        /* background: #ece9e9; */
        border: 0;
        border-radius: 3px;
        outline: 0;
        text-indent: ;
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

    @media screen and (min-width: 0px) and (max-width: 480px) {
        .form-pelanggan {
            width: 98%;
            margin-left:-5%;
        }

        .dataTables_filter input[type="search"] {
            /* font-size: 20px; */
            /* padding: 4px 8px; */
        }
    }

    @media screen and (min-width: 481px) and (max-width:769px) {
        .form-pelanggan {
            width: 98%;
            margin-left:-5%;
        }

        .dataTables_filter input[type="search"] {
            font-size: 10px; 
            padding: 4px 8px;
        }
    }

    @media screen and (min-width: 770px)  and (max-width: 1024px) {
        .form-pelanggan {
            width: 98%;
            margin-left:-5%;
        }
    }
    
</style>
@endpush

@section('contents')
  
<section class="content rounded col-lg-12" style="background-color: white;">
    {{-- <div class="row mx-4" >
        <div class="col-lg-12 rounded">
            <div class="box-body"> --}}

                @if (Auth::user()->hak_akses == 'admin')
                    <form class="form-pelanggan mt-3" method="post" id="form-transaksi" action="">
                @elseif (Auth::user()->hak_akses == 'kasir')
                    <form class="form-pelanggan mt-3" method="post" id="form-transaksi" action="{{ route('kasir.transaksi-penjualan.store') }}">
                @endif
                    @csrf
                {{-- <div class="container h-100 py-3">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col"> --}}
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
                                                                    <div class="py-1 text-uppercase">Diskon(%)</div>
                                                                </th>
                                                                <th scope="col" class="border-0 bg-light">
                                                                    <div class="py-1 px-2 text-uppercase">Subtotal</div>
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
                                                    <h6>Pilih Produk</h6>
                                                    <div class="input-group">
                                                        <input type="hidden" required name="id_barang" id="id_barang">
                                                        <input type="hidden" class="form-control" name="kode_barang" id="kode_barang">
                                                        <input type="text" style="border-radius: 0 13px 13px 0;"  name="barcode" id="barcode" class="form-control" required autofocus placeholder="Masukkan Barcode..">
                                                        <span class="input-group-btn tampil-produk">
                                                            <button style="border-radius: 13px;" onclick="tampilProduk()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                            <button style="border-radius: 13px 0 0 13px;" onclick="enterProduk()" id="enter" class="btn btn-info btn-flat add_barang" type="button"><i class="fa-solid fa-arrow-right"></i></button>
                                                        </span>
                                                    </div>
                                                    <br>

                                                    <h6>Pilih Pelanggan</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="hidden" name="id_pelanggan" id="id_pelanggan" value="{{ $pelangganUmum->id }}">
                                                        <input type="text" style="border-radius: 0 13px 13px 0;" name="nama_pelanggan" required id="nama_pelanggan" class="form-control" required readonly value="{{ $pelangganUmum->nama }}">
                                                        <span class="input-group-btn tampil-pelanggan">
                                                            <button style="border-radius: 13px 0 0 13px;" onclick="tampilPelanggan()" class="btn btn-info btn-flat" type="button" ><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                                        </span>
                                                    </div>

                                                    <div class="input-group mb-2">
                                                        <input type="text" style="border-radius: 13px;" name="tlp" id="tlp" class="form-control" required readonly value="Telepon : {{ $pelangganUmum->tlp }}">
                                                    </div>

						    <br>
                                                    <h6>Tanggal Transaksi</h6>
                                                    <div class="input-group mb-2">
                                                        <input type="date" style="border-radius: 0 13px 13px 0;" value="{{ date('Y-m-d') }}" name="tgl_transaksi" required id="tgl_transaksi" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            

                                            <div class="card mb-4">
                                                <div class="card-header py-3">
                                                    <h5 class="mb-0">Pembayaran</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class=""> 
                                                        <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                                            <select style="border-radius: 0 13px 13px 0; width:100%;"  class="form-control" name="jenis_pembayaran" data-bv-trigger="blur" id="jenis_pembayaran"> 
                                                                <option value="1" selected="selected">Tunai</option>
                                                                <option value="2">Kredit</option>
                                                            </select>
                                                        </div>

                                                        </div>
                                                        <div class="d-flex justify-content-between" style="font-weight: 500;">
                                                            <p class="mb-2">Total</p>
                                                            <p class="mb-2" id="displayTotal">Rp. 0</p>
                                                            <input type="hidden" data-bv-trigger="blur" class="total_harga" id="total_harga" name="total_harga" class="form-control" readonly>
                                                            <input class="form-control" type="hidden" name="total_penjualan" data-bv-trigger="blur" id="total_penjualan" readonly="true">
                                                        </div>

                                                        <hr class="my-3">

                                                        <div class="d-flex justify-content-between " id="tampil_bayar" style="font-weight: 500;">
                                                          <p class="mb-3">Bayar</p>
                                                          <span>
                                                            <input class="balloon bayar" id="bayar" name="total_bayar" autocomplete="off" type="text" placeholder="0" style="text-indent:4px; direction: rtl;">
                                                          </span>
                                                        </div>

                                                        <div class="d-flex justify-content-between mb-4" id="tampil_kembali" style="font-weight: 500;">
                                                            <p class="mb-3">Kembalian</p>
                                                            <span>
                                                                <input type="text" data-bv-trigger="blur" id="kembali" readonly name="kembali" class="balloon kembali" value="0" style="direction:rtl;">
                                                            </span>
                                                        </div>

                                                        <div class="d-none justify-content-between mb-1" id="tampil_dp" style="font-weight: 500;">
                                                            <p class="mb-2">DP</p>
                                                            <span>
                                                              <input class="balloon dp" id="dp" name="dp" autocomplete="off" type="text" placeholder="0" style="direction: rtl;" >
                                                            </span>
                                                          </div>
  
                                                          <div class="d-none justify-content-between mb-4" id="tampil_sisa" style="font-weight: 500;">
                                                              <p class="mb-2">Sisa</p>
                                                              <span>
                                                                  <input type="text" data-bv-trigger="blur" id="sisa" readonly name="sisa" class="balloon mb-2 sisa" value="0" style="direction:rtl;">
                                                              </span>
                                                          </div>

                                                        <button type="button" id="simpan" class="submit btn btn-primary btn-lg btn-block">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        {{-- </div>
                    </div>
                </div> --}}
            </form>
        {{-- </div>
    </div>  
</div> --}}

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

        function GetTotalBayar(){
            // var subtotal = $("[class='form-control subtotal']").val();
            let subtotal = document.querySelectorAll('.subtotal');
            let totalP = 0;
            // console.log(totalP)
            subtotal.forEach(function(item){
                totalP += parseFloat(item.value);
            });
            // console.log(totalP)
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
            $('#total_harga').val(totalP);
            $('#total_penjualan').val(Number(totalP));	
        }

        $('#simpan').on('click', function(){   
            // Mengambil value / isi dari tiap inputan
            let id_pelanggan = $('#id_pelanggan').val();
            let barang = $('#id_barang').val();
            let jenis_pembayaran = $('#jenis_pembayaran').val();
            let total_harga = $('#total_harga').val();
            let bayar = $('#bayar').val();
            let format_bayar = String(bayar).replaceAll(".", '');
            let format_total_harga = String(total_harga).replace(/Rp/g, '').replaceAll(".", '');
            let dp = $('#dp').val();
            let format_dp = String(dp).replaceAll(".", '');
            let diskon = $('.discount').val();

            // Mengecek apakah ada inputan yang kosong apa tidak
            if (diskon == 0) {
                $('.discount').val(0);
            }

            if(id_pelanggan == "") {
                Swal.fire('Isi data pelanggan terlebih dahulu')
                return false;
            } else {
                $('#id_pelanggan').val();
            }

            if(barang == "") {
                Swal.fire('Tambahkan produk terlebih dahulu')
                return false;
            } else {
                $('#id_barang').val();
            }
            
            if(jenis_pembayaran == '1') {
                if(format_bayar == 0) {
                    Swal.fire('Masukan jumlah uang bayar terlebih dahulu')
                    return false;
                } else {
                    if(parseFloat(format_bayar) < format_total_harga) {
                        Swal.fire('Jumlah uang bayar kurang')
                        return false;
                    } else {
                        $('#bayar').val();
                    }    
                }
            }else if(jenis_pembayaran == '2'){
                if(dp == 0) {
                    Swal.fire('Masukan jumlah uang dp terlebih dahulu')
                    return false;
                } else {
                    if(parseFloat(format_dp) > format_total_harga) {
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
            window.open(newPage);
            document.getElementById('form-transaksi').submit();
            newPage.location.reload();
        });

        $('#barcode').on('keypress',function(e) {
            if(e.which == 13) {
                enterProduk()
            }
        });

        $(document).on('change', '#jenis_pembayaran', function () {  
            var isiJenis = $('#jenis_pembayaran').val();
            if (isiJenis == '1') {
                $("#bayar").val('');
                $("#kembali").val('');
                $("#dp").val(0);
                $("#sisa").val(0);

                $('div#tampil_bayar').removeClass('d-none').addClass('d-flex');
                $('div#tampil_kembali').removeClass('d-none').addClass('d-flex');
                $('div#tampil_dp').removeClass('d-flex').addClass('d-none');
                $('div#tampil_sisa').removeClass('d-flex').addClass('d-none');
            } else if(isiJenis == '2') {
                $("#dp").val('');
                $("#sisa").val('');
                $("#bayar").val(0);
                $("#kembali").val(0);
                
                $('div#tampil_bayar').removeClass('d-flex').addClass('d-none');
                $('div#tampil_kembali').removeClass('d-flex').addClass('d-none');
                $('div#tampil_dp').removeClass('d-none').addClass('d-flex');
                $('div#tampil_sisa').removeClass('d-none').addClass('d-flex');
            } 
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
                // rowBarang+="<img src='1' alt='' width='70' class='img-fluid rounded shadow-sm'>";
                rowBarang+="<div class='ml-3 d-inline-block align-middle'>";
                rowBarang+="<input type='hidden' name='item["+count+"][id_barang]' id='id_barang' value='"+id_barang+"'>"
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
                rowBarang+="<input type='hidden' name='item["+count+"][harga_beli]' value='"+harga_beli+"' id='harga_beli"+count+"'>"
                rowBarang+="<input type='hidden' name='item["+count+"][keuntungan]' value='"+keuntungan+"' id='keuntungan"+count+"'>"
                rowBarang+="<strong id='displayST"+count+"'>"+format_harga_jual+"</strong></td>"
                rowBarang+="<td class='border-0 align-middle'><button type='button' class='text-dark hapus_penjualan' data-idbuffer='"+count+"'><i class='fa fa-trash' style='outline:none;'></i></a></td>";
                $('#t_penjualan').append(rowBarang);
            } else{
                var posisi = CariPosisi(id_barang);
                var qty = Number($('#qty'+posisi).val())+1;
                $('#qty'+posisi).val(qty);
                var discount = $('#discount' + posisi).val();
                const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
                var format_subtotal =   Math.round(subtotal).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (subtotal + '').replace('.', '').length
                                    });
                $('#subtotal'+posisi).val(subtotal);
                $('#displayST' + posisi).text(format_subtotal);

            }
                GetTotalBayar();
                // GetKeuntungan();
                var id = $('.qty_penjualan').data("idbuffer");
        }

        //UBAH DISCOUNT
        $(document).on('keyup change', '.discount', function () {
            var id = $(this).data("idbuffer");
            // $(this).attr('value', '');  
            var discount = $('#discount' + id).val();
            var harga_jual = $('#harga_jual' + id).val();
            var qty = $('#qty' + id).val();

            if(discount > 100) {
                var hasil = (harga_jual *qty) * 100/100;
            } else {
                var hasil = (harga_jual *qty) * discount/100;                
            }
            var format_subtotal =   Math.round(Number((harga_jual * qty) - hasil)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: ((harga_jual * qty) - hasil + '').replace('.', '').length
                                    });
        
            $('#subtotal' + id).val((harga_jual * qty) - hasil);
            $('#displayST' + id).text(format_subtotal);
            
            let jenis_pembayaran = $('#jenis_pembayaran').val();

            var subtotal = document.querySelectorAll('.subtotal');
            var totalP = 0;
            subtotal.forEach(function(item){
                totalP += parseFloat(item.value);
            });

            if (jenis_pembayaran == '1') {
                // Perhitungan Bayar Tunai
                let bayar = $('#bayar').val().replaceAll(".", '');

                if(bayar > 0){
                    let kembali = bayar - totalP;
                    let kembali_makerp = Math.round(Number(kembali)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (kembali + '').replace('.', '').length
                                    });
                
                    $('#kembali').val(kembali_makerp.replace(/Rp/g, ''));   
                }
                
                //Perhitungan Bayar DP
            } else if (jenis_pembayaran == '2') {
                let dp = $('#dp').val();
                let format_dp = String(dp).replaceAll(".", '');
                let sisa = totalP - format_dp;
                let sisa_makerp = Number(sisa).toLocaleString("id-ID", {
                                    style:"currency",
                                    currency:"IDR",
                                    maximumSignificantDigits: (sisa + '').replace('.', '').length
                                });
    
                $('#sisa').val(sisa_makerp.replace(/Rp/g, ''));      
            }

            GetTotalBayar();
        });
            

        //UBAH QTY
        $(document).on('click', '#plus', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();

            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
            var format_subtotal =   Math.round(Number(subtotal)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (subtotal + '').replace('.', '').length
                                    });
            
            $('#displayST' + id).text(format_subtotal);
            $('#subtotal' + id).val(subtotal);

            let jenis_pembayaran = $('#jenis_pembayaran').val();
            var sT = document.querySelectorAll('.subtotal');
            var totalP = 0;
            sT.forEach(function(item){
                totalP += parseFloat(item.value);
            });
            //Perhitungan Bayar Tunai
            if (jenis_pembayaran == '1') {
                let bayar = $('#bayar').val().replaceAll(".", '');
                if(bayar > 0){
                    let kembali = bayar - totalP;
                    let kembali_makerp = Math.round(Number(kembali)).toLocaleString("id-ID", {
                                        style:"currency", 
                                        currency:"IDR", 
                                        maximumSignificantDigits: (kembali + '').replace('.', '').length
                                        });
        
                    $('#kembali').val(kembali_makerp.replace(/Rp/g, ''));  
                }
                
            //Perhitungan Bayar DP
            } else if (jenis_pembayaran == '2') {
                let dp = $('#dp').val();
                let format_dp = String(dp).replaceAll(".", '');
                let sisa = totalP - format_dp;
                let sisa_makerp = Number(sisa).toLocaleString("id-ID", {
                                    style:"currency",
                                    currency:"IDR",
                                    maximumSignificantDigits: (sisa + '').replace('.', '').length
                                });
    
                $('#sisa').val(sisa_makerp.replace(/Rp/g, ''));      
            }
            GetTotalBayar();
        });

        $(document).on('click', '#minus', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();

            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
            var format_subtotal =   Math.round(Number(subtotal)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (subtotal + '').replace('.', '').length
                                    });

            $('#displayST' + id).text(format_subtotal);
            $('#subtotal' + id).val(subtotal);

            let jenis_pembayaran = $('#jenis_pembayaran').val();

            var sT = document.querySelectorAll('.subtotal');
            var totalP = 0;
            sT.forEach(function(item){
                totalP += parseFloat(item.value);
            });
            //Perhitungan Bayar Tunai
            if (jenis_pembayaran == '1') {
                let bayar = $('#bayar').val().replaceAll(".", '');
                if(bayar > 0){
                    
                    let kembali = bayar - totalP;
                    let kembali_makerp = Math.round(Number(kembali)).toLocaleString("id-ID", {
                                        style:"currency", 
                                        currency:"IDR", 
                                        maximumSignificantDigits: (kembali + '').replace('.', '').length
                                        });
        
                    $('#kembali').val(kembali_makerp.replace(/Rp/g, ''));   
                }
                
            //Perhitungan Bayar DP
            } else if (jenis_pembayaran == '2') {
                let dp = $('#dp').val();
                let format_dp = String(dp).replaceAll(".", '');
                let sisa = totalP - format_dp;
                let sisa_makerp = Number(sisa).toLocaleString("id-ID", {
                                    style:"currency",
                                    currency:"IDR",
                                    maximumSignificantDigits: (sisa + '').replace('.', '').length
                                });
    
                $('#sisa').val(sisa_makerp.replace(/Rp/g, ''));      
            }

            GetTotalBayar();
        });

        $(document).on('keyup change', '.qty_penjualan', function () {
            var id = $(this).data("idbuffer");
            var harga_jual = $('#harga_jual' + id).val();
            var qty = $('#qty' + id).val();
            var discount = $('#discount' + id).val();
            const subtotal = harga_jual * qty - ((harga_jual * qty) * discount/100)
            var format_subtotal =   Math.round(Number(subtotal)).toLocaleString("id-ID", {
                                    style:"currency", 
                                    currency:"IDR", 
                                    maximumSignificantDigits: (subtotal + '').replace('.', '').length
                                    });
            $('#displayST' + id).text(format_subtotal);
            $('#subtotal' + id).val(subtotal);

            let jenis_pembayaran = $('#jenis_pembayaran').val();
            var sT = document.querySelectorAll('.subtotal');
            var totalP = 0;
            sT.forEach(function(item){
                totalP += parseFloat(item.value);
            });
            //Perhitungan Bayar Tunai
            if (jenis_pembayaran == '1') {
                let bayar = $('#bayar').val().replaceAll(".", '');
                if(bayar > 0){
                    let kembali = bayar - totalP;
                    let kembali_makerp = Math.round(Number(kembali)).toLocaleString("id-ID", {
                                        style:"currency", 
                                        currency:"IDR", 
                                        maximumSignificantDigits: (kembali + '').replace('.', '').length
                                        });
        
                    $('#kembali').val(kembali_makerp.replace(/Rp/g, ''));   
                }
                
            //Perhitungan Bayar DP
            } else if (jenis_pembayaran == '2') {
                let dp = $('#dp').val();
                let format_dp = String(dp).replaceAll(".", '');
                let sisa = totalP - format_dp;
                let sisa_makerp = Number(sisa).toLocaleString("id-ID", {
                                    style:"currency",
                                    currency:"IDR",
                                    maximumSignificantDigits: (sisa + '').replace('.', '').length
                                });
    
                $('#sisa').val(sisa_makerp.replace(/Rp/g, ''));      
            }

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

        // DP
        $(document).on('keyup change', '#dp', function () {
            var total_harga = $("#total_harga").val().replace(/Rp/g, '').replace('.', '');
            var dp = $(this).val();
            var format_dp = String(dp).replaceAll(".", '');

            var sisa = total_harga - parseFloat(format_dp);
            let sisa_makerp = Number(sisa).toLocaleString("id-ID", {
                                style:"currency",
                                currency:"IDR",
                                maximumSignificantDigits: (sisa + '').replace('.', '').length
                            });

            $('#sisa').val(sisa_makerp.replace(/Rp/g, ''));      
        });

        //KEMBALIAN
        $(document).on('keyup change', '#bayar', function (e) {
            var total_harga = $("#total_harga").val().replace(/Rp/g, '').replace('.', '');
            var bayar = $(this).val().replaceAll(".", '');;

            let kembali = bayar - total_harga;
            let kembali_makerp = Math.round(Number(kembali)).toLocaleString("id-ID", {
                                style:"currency", 
                                currency:"IDR", 
                                maximumSignificantDigits: (kembali + '').replace('.', '').length
                                });

            $('#dp').val(0);
            $('#kembali').val(kembali_makerp.replace(/Rp/g, ''));      
        });

        $(document).on('click','.hapus_penjualan',function(){
            var delete_row= $(this).data("idbuffer");
            let deleted_sub = Number($('#subtotal'+delete_row).val());
            let kurangiTotal = Number($('#total_harga').val().replace(/Rp/g, '').replace('.', ''));
            kurangiTotal -= deleted_sub;
            //hapus pada table
            $('#buffer'+delete_row).remove(); 
            // count--;

            console.log(kurangiTotal)
            let total = Math.round(Number(kurangiTotal)).toLocaleString("id-ID", {
                            style:"currency", 
                            currency:"IDR", 
                            maximumSignificantDigits: (kurangiTotal + '').replace('.', '').length
                        });
            $('#bayar').val(parseFloat(kurangiTotal));
            $('#displayTotal').text(total);	
            $('#total_harga').val(parseFloat(total.replace(/Rp/g, '').substr(1)));	
            $('#total_penjualan').val(parseFloat(total.replace(/Rp/g, '').substr(1)));	
        });


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
                $('#alert_stock').html(data_stok);       
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
