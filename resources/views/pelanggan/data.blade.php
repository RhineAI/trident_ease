<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered dt-responsive" style="width: 100%;" id="tbl-data-pelanggan">
        <thead>
            <tr class="table-success">
                <td class="text-center" width="3%">No</td>
                <td class="text-center" width="9%">Nama</td>
                <td class="text-center" width="12%">Alamat</td>
                <td class="text-center" width="9%">No Telepon</td>
                {{-- <td class="text-center" width="9%">Nama Perusahaan</td> --}}
                <td class="text-center" width="6%">Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggan as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->tlp }}</td>
                {{-- <td>{{ $item->nama_perusahaan }}</td> --}}
                <td>
                    <button class="btn btn-xs btn-warning" type="button" style="color: green;" title="Edit" data-mode="edit"
                        data-toggle="modal" data-target="#formModalPelanggan" data-id_pelanggan="{{ $item->id }}"
                        data-nama_pelanggan="{{ $item->nama }}" data-alamat="{{ $item->alamat }}"
                        data-tlp="{{ $item->tlp }}" data-jenis_kelamin="{{ $item->jenis_kelamin }}"
                        {{-- data-id_perusahaan="{{ $item->id_perusahaan }}" --}}
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