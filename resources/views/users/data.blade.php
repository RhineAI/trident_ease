<table id="tbl-data-pegawai" class="table table-bordered table-hover table-compact" style="width: 100%;">
    <thead>
        <tr>
            <td>Id Pegawai</td>
            <td>Nama Pegawai</td>
            <td>Alamat Pegawai</td>
            <td>Telepon Pegawai</td>
            <td>Hak Akses</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($pegawai as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->tlp }}</td>
                <td>{{ $item->hak_akses }}</td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalPegawai" data-id_pegawai="{{ $item->id }}" data-nama="{{ $item->nama }}" data-alamat="{{ $item->alamat }}" data-tlp="{{ $item->tlp }}" data-username="{{ $item->username }}" data-password="{{ $item->password }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('users.destroy', $item->id) }}" style="display: inline;" method="post">
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