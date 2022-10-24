@extends('templates.layout')

@section('title')
    <title>Retur Penjualan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Retur Penjualan
@endsection

@section('breadcrumb')
@parent
    Retur Penjualan
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
        
                    <div class="box-body mx-2 my-2">

                        <form class="form-pelanggan" method="post">
                            @csrf
                            
                            <div class="form-group row">
                                <label for="kode_produk" class="col-lg-2 control-label">Retur Penjualan</label>
                                <div class="col-lg-5">
                                    <div class="input-group">
                                        <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                        <span class="input-group-btn tampil-produk">
                                            {{-- <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button> --}}
                                            <button onclick="tampilPenjualan()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </span>
                                    </div>
                                </div>

                                {{-- <label for="kode_produk" class="col-lg-1 control-label">Tanggal</label>
                                <div class="col-lg-4">
                                    <input type="date" class="form-control" name="tgl" id="tgl" readonly>
                                </div> --}}
                            </div>
        
                        <div class="table-responsive">
                            <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered" id="buffer_table">
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
                    </div>
        
                    <div class="table-responsive">
                        <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered" id="rtr_table">
                            <thead>
                               <tr>
                                    <th class="text-center">Kode</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Merek</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Aksi</th>
                               </tr>
                            </thead>
                            <tbody id="t_retur">
                                <tr id="rtr100" height="50px">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                    <div class="box-footer mb-4 btn-submit">
                        <button type="submit" class="btn btn-outline-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
  
    @include('returPenjualan.dataPenjualan')
    </section>
@endsection

@push('scripts') 
    <script>
        $('body').addClass('sidebar-collapse');

        function tampilPenjualan() {
            $('#formModalReturPenjualan').modal('show');
            $('#tbl-data-retur-penjualan').DataTable();
        }

        function hidePenjualan() {
            $('#formModalReturPenjualan').modal('hide');
        }


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


            $(document).on('click','.add_penjualan',function(){
                var id = $(this).data("id_penjualan");
                var tgl = $(this).data("tgl");
                var nama_pelanggan = $(this).data("nama_pelanggan");
                var tlp_pelanggan = $(this).data("tlp_pelanggan");
                var id_pelanggan = $(this).data("id_pelanggan");
                var kode = $(this).data("kode");
                var nama_barang = $(this).data("nama_barang");
                var harga = $(this).data("harga");
                var qty = $(this).data("qty");
                TambahDataPenjualan(id,tgl,nama_pelanggan,tlp_pelanggan,id_pelanggan,kode,nama_barang, harga, qty);
            }); 

            function TambahDataPenjualan(id,tgl,nama_pelanggan,tlp_pelanggan,id_pelanggan,kode,nama_barang, harga, qty){
                var id_penjualan=id;
                var tgl=tgl;
                var nama_pelanggan=nama_pelanggan;
                var tlp_pelanggan=tlp_pelanggan;
                var id_pelanggan=id_pelanggan;
                var kode=kode;
                var nama_barang=nama_barang;
                var harga=harga;
                var qty=qty;

                var penjualan=CariIdBarang(id_penjualan);

                if(penjualan==false){
                    //HAPUS BARIS 1
                    $('#buffer100').remove();
                    count++;
                    //alert(count);
                    var rowPenjualan="<tr id='buffer"+count+"'>";
                    rowPenjualan+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][kode]' value='"+kode+"' readonly='true'></td>";
                    rowPenjualan+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang]' value='"+nama_barang+"' readonly='true'></td>";
                    rowPenjualan+="<td style='text-align:center'><input class='form-control' type='number' name='item["+count+"][harga]' value='"+harga+"' readonly='true'></td>";
                    rowPenjualan+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][qty]' value='"+qty+"' readonly='true'></td>";
                    rowPenjualan+="<td style='text-align:center'><input class='form-control' type='number' name='item["+count+"][subtotal]' value='"+harga*qty+"'></td>";
                    rowPenjualan+="<td style='text-align:center;'><button type='button' class='btn btn-danger hapus_penjualan' data-idbuffer='"+count+"' ><i class='fa fa-trash'></i></button></td>";
                    rowPenjualan+="</tr>";
                    $('#t_penjualan').append(rowPenjualan);
                }else{
                    var posisi=CariPosisi(id_penjualan);
                    var qty=Number($('#qty'+posisi).val())+1;
                    $('#qty'+posisi).val(qty);
                    $('#subtotal'+posisi).val(harga_jual*qty);
                }
            }


            function CariIdBarang(cari){
                var found = false;
                var x = 1;
                while((x<=count) && ($("input[name='item["+x+"][id_penjualan]']").val()!=cari)){
                    x++
                }

                if($("input[name='item["+x+"][id_penjualan]']").val()==cari){
                    found=true;
                }

                return found;
            }

            function CariPosisi(cari){
                var found=false;
                var x=1;

                while((x<=count) && ($("input[name='item["+x+"][id_penjualan]']").val()!=cari)){
                    x++
                }

                if($("input[name='item["+x+"][id_penjualan]']").val()==cari){
                    found=true;
                }

                return x;
            }
            

            $(document).on('click','.hapus_penjualan',function(){
                var delete_row=$(this).data("idbuffer");
                $('#buffer'+delete_row).remove(); 
                count--;
            });
                
        });


    </script>
@endpush
