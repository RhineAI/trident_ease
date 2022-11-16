<!-- Modal -->
<div class="modal fade" id="formModalBayar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width:620px;" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            @if (Auth::user()->hak_akses == 'admin')
                 <form action="{{ route('admin.data-piutang.store') }}" method="POST">
            @elseif (Auth::user()->hak_akses == 'kasir')
                <form action="{{ route('kasir.data-piutang.store') }}" method="POST">
            @endif
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
                    <label for="id_penjualan" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">No Penjualan</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="id_penjualan" id="id_penjualan" class="form-control" readonly>
                        <span class="help-block with-errors"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_pelanggan" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Nama Pelanggan</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                        <input type="text" name="nama_pelanggan" id="nama_pelanggan" class="form-control" readonly>
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
                    <label for="total_harga" class="col-md-3 col-md-offset-1 control-label">
                        <h5 class="my-2">Total Pembayaran</h5>
                    </label>
                    <div class="col-md-9">
                        <input type="text" name="total_harga" id="total_harga" class="form-control" readonly>
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
    
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-circle-check"></i>
                Simpan</button>
        </div>
        </div>
    </div>
    </div>
    </form>