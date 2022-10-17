<!-- Modal -->
<div class="modal fade" id="formModalBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="" method="POST">
            @csrf
            <div id="method"></div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="kode">Kode Barang</label>
                    <input type="text" class="form-control" id="kode" placeholder="Kode Barang" name="kode">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="nama">Nama Barang</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama Barang" name="nama">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="barcode">Barcode Barang</label>
                    <input type="text" class="form-control" id="barcode" placeholder="Barcode Barang" name="barcode">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="tebal">Tebal Barang</label>
                    <input type="text" class="form-control" id="tebal" placeholder="Tebal Barang" name="tebal">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="panjang">Panjang Barang</label>
                    <input type="text" class="form-control" id="panjang" placeholder="Panjang Barang" name="panjang">
                </div>
            </div>
            <div class="form-group" style="width: 97%; margin: 5 auto;">
                <label for="id_kategori">Kategori Barang</label>
                <select class="form-control" name="id_kategori" id="id_kategori">
                    <option value="" disabled="disabled" selected="true">Choose Category</option>
                    @foreach($categories as $item)
                    <option value="{{$item->id}}">{{$item->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 97%; margin: 5 auto;">
                <label for="id_supplier">Supplier Barang</label>
                <select class="form-control" name="id_supplier" id="id_supplier">
                    <option value="" disabled="disabled" selected="true">Choose Supplier</option>
                    @foreach($supplier as $item)
                    <option value="{{$item->id}}">{{$item->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 97%; margin: 5 auto;">
                <label for="id_satuan">Satuan Barang</label>
                <select class="form-control" name="id_satuan" id="id_satuan">
                    <option value="" disabled="disabled" selected="true">Choose Satuan</option>
                    @foreach($satuan as $item)
                    <option value="{{$item->id}}">{{$item->nama}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="width: 97%; margin: 5 auto;">
                <label for="id_merek">Merek Barang</label>
                <select class="form-control" name="id_merek" id="id_merek">
                    <option value="" disabled="disabled" selected="true">Choose Merek</option>
                    @foreach($merek as $item)
                    <option value="{{$item->id}}">{{$item->nama}}</option>
                    @endforeach
                </select>
            </div>
            <input type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="stock">Stock Barang</label>
                    <input type="number" class="form-control" id="stock" placeholder="Stock Barang" name="stock">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="stock_minimal">Stock Minimal Barang</label>
                    <input type="number" class="form-control" id="stock_minimal" placeholder="Stock Minimal Barang" name="stock_minimal">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="harga_beli">Harga Beli Barang</label>
                    <input type="number" class="form-control" id="harga_beli" placeholder="Harga Beli Barang" name="harga_beli">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="keuntungan">Keuntungan Barang</label>
                    <input type="number" min="1" max="100" class="form-control" id="keuntungan" placeholder="Keuntungan Barang" name="keuntungan">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="keterangan">Keterangan Barang</label>
                    <input type="text" class="form-control" id="keterangan" placeholder="Keterangan Barang" name="keterangan">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="status">Status Barang</label>
                    <select class="form-control" name="status" id="status">
                        <option value="" disabled="disabled" selected="true">Choose Status</option>
                        <option value="1">Aktif</option>
                        <option value="2">Tidak Aktif</option>
                    </select>
                </div>
            </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
    </div>
    </div>
</div>
</div>
</form>