@extends('templates.layout')

@section('title')
    <title>Retur Pembelian | {{ $cPerusahaan->nama }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page')
    Retur Pembelian
@endsection

@section('breadcrumb')
@parent
    Retur Pembelian
@endsection

@push('styles')
<style>
    @media screen and (min-width: 0px) and (max-width: 480px) {
        .form-supplier {
            width: 98%;
            margin-left:-5%;
        }

        .dataTables_filter input[type="search"] {
            /* font-size: 20px; */
            /* padding: 4px 8px; */
        }
    }

    @media screen and (min-width: 481px) and (max-width:769px) {
        .form-supplier {
            width: 98%;
            margin-left:-5%;
        }

        .dataTables_filter input[type="search"] {
            font-size: 10px; 
            padding: 4px 8px;
        }
    }

    @media screen and (min-width: 770px)  and (max-width: 1024px) {
        .form-supplier {
            width: 98%;
            margin-left:-5%;
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

                            <div class="form-group row mb-1">
                                <label for="id_pembelian" class="col-lg-2 control-label">Retur Pembelian</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="id_pembelian" id="id_pembelian" class="form-control"
                                            required autofocus readonly>
                                        <span class="input-group-btn tampil-produk">
                                            {{-- <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button> --}}
                                            <button onclick="tampilPembelian()" id="tampil"
                                                class="btn btn-info btn-flat" type="button"><i
                                                    class="fa-solid fa-magnifying-glass"></i></button>
                                        </span>
                                    </div>
                                </div>

                                <label for="nama_supplier" class="col-lg-2 control-label">Nama Supplier</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="nama_supplier" id="nama_supplier"
                                            class="form-control" required autofocus readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <label for="tgl" class="col-lg-2 control-label">Tanggal</label>
                                <div class="col-lg-4">
                                    <input type="date" class="form-control" name="tgl" id="tgl" readonly>
                                </div>

                                <label for="tlp" class="col-lg-2 control-label">Telepon</label>
                                <div class="col-lg-4">
                                    <input type="text" class="form-control" name="tlp" id="tlp" readonly>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered"
                                    id="buffer_table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Kode</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Sub Total</th>
                                            <th class="text-center">Aksi</th>
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
                            <br>
                            <div class="table-responsive">
                                <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered"
                                    id="buffer_table">
                                    <thead>
                                        <tr>
                                            <th  class="text-center">Kode</th>
                                            <th class="text-center">Nama Barang</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">QTY</th>
                                            <th class="text-center">Sub Total</th>
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="t_retur">
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
                                <div class="col-lg-8">
                                </div>
                                <div class="col-lg-3 ml-5">
                                    <!--KEUNTUNGAN-->
                                    <input class="form-control" type="hidden" name="retur_keuntungan" value="" data-bv-trigger="blur"
                                        id="retur_keuntungan" readonly="true">
                    
                                    <div class="form-group mr-1">
                                        <label for="inputEmail3" class="col-sm-4 control-label">TOTAL RETUR</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp. <span>
                                            </div>
                                            <input class="form-control" type="text" name="total_retur" value=""
                                                data-bv-trigger="blur" id="total_retur" readonly="true"
                                                style='text-align:right'>
                                        </div>
                                    </div>
    
                                    <div class="box-footer mb-4 btn-submit " style="float: right;">
                                        <button type="submit" id="submit" class="btn btn-outline-primary btn-sm pull-right btn-simpan" onkeypress="preventEnter(this)"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                                    </div>  
                                </div>   
                            </div> 
                      </div>



                      {{-- <div class="box-footer mb-4 btn-submit">
                          <button type="submit" id="submit"
                              class="btn btn-outline-primary btn-sm pull-right btn-simpan"><i
                                  class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                      </div> --}}
                  </div>
              </div>
          </div>
          @include('returPembelian.dataPembelian')
          </form>

      </section>
@endsection

@push('scripts') 
    <script>
        $('body').addClass('sidebar-collapse');

        $(document).on('click', '#submit', function(){
                let total_retur = $('#total_retur').val();
                let retur = $('.retur').val();
                let pembelian = $('.id_pembelian').val();

                if(pembelian == 0) {
                    Swal.fire('Isi Data Pembelian yang ingin di Retur')
                    return false;
                } else {
                    $('#id_pembelian').val();
                }

                if(retur == 0) {
                    Swal.fire('Tambahkan Retur terlebih dahulu')
                    return false;
                } else {
                    $('#retur').val();
                }   

                if(total_retur == 0) {
                    Swal.fire('Total Retur Barang tidak ada, Tambahkan Retur terlebih dahulu')
                    return false;
                } else {
                    $('#total_retur').val();
                } 
        });

        function tampilPembelian() {
            $('#formModalReturPembelian').modal('show');
            $('#tbl-data-retur-pembelian').DataTable();
        }

        function hidePembelian() {
            $('#formModalReturPembelian').modal('hide');
        }

        function cekQty(qty) {
            let id = qty.getAttribute("data-idbuffer")
            if(Number(qty.value) < 0){
                qty.value = 1;
                Swal.fire('QTY tidak boleh kurang dari 0!')
                return false;
            } else if (Number(qty.value) > Number(qty.max)){
                qty.value = qty.max;
                var harga_beli=$('#harga_beli_retur'+id).val();
                var qty=$('#qty_retur'+id).val();
                $('#subtotal_retur'+id).val(harga_beli*qty);
                var subtotal = document.querySelectorAll('.subtotal');
                var totalP = 0;
                subtotal.forEach(function(item){
                    totalP += parseFloat(item.value);
                });
                // console.log(totalP)
                $('#total_retur').val(Number(totalP));
                
                Swal.fire('QTY melebihi produk yang dibeli!')
                // GetTotalBayar();
                return false;
            } else {
                qty.value = qty.value;
            }
        }

        $.ajaxSetup({
            headers: {
                '_token': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $(document).ready(function(){
            var subtotal=0;
            var discount=0;
            var total=0;
            var count=0;

            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2)
            var month = ("0" + (now.getMonth() + 1)).slice(-2)
            var today = now.getFullYear()+"-"+(month)+"-"+(day)
            $('#tgl').val(today) 

            // 
            $(document).on('click','.restrict-retur',function(){
                Swal.fire('Seluruh Barang Ini Telah Di Retur')
                return false;   
            }); 

            $(document).on('click','.add_pembelian',function(){
                var id = $(this).data("id_pembelian");
                var tgl = $(this).data("tgl");
                var nama_supplier = $(this).data("nama_supplier");
                var tlp_supplier = $(this).data("tlp_supplier");
                var id_supplier = $(this).data("id_supplier");
                $('#nama_supplier').val(nama_supplier);
                $('#tlp').val(tlp_supplier);
                $('#id_pembelian').val(id);
                $('#t_pembelian #buffer100').remove();
                $('#t_retur #buffer100').remove();

                $.ajax({
                    type: 'POST',
                    url:"{{ route('admin.retur-pembelian.data') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    success:function(response){
                        // console.log(response)
                        $('#t_pembelian').html(response);
                    }
                })
            }); 

            $(document).on('click','.add_retur',function(){
                var id=$(this).data("idbuffer");
                var id_barang=$('#id_barang'+id).val();
                var kode=$('#kode'+id).val();
                var nama_barang=$('#nama_barang'+id).val();
                var harga_beli=$('#harga_beli'+id).val();
                // var harga_beli=$('#harga_beli'+id).val();
                var qty=$('#qty'+id).val();
                var subtotal=$('#subtotal'+id).val();
                // console.log(id_barang, kode, nama_barang, harga_beli, qty, subtotal)

                var search=CariIdBarang(id_barang);
                if(search==false){
                //HAPUS BARIS 1
                    $('#t_retur #buffer100').remove();
                    count++;
                    var html_code="<tr id='buffer"+count+"'>";

                    html_code+="<td style='text-align:center'><input type='hidden' name='item["+count+"][id_barang_retur]' value='"+id_barang+"' > <input class='form-control' type='text' name='item["+count+"][kode_retur]' value='"+kode+"' readonly='true' style='width: 130px'></td>";
                    html_code+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang_retur]' value='"+nama_barang+"' readonly='true' style='width: 175px'></td>";
                    html_code+="<td><input class='form-control' style='text-align:right; width: 170px;' type='text' name='item["+count+"][harga_beli_retur]' value='"+harga_beli+"' id='harga_beli_retur"+count+"' readonly='true'></td>";
                    html_code+="<td style='text-align:center; width: 8%;'><input type='number' class='form-control qty_retur' data-idbuffer='"+count+"' name='item["+count+"][qty_retur]' value='1' max='"+qty+"' onchange='cekQty(this)' id='qty_retur"+count+"' style='width: 90px'></td>";
                    html_code+="<td style='text-align:center;'><input style='text-align:right; width: 200px;' type='number' class='form-control subtotal' name='item["+count+"][subtotal_retur]' value='"+harga_beli*1+"' readonly='true' id='subtotal_retur"+count+"'></td>";
                    html_code+="<td style='text-align:center;'><button type='button' class='btn btn-danger hapus_retur' data-idbuffer='"+count+"'><i class='fas fa-minus'></i></button></td>";
                    html_code+="</tr>";
                    //alert (html_code);
                    $('#t_retur').append(html_code);
                    GetTotalBayar();
                    GetKeuntungan();
                } else{
                    var posisi = CariPosisi(id_barang);
                    var qty = Number($('#qty_retur'+posisi).val())+1;
                    $('#qty_retur'+posisi).val(qty);
                    $('#subtotal_retur'+posisi).val(harga_beli*qty);
                }



            });

            function CariIdBarang(cari){
                var found = false;
                var x = 1;
                while((x<=count) && ($("input[name='item["+x+"][id_barang_retur]']").val()!=cari)){
                    x++
                }

                if($("input[name='item["+x+"][id_barang_retur]']").val()==cari){
                    found=true;
                }

                return found;
            }

            function GetTotalBayar(){
                // var subtotal = $("[class='form-control subtotal']").val();
                var subtotal = document.querySelectorAll('.subtotal');
                var totalP = 0;
                subtotal.forEach(function(item){
                    totalP += parseFloat(item.value);
                });
                // console.log(totalP)
                $('#total_retur').val(Number(totalP));	
                // $('#tampil-terbilang').text(terbilang(Number(totalP)));
            }

            // function GetTotalBayar(){
            //     var total_retur=0;
            //     //HASILKAN TOTAL RETUR
            //     for(x=1;x<=count;x++){
            //         total_retur+= Number($("input[name='item["+x+"][subtotal_retur]']").val());
            //     }
            //     $('#total_retur').val(Number(total_retur));
            // }

            function GetKeuntungan(){
                var keuntungan=0;
                var hargabeli=0;
                var hargajual=0;
                var qty=0;
                //HASILKAN TOTAL BAYAR
                for(x=1;x<=count;x++){
                    hargabeli=$("input[name='item["+x+"][harga_beli_retur]']").val();
                    qty=$("input[name='item["+x+"][qty_retur]']").val();
                    keuntungan+= hargabeli*qty;
                }
                $('#retur_keuntungan').val(keuntungan); 
            }

            function CariPosisi(cari){
                var found=false;
                var x=1;

                while((x<=count) && ($("input[name='item["+x+"][id_barang_retur]']").val()!=cari)){
                    x++
                }

                if($("input[name='item["+x+"][id_barang_retur]']").val()==cari){
                    found=true;
                }

                return x;
            }
            

            $(document).on('click','.hapus_retur',function(){
                var delete_row=$(this).data("idbuffer");
                // console.log(delete_row)
                $('#t_retur #buffer'+delete_row).remove(); 
                // count--;
                GetTotalBayar();
                GetKeuntungan();
            });
            
            $(document).on('keyup','.qty_retur',function(){
                var id=$(this).data("idbuffer");
                var harga_beli=$('#harga_beli_retur'+id).val();
                var qty=$('#qty_retur'+id).val();
                $('#subtotal_retur'+id).val(harga_beli*qty);
                // if(qty )
                // console.log(qty)
                GetTotalBayar();
                GetKeuntungan();
            //alert(harga_beli);
            });
        });


    </script>
@endpush
