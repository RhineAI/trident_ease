<!-- Modal -->
<div class="modal fade" id="formModalPelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" style="width:95%;">
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
                <label for="nama" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Nama</h5>
                </label>
                <div class="col-md-9">
                    <input type="text" placeholder="Nama Pelanggan" name="nama" id="nama" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Alamat</h5>
                </label>
                <div class="col-md-9">
                    <textarea placeholder="Alamat Pelanggan" name="alamat" class="form-control" id="alamat" cols="10" rows="3.5" required></textarea>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="tlp" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Telepon</h5>
                </label>
                <div class="col-md-9">
                    <input type="number" minlength="11" maxlength="14" placeholder="Telepon / No Hp" name="tlp" id="tlp" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
             <div class="form-group row">
                <label for="jenis_kelamin" class="col-md-3 col-md-offset-1 control-label">
                    <h5 class="my-2">Jenis Kelamin</h5>
                </label>
                <div class="col-md-9">
                    <select placeholder="" name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="" disabled="disabled" selected="true">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                        <option value="Other">Lainnya</option>
                    </select>
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