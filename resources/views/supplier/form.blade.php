<!-- Modal -->
<div class="modal fade" id="formModalSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" style="width:100%;">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="" method="POST" id="formSupplier">
            @csrf
            <div id="method"></div>
            <div class="form-group row">
                <label for="nama" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">PT Distributor</h5>
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="Nama PT/Distributor" name="nama" id="nama" class="form-control" aria-label="Nama" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Alamat</h5>
                </label>
                <div class="col-md-9">
                    <textarea placeholder="Alamat PT/Distributor" name="alamat" class="form-control" id="alamat" cols="10" rows="3.5"></textarea>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="tlp" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Telepon</h5>
                </label>
                <div class="col-md-9">
                    <input type="text" minlength="11" maxlength="14" placeholder="Telepon / No Hp" name="tlp" id="tlp" class="form-control" aria-label="Telepon" aria-describedby="basic-addon1">
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="salesman" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Salesman</h5>
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="Salesman" name="salesman" id="salesman" class="form-control" aria-label="Telepon" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="bank" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Bank</h5>
                </label>
                <div class="col-md-9">
                    <select name="bank" class="form-control" id="bank">
                        <option disabled="disabled" selected="selected">Bank (Opsional)</option>
                        <option value="Bank BRI">Bank BRI</option>
                        <option value="Bank BNI">Bank BNI</option>
                        <option value="Bank BJB">Bank BJB</option>
                        <option value="Bank BCA">Bank BCA</option>
                        <option value="Bank Permata">Bank Permata</option>
                        <option value="Bank Muamalat">Bank Muamalat</option>
                        <option value="Other">Lainnya</option>
                    </select>
                </div>
            </div>
            <div class="form-group row other">
                <label for="bank" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Bank Lainnya</h5>
                </label>
                <div class="col-md-9">
                    <input type="text" name="other" id="other" class="form-control" placeholder="Bank Lainnya..." class="input--style-1">
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="no_rekening" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">No Rekening</h5>
                </label>
                <div class="col-md-9">
                    <input type="number" placeholder="No Rekening (Opsional)" name="no_rekening" id="no_rekening" class="form-control" aria-label="Telepon" aria-describedby="basic-addon1">
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <input type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
    </div>
    </div>
</div>
</div>
</form>