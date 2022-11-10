<div class="table-responsive">
    <table class="table table-hover dt-responsive" style="width: 100%;" id="tbl-data-pelanggan">
        <thead>
            <tr class="table-secondary">
                <td class="text-center" width="3%">No</td>
                <td class="text-center" width="9%">Nama</td>
                <td class="text-center" width="12%">Alamat</td>
                <td class="text-center" width="9%">No Telepon</td>
                {{-- <td class="text-center" width="9%">Nama Perusahaan</td> --}}
                <td class="text-center" width="6%">Action</td>
            </tr>
        </thead>
        <tbody>
            <p style="visibility: hidden">{{ $no = 1 }}</p>
            @foreach ($pelanggan as $item)
            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td class="text-center">{{ $item->nama }}</td>
                <td class="text-center">{{ $item->alamat }}</td>
                <td width="9.6%" class="text-center">{{ $item->tlp }}</td>
                {{-- <td>{{ $item->nama_perusahaan }}</td> --}}
                <td class="text-center">
                    <button class="btn btn-xs btn-warning edit" type="button" style="color: green;" title="Edit" data-mode="edit"
                        data-toggle="modal" 
                        data-target="#formModalPelanggan" 
                        data-id_pelanggan="{{ $item->id }}"
                        data-nama_pelanggan="{{ $item->nama }}" 
                        data-alamat="{{ $item->alamat }}"
                        data-tlp="{{ $item->tlp }}" 
                        data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                        data-route="{{ route('pelanggan.update', $item->id) }}"
                        ><i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('pelanggan.destroy', $item->id) }}" method="post" class="d-inline">
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