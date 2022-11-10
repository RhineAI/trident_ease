<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    @method('put')
                    <div class="form-group row">
                        <label for="nama" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Nama</h5>
                        </label>
                        <div class="col-md-10">
                            <input readonly type="text" name="nama" id="nama" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pemilik" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Pemilik</h5>
                        </label>
                        <div class="col-md-10">
                            <input readonly type="text" name="pemilik" id="pemilik" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Email</h5>
                        </label>
                        <div class="col-md-10">
                            <input readonly type="text" name="email" id="email" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tlp" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Phone</h5>
                        </label>
                        <div class="col-md-10">
                            <input readonly type="text" name="tlp" id="tlp" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="npwp" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">NPWP</h5>
                        </label>
                        <div class="col-md-10">
                            <input readonly type="text" name="npwp" id="npwp" class="form-control" required autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label for="grade" class="col-md-2 col-md-offset-1 control-label">
                            <h5 class="my-2">Grade</h5>
                        </label>
                        <div class="col-md-10">
                            <select class="form-control" name="grade" id="grade" required>
                                <option value="1">Free</option>
                                <option value="2">Intermediate</option>
                                <option value="3">Premium</option>
                            </select>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <input readonly type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
            </div>
        </div>
    </div>
</div>
</form>