<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <form action="" method="post" class="form-horizontal" id="formBarang">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <h4 class="text-center mb-4">Informasi Barang</h4> --}}
                    <div class="form-group row">
                        <label for="nama" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Nama</h6>
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="nama" id="product_name" class="form-control"
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="kode" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Kode</h6>
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control" placeholder="Contoh : 001 ">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="barcode" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Barcode</h6>
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="barcode" id="barcode" class="form-control">
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Kategori</h6>
                        </label>
                        <div class="col-md-4">
                            <select name="id_kategori" id="id_kategori" class="form-control">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($categories as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_satuan" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Satuan</h6>
                        </label>
                        <div class="col-md-4">
                            <select name="id_satuan" id="id_satuan" class="form-control">
                                <option value="" disabled selected>Pilih Satuan</option>
                                @foreach ($satuan as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="id_merek" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Merek </h6>
                        </label>
                        <div class="col-md-4">
                            <select name="id_merek" id="id_merek" class="form-control">
                                <option value="" disabled selected>Pilih Merek</option>
                                @foreach ($merek as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <hr>
                    <h5 class="text-center my-2 mt-2 mb-5">Informasi Harga dan Stok</h5>

                    <div class="form-group row">
                        <label for="harga_beli" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Harga Beli</h6>
                        </label>
                        <div class="input-group mb-3 col-md-5">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" name="harga_beli" autocomplete="off" id="harga_beli" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <label for="keuntungan" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Keuntungan</h6>
                        </label>
                        <div class="input-group mb-3 col-md-3">
                            <input max="100" maxlength="3" type="text" name="keuntungan" id="keuntungan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">%<span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_jual" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Harga Jual</h6>
                        </label>
                        <div class="input-group mb-3 col-md-5">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" autocomplete="off" id="harga_jual" class="form-control" aria-label="Username" readonly aria-describedby="basic-addon1">
                        </div>

                        <label for="status" class="col-md-2 col-md-offset-1 control-label">
                            <h6 class="my-2">Status</h6>
                        </label>
                        <div class="col-md-3">
                            <select name="status" id="status" class="form-control">
                                <option value="1" selected>Aktif</option>
                                <option value="2">Tidak Aktif</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stock" class="col-md-1 control-label">
                            <h6 class="my-2">Stok </h6>
                        </label>
                        <div class="col-md-3">
                            <input type="number" name="stock" id="stock" class="form-control" autofocus>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="stock_minimal" class="col-md-1 control-label" style="width: 12.19%; flex: 0 0 12.19%;max-width: 12.19%;">
                            <h6 class="my-2">Min. Stok</h6>
                        </label>
                        <div class="col-md-2" style="width: 21%; flex: 0 0 21%;max-width: 21%;">
                            <input type="number" name="stock_minimal" id="stock_minimal" class="form-control" autofocus>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="keterangan" class="col-md-1 control-label">
                            <h6 class="my-2">Jenis</h6>
                        </label>
                        <div class="col-md-3">
                            <select name="keterangan" id="keterangan" class="form-control">
                                <option selected disabled value="">Pilih Produk</option>
                                <option value="utama">Produk Utama</option>
                                <option value="konsinyasi">Produk Konsinyasi</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                      
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-circle-check"></i>
                        Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>