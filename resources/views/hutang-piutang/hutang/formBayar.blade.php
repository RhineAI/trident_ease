<!-- Modal -->
<div class="modal fade" id="formModalPembayaranPBL" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="nama">Tanggal</label>
                        <input type="date" class="form-control" id="tgl" name="tgl" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="id_pembelian">No Pembelian</label>
                        <input type="number" class="form-control" id="id_pembelian" name="id_pembelian" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="nama_supplier">Nama Supplier</label>
                        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
                        <input type="text" class="form-control" id="nama_supplier" name="nama_supplier" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="tlp">Telepon</label>
                        <input type="text" class="form-control" id="tlp" name="tlp" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="total_pembelian">Total Pembayaran</label>
                        <input type="number" class="form-control" name="total_pembelian" id="total_pembelian" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="dp">DP</label>
                        <input type="number" class="form-control" name="dp" id="dp" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="sisa">Sisa bayar</label>
                        <input type="number" class="form-control" name="sisa" id="sisa" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="bayar">Bayar</label>
                        <input type="number" class="form-control" name="bayar" id="bayar">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group" style="width: 95%; margin: auto;">
                        <label for="kembalian">Kembalian</label>
                        <input type="number" class="form-control" name="kembalian" id="kembalian" readonly>
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