@extends('templates.layout')

@section('title')
    <title>Retur Penjualan | {{ $cPerusahaan->nama }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('page')
    Retur Penjualan
@endsection

@section('breadcrumb')
@parent
    Retur Penjualan
@endsection

@push('styles')
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

                        <form class="form-pelanggan" method="post">
                            @csrf
                            
                        <div class="form-group row">
                            <label for="id_penjualan" class="col-lg-2 control-label">Retur Penjualan</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" name="id_penjualan" id="id_penjualan" class="form-control" required autofocus readonly>
                                    <span class="input-group-btn tampil-produk">
                                        {{-- <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button> --}}
                                        <button onclick="tampilPenjualan()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                    </span>
                                </div>
                            </div>

                            <label for="nama_pelanggan" class="col-lg-2 control-label">Nama Pelanggan</label>
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" required autofocus readonly>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
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
                            <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered" id="buffer_table">
                                <thead>
                                <tr>
                                        <th class="text-center">Kode</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">QTY Penjualan</th>
                                        <th class="text-center">Sub Total</th>
                                        <th class="text-center">Aksi</th>
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

                        <div class="table-responsive">
                            <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered" id="buffer_table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Kode</th>
                                        <th class="text-center">Nama Barang</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">QTY Penjualan</th>
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
                
                <div class="col-sm-6">

                    <!--KEUNTUNGAN-->
                    <input class="form-control" type="hidden" name="retur_keuntungan" value="" data-bv-trigger="blur"
                        id="retur_keuntungan" readonly="true">
    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">TOTAL RETUR</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp. <span>
                                    </div>
                                <input class="form-control" type="text" name="total_retur" value=""
                                    data-bv-trigger="blur" id="total_retur" readonly="true" style='text-align:right'>
                            </div>
                        </div>
                    </div>
                </div>  
                {{-- <div class="col-sm-6">
                    <!--KEUNTUNGAN-->
                    <input class="form-control" type="hidden" name="retur_keuntungan" value="" data-bv-trigger="blur" id="retur_keuntungan" readonly="true">
            
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">TOTAL RETUR</label>       
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-addon">
                                Rp.
                                </div>&nbsp; &nbsp;
                                <input class="form-control" type="text" name="total_retur" value="" data-bv-trigger="blur" id="total_retur" readonly="true" style='text-align:right'>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>

            

            <div class="box-footer mb-4 btn-submit">
                <button type="submit" id="submit"
                    class="btn btn-outline-primary btn-sm pull-right btn-simpan"><i
                        class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
            </div>
        </div>
    </div>
    </div>
    @include('returPenjualan.dataPenjualan')
    </form>

</section>
@endsection

@push('scripts') 
    <script>
        $('body').addClass('sidebar-collapse');

        $(document).on('click', '#submit', function(){
                let total_retur = $('#total_retur').val();
                let retur = $('.retur').val();
                let penjualan = $('.id_penjualan').val();

                if(penjualan == 0) {
                    Swal.fire('Isi Data Penjualan yang ingin di Retur')
                    return false;
                } else {
                    $('#id_penjualan').val();
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

        function tampilPenjualan() {
            $('#formModalReturPenjualan').modal('show');
            $('#tbl-data-retur-penjualan').DataTable();
        }

        function hidePenjualan() {
            $('#formModalReturPenjualan').modal('hide');
        }

        function cekQty(qty) {
            if(Number(qty.value) < 0){
                qty.value = 1;
                Swal.fire('QTY tidak boleh kurang dari 0!')
                return false;
            } else if (Number(qty.value) > Number(qty.max)){
                qty.value = qty.max;
                Swal.fire('QTY melebihi produk yang dibeli!');
                GetTotalBayar()
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

            $(document).on('click','.restrict-retur',function(){
                Swal.fire('Seluruh Barang Ini Telah Di Retur')
                return false;   
            }); 

            $(document).on('click','.add_penjualan',function(){
                var id = $(this).data("id_penjualan");
                var tgl = $(this).data("tgl");
                var nama_pelanggan = $(this).data("nama_pelanggan");
                var tlp_pelanggan = $(this).data("tlp_pelanggan");
                var id_pelanggan = $(this).data("id_pelanggan");
                $('#nama_pelanggan').val(nama_pelanggan);
                $('#tlp').val(tlp_pelanggan);
                $('#id_penjualan').val(id);
                $('#t_penjualan #buffer100').remove();

                $.ajax({
                    type: 'POST',
                    url:"{{ route('retur-penjualan.data') }}",
                    data: {
                        id: id,
                        _token: "{{ csrf_token() }}"
                    },
                    cache: false,
                    success:function(response){
                        // console.log(response)
                        $('#t_penjualan').html(response);
                    }
                })
            }); 

            $(document).on('click','.add_retur',function(){
                var id=$(this).data("idbuffer");
                var id_barang=$('#id_barang'+id).val();
                var kode=$('#kode'+id).val();
                var nama_barang=$('#nama_barang'+id).val();
                var harga_beli=$('#harga_beli'+id).val();
                var harga_jual=$('#harga_jual'+id).val();
                var qty=$('#qty'+id).val();
                var subtotal=$('#subtotal'+id).val();
                console.log(id_barang, kode, nama_barang, harga_beli, harga_jual, qty, subtotal)

                var search=CariIdBarang(id_barang);
                if(search==false){
                //HAPUS BARIS 1
                $('#t_retur #buffer100').remove();
                count++;
                var html_code="<tr id='buffer"+count+"'>";

                html_code+="<td style='text-align:center'><input type='hidden' name='item["+count+"][id_barang_retur]' value='"+id_barang+"' > <input class='form-control' type='text' name='item["+count+"][kode_retur]' value='"+kode+"' readonly='true'></td>";
                html_code+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang_retur]' value='"+nama_barang+"' readonly='true'></td>";
                html_code+="<td><input class='form-control' style='text-align:right' type='text' name='item["+count+"][harga_jual_retur]' value='"+harga_jual+"' id='harga_jual_retur"+count+"' readonly='true'><input type='hidden' name='item["+count+"][harga_beli_retur]' value='"+harga_beli+"'  id='harga_beli_retur"+count+"' ></td>";
                html_code+="<td style='text-align:center; width: 8%;'><input type='number' class='form-control qty_retur' data-idbuffer='"+count+"' name='item["+count+"][qty_retur]' value='1' max='"+qty+"' id='qty_retur"+count+"' onkeypress='cek_number()' onchange='cekQty(this)'></td>";
                html_code+="<td style='text-align:center;'><input style='text-align:right' type='number' class='form-control' name='item["+count+"][subtotal_retur]' value='"+harga_jual*qty+"' readonly='true' id='subtotal_retur"+count+"'></td>";
                html_code+="<td style='text-align:center;'><button type='button' class='btn btn-danger hapus_retur' data-idbuffer='"+count+"' ><i class='fas fa-minus'></i></button></td>";
                html_code+="</tr>";
                //alert (html_code);
                $('#t_retur').append(html_code);
                GetTotalBayar();
                GetKeuntungan();
                } else {
                    var posisi = CariPosisi(id_barang);
                    var qty = Number($('#qty_retur'+posisi).val())+1;
                    $('#qty_retur'+posisi).val(qty);
                    $('#subtotal_retur'+posisi).val(harga_beli*qty);
                }



            });

            // function TambahDataPenjualan(id,tgl,nama_pelanggan,tlp_pelanggan,id_pelanggan,kode,nama_barang, harga, qty){
            //     var id_penjualan=id;
            //     var tgl=tgl;
            //     var nama_pelanggan=nama_pelanggan;
            //     var tlp_pelanggan=tlp_pelanggan;
            //     var id_pelanggan=id_pelanggan;
            //     var kode=kode;
            //     var nama_barang=nama_barang;
            //     var harga=harga;
            //     var qty=qty;

            //     var penjualan=CariIdBarang(id_penjualan);

            //     if(penjualan==false){
            //         //HAPUS BARIS 1
            //         $('#buffer100').remove();
            //         count++;
            //         //alert(count);
            //         var rowPenjualan="<tr id='buffer"+count+"'>";
            //         rowPenjualan+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][kode]' value='"+kode+"' readonly='true'></td>";
            //         rowPenjualan+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang]' value='"+nama_barang+"' readonly='true'></td>";
            //         rowPenjualan+="<td style='text-align:center'><input class='form-control' type='number' name='item["+count+"][harga]' value='"+harga+"' readonly='true'></td>";
            //         rowPenjualan+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][qty]' value='"+qty+"' readonly='true'></td>";
            //         rowPenjualan+="<td style='text-align:center'><input class='form-control' type='number' name='item["+count+"][subtotal]' value='"+harga*qty+"' readonly></td>";
            //         rowPenjualan+="<td style='text-align:center;'><button type='button' class='btn btn-info hapus_penjualan' data-idbuffer='"+count+"' ><i class='fa fa-plus'></i></button></td>";
            //         rowPenjualan+="</tr>";
            //         $('#t_penjualan').append(rowPenjualan);
            //     }else{
            //         var posisi=CariPosisi(id_penjualan);
            //         var qty=Number($('#qty'+posisi).val())+1;
            //         $('#qty'+posisi).val(qty);
            //         $('#subtotal'+posisi).val(harga_jual*qty);
            //     }
            // }


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

            function GetTotalBayar(){
                var total_retur=0;
                //HASILKAN TOTAL RETUR
                for(x=1;x<=count;x++){
                    total_retur+= Number($("input[name='item["+x+"][subtotal_retur]']").val());
                }
                $('#total_retur').val(Number(total_retur));
            }

            function GetKeuntungan(){
                var keuntungan=0;
                var hargabeli=0;
                var hargajual=0;
                var qty=0;
                //HASILKAN TOTAL BAYAR
                for(x=1;x<=count;x++){
                    hargabeli=$("input[name='item["+x+"][harga_beli_retur]']").val();
                    hargajual=$("input[name='item["+x+"][harga_jual_retur]']").val();
                    qty=$("input[name='item["+x+"][qty_retur]']").val();
                    keuntungan+= (hargajual-hargabeli)*qty;
                }
                $('#retur_keuntungan').val(keuntungan); 
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
            

            $(document).on('click','.hapus_retur',function(){
                var delete_row=$(this).data("idbuffer");
                console.log(delete_row)
                $('#buffer'+delete_row).remove(); 
                count--;
                GetTotalBayar();
                GetKeuntungan();
            });
            
            $(document).on('keyup','.qty_retur',function(){
                var id=$(this).data("idbuffer");
                var harga_jual=$('#harga_jual_retur'+id).val();
                var qty=$('#qty_retur'+id).val();
                console.log(qty)
                $('#subtotal_retur'+id).val(harga_jual*qty);
                GetTotalBayar();
                GetKeuntungan();
            //alert(harga_jual);
            });
        });


    </script>
@endpush
