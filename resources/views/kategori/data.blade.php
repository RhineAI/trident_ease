<table id="tbl-data-kategori" class="table table-bordered table-hover table-compact" style="width: 100%;">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama Kategori</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalKategori" data-id_kategori="{{ $item->id }}" data-nama_kategori="{{ $item->nama }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('kategori.destroy', $item->id) }}" style="display: inline;" method="post">
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