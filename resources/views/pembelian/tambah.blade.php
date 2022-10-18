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
    
@endpush


@section('contents')
  
      <!-- Main content -->
      <section class="content">
  
        <!-- Default box -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Pembelian</h3>
  
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <div class="card-body">
                <!-- Button trigger modal -->
                @if(session('success'))
                    <div class="alert alert-success" role="alert" id="success-alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                @endif
                @if(session('delete'))
                    <div class="alert alert-danger" role="alert" id="success-danger">
                    {{ session('delete') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </div>
                @endif
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
                <div class="col-lg-12 mb-3" style="background-color: white;">
                    <div class="box">
                        <div class="box-header with-border p-2">
                            <table>
                                <tr>
                                    <td>Supplier</td>
                                    {{-- <td>: {{ $findSupplier->nama }}</td> --}}
                                </tr>
                                <tr>
                                    <td>Telepon</td>
                                    {{-- <td>: {{ $findSupplier->telepon }}</td> --}}
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    {{-- <td>: {{ $findSupplier->alamat }}</td> --}}
                                </tr>
                            </table>
                        </div>
                        <div class="box-body mx-2 my-2">
                                
                            <form class="form-produk">
                                @csrf
                                <div class="form-group row">
                                    <label for="kode_produk" class="col-lg-2">Tambah Produk</label>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <input type="hidden" name="id_pembelian" id="id_pembelian">
                                            <input type="hidden" name="id_produk" id="id_produk">
                                            <input type="hidden" class="form-control" name="kode_produk" id="kode_produk">
                                            <input type="text" name="barcode" id="barcode" class="form-control" required autofocus readonly>
                                            <span class="input-group-btn tampil-produk">
                                                <button onclick="tambahProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                                <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa-solid fa-magnifying-glass"></i></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                
                            <table class="table table-striped table-bordered table-pembelian">
                                <thead>
                                    <th width="4%">No</th>
                                    <th width="10%" class="text-center">Barcode</th>
                                    <th class="text-center">Nama</th>
                                    <th width="15%" class="text-center">Harga</th>
                                    <th width="12%" class="text-center">Jumlah</th>
                                    <th width="12%" class="text-center">Subtotal</th>
                                    <th width="8%"  class="text-center">Aksi</th>
                                </thead>
                            </table>
                
                            <div class="row mt-4">
                                <div class="col-lg-8">
                                    <div class="tampil-bayar bayar mb-4 ">Rp. 0 ,-</div>
                                    <div class="tampil-terbilang terbilang">Nol Rupiah</div>
                                </div>
                                <div class="col-lg-4">
                                    <form action="{{ route('pembelian.store') }}" class="form-pembelian" method="post">
                                        @csrf
                                        <input type="hidden" name="id_pembelian">
                                        <input type="hidden" name="total" id="total">
                                        <input type="hidden" name="total_item" id="total_item">
                                        <input type="hidden" name="bayar" id="bayar">
                
                                        <div class="form-group row">
                                            <label for="totalrp" class="col-lg-3 control-label">Total</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="totalrp" class="form-control" readonly>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row ">
                                            <label for="diskon" class="control-label col-lg-3">Diskon</label>
                                            <div class="col-lg-3">
                                                    <input type="number" name="diskon" id="diskon" class="form-control" placeholder="" value="0" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                            </div>
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                          
                                        <div class="form-group row">
                                            <label for="bayar" class="col-lg-3 control-label">Bayar</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="bayarrp" class="form-control" readonly>
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <label for="diterima" class="col-lg-3 control-label">Uang Diterima</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="diterima" class="form-control" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                            </div>
                                        </div>
                
                                        <div class="form-group row">
                                            <label for="kembali" class="col-lg-3 control-label">Kembalian</label>
                                            <div class="col-lg-8">
                                                <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                            </div>
                                        </div>
                
                                    </form>
                                </div>
                            </div>
                        </div>
                
                        <div class="box-footer mb-4 btn-submit">
                            {{-- <a href=""{{ route('pembelian.cancel', $pembelian->id_pembelian ) }} class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-cart-shopping"></i> Batalkan Transaksi</a> --}}
                            <button type="submit" class="btn btn-outline-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                        </div>
                    </div>
                </div>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $('#tbl-data-barang').DataTable({
          scrollX: true,
        });
    </script>
    <script>
        $(document).ready(function(){
          $('#formModalBarang').on("show.bs.modal", function(e){
            const btn = $(e.relatedTarget)
            const id_barang = btn.data('id_barang')
            const kode = btn.data('kode')
            const nama_barang = btn.data('nama_barang')
            const barcode = btn.data('barcode')
            const id_kategori = btn.data('id_kategori')
            const id_supplier = btn.data('id_supplier')
            const id_satuan = btn.data('id_satuan')
            const id_merek = btn.data('id_merek')
            const id_perusahaan = btn.data('id_perusahaan')
            const stock = btn.data('stock')
            const stock_minimal = btn.data('stock_minimal')
            const harga_beli = btn.data('harga_beli')
            const keuntungan = btn.data('keuntungan')
            const keterangan = btn.data('keterangan')
            const status = btn.data('status')
            const mode = btn.data('mode')
            const modal = $(this)
        
            if(mode === 'edit'){
                modal.find('#modal-title').text("Edit Data barang")
                modal.find('.modal-body #kode').val(kode)
                modal.find('.modal-body #nama').val(nama_barang)
                modal.find('.modal-body #barcode').val(barcode)
                modal.find('.modal-body #id_kategori').val(id_kategori)
                modal.find('.modal-body #id_supplier').val(id_supplier)
                modal.find('.modal-body #id_satuan').val(id_satuan)
                modal.find('.modal-body #id_merek').val(id_merek)
                modal.find('.modal-body #id_perusahaan').val(id_perusahaan)
                modal.find('.modal-body #stock').val(stock)
                modal.find('.modal-body #stock_minimal').val(stock_minimal)
                modal.find('.modal-body #harga_beli').val(harga_beli)
                modal.find('.modal-body #keuntungan').val(keuntungan)
                modal.find('.modal-body #keterangan').val(keterangan)
                modal.find('.modal-body #status').val(status)
                modal.find('.modal-footer #btn-submit').text('Update')
                modal.find('.modal-body form').attr('action', '/barang/' + id_barang)
                modal.find('.modal-body #method').html('{{ method_field('PATCH') }}')
            } else {
                modal.find('#modal-title').text("Tambah Data barang")
                modal.find('.modal-body #id_barang').val('')
                modal.find('.modal-body #nama_barang').val('')
                modal.find('.modal-footer #btn-submit').text('Submit')
                modal.find('.modal-body #method').html('')
            }
          });
        });
      </script>
      <script>
          $('.delete-data').on('click', function(e){
            e.preventDefault();
            Swal.fire({
            title: 'Apakah Kamu Yakin Menghapus Data Ini?',
            text: "Data tidak akan bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus data ini!'
            }).then((result) => {
            if (result.isConfirmed) {
                $(e.target).closest('form').submit()
            } else {
                swal.close()
            }
            })
          });
      </script>
@endpush