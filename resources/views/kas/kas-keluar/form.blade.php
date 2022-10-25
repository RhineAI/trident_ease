<!-- Modal -->
<div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form">
    <div class="modal-dialog" role="document">
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
                        <label for="tanggal" class="col-md-3 control-label">
                            <h5 class="my-2">Tanggal</h5>
                        </label>
                        <div class="col-md-9">
                            <input type="text" readonly name="tanggal" id="tanggal" value="{{ $now }}" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlah_kas" class="col-md-3 control-label">
                            <h5 class="my-2">Jumlah Kas</h5>
                        </label>
                        <div class="col-md-9">
                            <input type="text" name="jumlah_kas" id="jumlah_kas" readonly value="{{ $sisaKas }}" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keperluan" class="col-md-3 control-label">
                            <h5 class="my-2">Keperluan</h5>
                        </label>
                        <div class="col-md-9">
                            <input type="text" value="{{ old('keperluan') }}" name="keperluan" id="keperluan" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="jumlah" class="col-md-3 control-label">
                            <h5 class="my-2">Biaya</h5>
                        </label>
                        <div class="col-md-9">
                            <input type="text" value="{{ old('jumlah') }}" name="jumlah" max="{{ $sisaKas }}" id="jumlah" class="form-control" required
                                autofocus>
                            <span class="help-block with-errors"></span>
                        </div>
                    </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-flat btn-sm" data-dismiss="modal"><i
                            class="fa fa-circle-xmark"></i> Batal</button>
                    <button type="submit" class="btn btn-primary btn-flat btn-sm"><i class="fa fa-circle-check"></i>
                        Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>