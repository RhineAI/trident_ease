<!-- Modal -->
<div class="modal fade" id="formModalPelanggan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    <label for="nama">Nama Pelanggan</label>
                    <input type="text" class="form-control" id="nama" placeholder="Nama Pelanggan" name="nama">
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="10"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="form-group" style="width: 95%; margin: auto;">
                    <label for="tlp">No Telepon</label>
                    <input type="text" class="form-control" id="tlp" placeholder="No Telepon" name="tlp">
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