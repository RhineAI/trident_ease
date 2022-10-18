<!-- Modal -->
<div class="modal fade" class="modal-produk" id="modal-produk" tabindex="1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> 
            <div class="modal-header">
                <h4 class="modal-title">Pilih Produk</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{-- <h4 class="modal-title">Pilih Produk</h4> --}}
            </div>

            <div class="modal-body">
                <table class="table table-striped table-bordered table-produk">
                    <thead>
                        <th width="4%">No</th>
                        <th width="10%">Barcode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="12%">Stok</th>
                        <th width="6%">Aksi</th>
                    </thead>
                    <tbody>
                    @foreach ($barang as $key => $item)
                        <tr>
                            <td width="6%">{{ $key+1 }}</td>
                            <td width="10%">
                                <span hidden class="id_produk">{{ value($item->id) }}</span>
                                <span class="badge badge-info">{{ $item->barcode }}</span>
                            </td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ 'Rp. '. format_uang($item->harga_beli) }}</td>
                            <td width="12%">{{ $item->stock }}</td>
                            <td width="6%">
                                <a href="#" id="selectProduct" class="btn btn-primary btn-xs btn-flat"
                                onclick="pilihProduk('{{ $item->id_produk }}', '{{ $item->barcode }}') ">    
                                    <i class="fa fa-check-circle"></i>
                                    Pilih
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->