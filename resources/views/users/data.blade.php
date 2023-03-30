<div class="box-body table-responsive">
    <table class="table table-hover dt-responsive" style="width: 100%;" id="tbl-data-pegawai">
        <thead class="table-secondary">
            <tr>
                <td class="text-center" width="4%">ID</td>
                <td class="text-center" width="8.7%">Nama</td>
                <td class="text-center" width="15%">Alamat</td>
                <td class="text-center" width="9%">Telepon</td>
                <td class="text-center" width="7%">Hak Akses</td>
                <td class="text-center" width="7%">Action</td>
            </tr>
        </thead>
        <tbody>
            <small style="visibility: hidden">{{ $no = 1 }}</small>
            @foreach ($pegawai as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ ucfirst($item->nama) }}</td>
                <td>{{ ucfirst($item->alamat) }}</td>
                <td>{{ $item->tlp }}</td>
                <td class="text-center">
                    @if ($item->hak_akses == 'admin')
                    <span class="badge badge-dark">Admin</span>
                    @elseif($item->hak_akses == 'kasir')
                    <span class="badge badge-success">Kasir</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-xs btn-success" id="edit" type="button" title="Edit"
                    @if (auth()->user()->hak_akses == 'admin')
                        data-route="{{ route('admin.users.update', $item->id) }}"
                    @elseif(auth()->user()->hak_akses == 'owner')
                        data-route="{{ route('owner.users.update', $item->id) }}"
                    @endif
                        data-id_pegawai="{{ $item->id }}"
                        data-nama="{{ $item->nama }}"
                        data-alamat="{{ $item->alamat }}"
                        data-tlp="{{ $item->tlp }}"
                        data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                        data-hak_akses="{{ $item->hak_akses }}"
                        data-username="{{ $item->username }}"
                        data-password="{{ $item->password }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    @if (auth()->user()->hak_akses == 'admin')
                        <form action="{{ route('admin.users.destroy', $item->id) }}" style="display: inline;" method="post">
                    @elseif (auth()->user()->hak_akses == 'owner')
                        <form action="{{ route('owner.users.destroy', $item->id) }}" style="display: inline;" method="post">
                    @endif
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-xs btn-danger delete-data" type="button" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
