<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="nama" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Nama</h5>
                        </label>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="product_name" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="barcode" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Barcode</h5>
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="barcode" id="barcode" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="kode" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Kode</h5>
                        </label>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control" required>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="id_kategori" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Kategori</h5>
                        </label>
                        <div class="col-md-4">
                            <select name="id_kategori" id="id_kategori" class="form-control" required>
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="id_satuan" class=" control-label ml-3" style="margin-right:53.7px">
                            <h5 class="my-2">Satuan</h5>
                        </label>
                        <div class="col-md-4">
                            <select name="id_satuan" id="id_satuan" class="form-control" required>
                                <option value="">Pilih Satuan</option>
                                @foreach ($satuan as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="id_supplier" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Supplier</h5>
                        </label>
                        <div class="col-md-4">
                            <select name="id_supplier" id="id_supplier" class="form-control" required>
                                <option value="">Pilih Supplier</option>
                                @foreach ($supplier as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="id_merek" class="control-label ml-3" style="margin-right: 58.5px;">
                            <h5 class="my-2">Merek</h5>
                        </label>
                        <div class="col-md-4">
                            <select name="id_merek" id="id_merek" class="form-control" required>
                                <option value="">Pilih Merek</option>
                                @foreach ($merek as $item )
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="stock" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Stok</h5>
                        </label>
                        <div class="col-md-4">
                            <input type="number" name="stock" id="stock" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>

                        <label for="stock_minimal" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Min. Stok</h5>
                        </label>
                        <div class="col-md-4">
                            <input type="number" name="stock_minimal" id="stock_minimal" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="harga_beli" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Harga Beli</h5>
                        </label>
                        <div class="input-group mb-3 col-md-10">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" name="harga_beli" id="harga_beli" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keuntungan" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Keuntungan</h5>
                        </label>
                        <div class="input-group mb-3 col-md-3">
                            <input max="100" maxlength="3" type="text" name="keuntungan" id="keuntungan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">%<span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="control-label col-md-2 col-md-offset-1">
                            <h5 class="my-2">Status</h5>
                        </label>
                        <div class="col-md-3">
                            <select name="status" id="status" class="form-control" required>
                                <option value="1" selected>Aktif</option>
                                <option value="2">Tidak Aktif</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Keterangan</h5>
                        </label>
                        <div class="mb-3 col-md-6">
                            <input type="text" name="keterangan" id="keterangan" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
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