<!-- Modal -->
<div class="modal fade" id="formModalPelangganPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg dt-responsive" role="document" style="width: 100%">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Pilih Pelanggan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-data-pelanggan-penjualan" class="table-responsive dt-responsive table table-striped table-bordered table-hover table-compact" style="width: 100%;">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Alamat</td>
                        <td>Telepon</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggan as $item)
                        <tr>
                            <td width="6%">{{ $i = (isset($i)?++$i:$i=1) }}</td>
                            <td width="10%">{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td width="6%">{{ $item->tlp }}</td>
                            <td width="6%">
                                <button type="button" class="btn btn-info add_pelanggan" 
                                        data-id_pelanggan="{{ $item->id }}" 
                                        data-nama_pelanggan="{{ $item->nama }}" 
                                        data-alamat="{{ $item->alamat }}" 
                                        data-tlp="{{ $item->tlp }}" 
                                        data-dismiss="modal"> 
                                        <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>