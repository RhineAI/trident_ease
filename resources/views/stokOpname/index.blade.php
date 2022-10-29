@extends('templates.layout')

@section('title')
    <title>Stock Opname | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Stock Opname
@endsection

@section('breadcrumb')
@parent
    Stock Opname
@endsection

@push('styles')

@endpush

@section('contents')
  
      <!-- Main content -->
      <section class="content">
        <div class="row mx-4">
            <div class="col-lg-12" style="background-color: white;">
                <div class="box-body">
        
                    <div class="box-body mx-2 my-2">
                        <h3 class="text-center mb-5 mt-4">Stock Opname</h3>
                        <form class="form-pelanggan" method="post">
                            @csrf
                            
                            <div class="form-group row mb-3">
                                <label for="kode_produk" class="col-lg-2 control-label">Tambah Produk</label>
                                <div class="col-lg-4">
                                    <div class="input-group">
                                        <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                        <span class="input-group-btn tampil-produk">
                                            {{-- <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button> --}}
                                            <button onclick="tampilProduk()" id="tampil" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-lg-1"></div>
                                <label for="kode_produk" class="col-lg-1 control-label">Tanggal</label>
                                <div class="col-lg-4">
                                    <input type="date" class="form-control" name="tgl" id="tgl" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive mt-3">
                                <table cellpaddong="0" cellspacing="0" class="table table-striped table-bordered" id="buffer_table">
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
                                    <tbody id="t_penjualan">
                                        <tr id="buffer100" height="50px">
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
        
                    <div class="box-footer mb-4 btn-submit pull-right">
                        <button type="submit" class="btn btn-outline-primary btn-sm btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
  
    @include('stokOpname.formBarang')
    </section>
@endsection

@push('scripts') 
    <script>
        $('body').addClass('sidebar-collapse');

        function tampilProduk() {
            $('#formModalStockOpname').modal('show');
            $('#tbl-data-stock-opname').DataTable();
        }

        function hideProduk() {
            $('#formModalStockOpname').modal('hide');
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


            $(document).on('click','.add_barang',function(){
                var id = $(this).data("id_barang");
                var kode = $(this).data("kode_barang");
                var nama = $(this).data("nama_barang");
                var nama_kategori = $(this).data("nama_kategori");
                var nama_merek = $(this).data("nama_merek");
                var stok_awal = $(this).data("stok_awal");
                TambahDataPenjualan(id,kode,nama,nama_kategori,nama_merek,stok_awal);
            }); 

            function TambahDataPenjualan(id,kode,nama,nama_kategori,nama_merek,stok_awal){
                var id_barang=id;
                var kode_barang=kode;
                var nama_barang=nama;
                var nama_kategori=nama_kategori;
                var nama_merek=nama_merek;
                var stok_awal=stok_awal;

                var barang=CariIdBarang(id_barang);

                if(barang==false){
                    //HAPUS BARIS 1
                    $('#buffer100').remove();
                    count++;
                    //alert(count);
                    var rowBarang="<tr id='buffer"+count+"'>";
                    rowBarang+="<td style='text-align:center'><input type='hidden' name='item["+count+"][id_barang]' value='"+id_barang+"'> <input class='form-control' type='text' name='item["+count+"][kode]' value='"+kode_barang+"' readonly='true'></td>";
                    rowBarang+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_barang]' value='"+nama_barang+"' readonly='true'></td>";
                    rowBarang+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_kategori]' value='"+nama_kategori+"' readonly='true'></td>";
                    rowBarang+="<td style='text-align:center'><input class='form-control' type='text' name='item["+count+"][nama_merek]' value='"+nama_merek+"' readonly='true'></td>";
                    rowBarang+="<td style='text-align:center'><input class='form-control' type='hidden' name='item["+count+"][stock_awal]' value='"+stok_awal+"'><input class='form-control' type='number' name='item["+count+"][stock]'></td>";
                    rowBarang+="<td style='text-align:center;'><button type='button' class='btn btn-danger hapus_penjualan' data-idbuffer='"+count+"' ><i class='fa fa-trash'></i></button></td>";
                    rowBarang+="</tr>";
                    $('#t_penjualan').append(rowBarang);
                }else{
                    var posisi=CariPosisi(id_barang);
                    var qty=Number($('#qty'+posisi).val())+1;
                    $('#qty'+posisi).val(qty);
                    $('#subtotal'+posisi).val(harga_jual*qty);
                }
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
            

            $(document).on('click','.hapus_penjualan',function(){
                var delete_row=$(this).data("idbuffer");
                $('#buffer'+delete_row).remove(); 
                count--;
            });
                
        });


    </script>
@endpush
