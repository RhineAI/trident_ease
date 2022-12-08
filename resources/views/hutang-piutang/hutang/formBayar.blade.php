<!-- Modal -->
<div class="modal fade" id="formModalPembayaranPBL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:620px;" role="document">
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
                    <label for="tgl" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Tanggal</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="tgl" id="tgl" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_pembelian" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">No Pembelian</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="id_pembelian" id="id_pembelian" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nama_supplier" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">No Supplier</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                        <input type="text" name="nama_supplier" id="nama_supplier" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tlp" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Telepon</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="tlp" id="tlp" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="total_pembelian" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Total Pembayaran</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="total_pembelian" id="total_pembelian" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dp" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">DP</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="dp" id="dp" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sisa" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Sisa Bayar</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="sisa" id="sisa" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bayar" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Bayar</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="bayar" id="bayar" class="form-control" autofocus autocomplete="off">
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="kembalian" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Kembalian</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="kembalian" id="kembalian" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <input type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
                <input type="text" name="id_supplier" style="display: none;">
    
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-circle-check"></i>
                Simpan</button>
        </div>
        </div>
    </div>
    </div>
    </form>