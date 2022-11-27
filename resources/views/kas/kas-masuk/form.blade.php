<!-- Modal -->
<div class="modal fade" style="width:95%; margin:auto;" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog modal-lg " role="document">
        <form action="" method="post" class="form-horizontal">
            @csrf
            @method('post')

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="tanggal" class="col-md-3 col-md-offset-1 control-label">
                            <h5 class="my-2">Tanggal</h5>
                        </label>
                        <div class="col-md-9">
                            <input type="text" readonly name="tanggal" id="tanggal" value="{{ $now }}" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-md-3 col-md-offset-1 control-label">
                            <h5 class="my-2">Keterangan</h5>
                        </label>
                        <div class="col-md-9">
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="10" rows="3.5"></textarea>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlah" class="col-md-3 col-md-offset-1 control-label">
                            <h5 class="my-2">Jumlah</h5>
                        </label>
                        <div class="input-group mb-3 col-md-9">
                            <div class="input-group-prepend">
                              <span class="input-group-text" id="basic-addon1">Rp.</span>
                            </div>
                            <input type="text" name="jumlah" id="jumlah" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i
                            class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-circle-check"></i>
                        Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>