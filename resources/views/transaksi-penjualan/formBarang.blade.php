<!-- Modal -->
<div class="modal fade" id="formModalBarangPenjualan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Pilih Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-data-barang-penjualan" class="table table-striped table-bordered table-hover table-compact" style="width: 100%;">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Barcode</td>
                        <td>Nama Produk</td>
                        <td>Harga Beli</td>
                        <td>Stok</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                        <tr>
                            <td width="6%">{{ $i = (isset($i)?++$i:$i=1) }}</td>
                            <td width="10%"><span class="badge badge-info">{{ $item->barcode }}</span></td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ 'Rp. '. format_uang($item->harga_beli) }}</td>
                            <td>{{ $item->stock }}</td>
                            <td width="6%">
                                <button type="button" class="btn btn-info add_barang" 
                                data-id_barang="{{ $item->id }}" 
                                data-kode_barang="{{ $item->kode }}" 
                                data-nama_barang="{{ $item->nama }}" 
                                data-harga_beli="{{ $item->harga_beli }}" 
                                data-harga_jual="{{ GetHargaJual($item->harga_beli,$item->keuntungan) }}" 
                                data-qty="1"
                                data-stock="{{ $item->stock }}" 
                                data-dismiss="modal"> <i class="fa fa-plus"></i>
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