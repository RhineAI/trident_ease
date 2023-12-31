<!-- Modal -->
<div class="modal fade" id="formModalSatuan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" style="width:95%;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Tambah Data Satuan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label class="col-md-3 col-md-offset-1" for="nama">Satuan</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="nama" placeholder="Nama Satuan" name="nama">
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