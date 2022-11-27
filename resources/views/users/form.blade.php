<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" id="" style="width:95%;">
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
                <label for="alamat" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Nama</h5>
                </label>
                <div class="col-md-8">
                    <input type="text" placeholder="Nama Pegawai" name="nama" id="nama" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="alamat" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Alamat</h5>
                </label>
                <div class="col-md-8">
                    <textarea placeholder="Alamat Pegawai" name="alamat" class="form-control" id="alamat" cols="10" rows="3.5" required></textarea>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="tlp" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Telepon</h5>
                </label>
                <div class="col-md-8">
                    <input type="number" minlength="11" maxlength="14" placeholder="Telepon / No Hp" name="tlp" id="tlp" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="jenis_kelamin" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Jenis Kelamin</h5>
                </label>
                <div class="col-md-8">
                    <select placeholder="" name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                        <option value="" disabled="disabled" selected="true">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                        <option value="Other">Lainnya</option>
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="username" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Username</h5>
                </label>
                <div class="col-md-8">
                    <input type="text" placeholder="Username" name="username" id="username" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row" id="pass">
                <label for="password" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Password</h5>
                </label>
                <div class="col-md-8">
                    <input type="password" minlength="6" placeholder="Ketik Password" name="password" id="password" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row" id="pass">
                <label for="password_confirmation" minlength="6" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Konfirmasi Password</h5>
                </label>
                <div class="col-md-8">
                    <input type="password" minlengt="6" data-match="#password" placeholder="Ketik Ulang Password" name="password_confirmation" id="password_confirmation" class="form-control" aria-label="Username" aria-describedby="basic-addon1" required>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="hak_akses" class="col-md-4 col-md-offset-1 control-label">
                    <h5 class="my-2">Hak Akses</h5>
                </label>
                <div class="col-md-8">
                    <select class="form-control" name="hak_akses" id="hak_akses" required>
                        <option value="" disabled="disabled" selected="true">Pilih Hak Akses User</option>
                        <option value="admin">Administrator</option>
                        <option value="kasir">Kasir</option>
                        {{-- <option value="owner">Owner</option> --}}
                    </select>
                    <span class="help-block with-errors"></span>
                </div>
            </div>
            <input type="hidden" name="id_perusahaan" value="{{ $cPerusahaan->id }}">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
    </div>
    </div>
</div>
</div>
    </form>