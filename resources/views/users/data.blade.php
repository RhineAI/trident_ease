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
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ ucfirst($item->nama) }}</td>
                <td>{{ ucfirst($item->alamat) }}</td>
                <td>{{ $item->tlp }}</td>
                <td class="text-center">
                    @if ($item->hak_akses == 1)
                    <span class="badge badge-dark">Admin</span>
                    @elseif($item->hak_akses == 2)
                    <span class="badge badge-success">Kasir</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-xs btn-warning" id="edit" style="color: green;" type="button" title="Edit" 
                        data-route="{{ route('admin.users.update', $item->id) }}" 
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
                    <form action="{{ route('admin.users.destroy', $item->id) }}" style="display: inline;" method="post">
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