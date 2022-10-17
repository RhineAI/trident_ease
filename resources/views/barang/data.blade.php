<table id="tbl-data-barang" class="table table-bordered table-hover table-compact" style="width: 100%;">
    <thead>
        <tr>
            <td>No</td>
            <td>Kode Barang</td>
            <td>Nama Barang</td>
            <td>Barcode Barang</td>
            <td>Tebal Barang</td>
            <td>Panjang Barang</td>
            <td>Kategori Barang</td>
            <td>Supplier</td>
            <td>Satuan</td>
            <td>Merek</td>
            <td>Perusahaan</td>
            <td>Stock</td>
            <td>Stock Minimal</td>
            <td>Harga Beli</td>
            <td>Keuntungan</td>
            <td>Keterangan</td>
            <td>Status</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->barcode }}</td>
                <td>{{ $item->tebal }}</td>
                <td>{{ $item->panjang }}</td>
                <td>{{ $item->nama_kategori }}</td>
                <td>{{ $item->nama_supplier }}</td>
                <td>{{ $item->nama_satuan }}</td>
                <td>{{ $item->nama_merek }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ $item->stock_minimal }}</td>
                <td>{{ $item->harga_beli }}</td>
                <td>{{ $item->keuntungan }}</td>
                <td>{{ $item->keterangan }}</td>
                <td>
                    @if ($item->status == 1)
                        Aktif
                    @elseif($item->status == 2)
                        Tidak Aktif
                    @endif    
                </td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalBarang" data-id_barang="{{ $item->id }}" data-kode="{{ $item->kode }}" data-nama_barang="{{ $item->nama }}" data-barcode="{{ $item->barcode }}" data-tebal="{{ $item->tebal }}" data-panjang="{{ $item->panjang }}" data-id_kategori="{{ $item->id_kategori }}" data-id_supplier="{{ $item->id_supplier }}" data-id_satuan="{{ $item->id_satuan }}" data-id_merek="{{ $item->id_merek }}" data-id_perusahaan="{{ $item->id_perusahaan }}" data-stock="{{ $item->stock }}" data-stock_minimal="{{ $item->stock_minimal }}" data-harga_beli="{{ $item->harga_beli }}" data-keuntungan="{{ $item->keuntungan }}" data-keterangan="{{ $item->keterangan }}" data-status="{{ $item->status }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('barang.destroy', $item->id) }}" style="display: inline;" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn delete-data" type="button" style="color: red;" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>