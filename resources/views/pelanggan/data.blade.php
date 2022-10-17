<table id="tbl-data-pelanggan" class="table table-bordered table-hover table-compact" style="width: 100%;">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama Pelanggan</td>
            <td>Alamat</td>
            <td>No Telepon</td>
            <td>Nama Perusahaan</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pelanggan as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->tlp }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalPelanggan" data-id_pelanggan="{{ $item->id }}" data-nama_pelanggan="{{ $item->nama }}"  data-alamat="{{ $item->alamat }}"  data-tlp="{{ $item->tlp }}"  data-id_perusahaan="{{ $item->id_perusahaan }}">
                    <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('pelanggan.destroy', $item->id) }}" style="display: inline;" method="post">
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