<!-- Modal -->
<div class="modal fade" id="formModalStockOpname" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Pilih Produk</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-data-stock-opname" class="table table-striped table-bordered table-hover table-compact table-responsive dt-responsive" style="width: 100%;">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Kode</td>
                        <td>Nama Produk</td>
                        <td>Kategori</td>
                        <td>Merek</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $item)
                        <tr>
                            <td width="6%">{{ $i = (isset($i)?++$i:$i=1) }}</td>
                            <td width="10%"><span class="badge badge-info">{{ $item->kode }}</span></td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>{{ $item->nama_merek }}</td>
                            <td width="6%">
                                <button type="button" class="btn btn-info add_barang" 
                                data-id_barang="{{ $item->id }}" 
                                data-kode_barang="{{ $item->kode }}" 
                                data-nama_barang="{{ $item->nama }}" 
                                data-nama_kategori="{{ $item->nama_kategori }}" 
                                data-nama_merek="{{ $item->nama_merek }}" 
                                data-stok_awal="{{ $item->stock }}"
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