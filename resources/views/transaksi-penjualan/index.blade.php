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
  
        <div class="row mx-4">
            <div class="col-lg-12" style="background-color: white;">
                <div class="box-body">
        
                    <div class="box-body mx-2 my-2">
                            
                        <form class="form-produk">
                            @csrf
                            <div class="form-group row">
                                <label for="kode_produk" class="col-lg-2">Tambah Produk</label>
                                <div class="col-lg-3">
                                    <div class="input-group">
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
        
                        <table class="table table-striped table-bordered table-penjualan">
                            <thead>
                                <th width="4%">No</th>
                                <th width="10%" class="text-center">Barcode</th>
                                <th class="text-center">Nama</th>
                                <th width="15%"class="text-center">Harga</th>
                                <th width="12%" class="text-center">Jumlah</th>
                            
                                <th width="12%" class="text-center">Subtotal</th>
                                <th width="8%" class="text-center">Aksi</th>
                            </thead>
                        </table>
        
                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="tampil-bayar bg-default mb-4">Rp. 0 ,-</div>
                                <div class="tampil-terbilang">Nol Rupiah</div>
                            </div>
                            <div class="col-lg-4">
                                <form action="" class="form-pembelian" method="post">
                                    @csrf
                                    {{-- <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}"> --}}
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
                                        <label for="bayar" class="col-lg-3 control-label">Total Bayar</label>
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
                        <button type="submit" class="btn btn-outline-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa-solid fa-floppy-disk"></i> Simpan Transaksi</button>
                    </div>
                </div>
            </div>
        </div>
  
      </section>
      <!-- /.content -->

      @includeIf('transaksi-pembelian.barang')
@endsection

@push('scripts')
<script>
    

</script>
@endpush