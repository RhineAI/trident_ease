<div class="box-body table-responsive">
    <table class="table table-striped table-hover table-bordered dt-responsive" style="width: 100%;" id="tbl-data-kategori">
        <thead class="table-success">
            <tr>
                <td width="9%" class="text-center" width="10%">No</td>
                <td class="text-center">Nama Kategori</td>
                <td width="16%" class="text-center">Action</td>
            </tr>
        </thead>
        <tbody>
            <p style="visibility: hidden">{{ $no = 1 }}</p>
            @foreach ($categories as $item)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center">
                        @if (auth()->user()->hak_akses == 'admin')
                            <button class="btn btn-xs btn-success" type="button" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalKategori" data-id_kategori="{{ $item->id }}" data-nama_kategori="{{ $item->nama }}" data-route="{{ route('admin.kategori.update', $item->id) }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('admin.kategori.destroy', $item->id) }}" style="display: inline;" method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="deleteData('{{ route('admin.kategori.destroy', $item->id) }}')" class="btn btn-xs btn-danger delete-data" type="button" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @elseif (auth()->user()->hak_akses == 'owner')
                            <button class="btn btn-xs btn-success" type="button" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalKategori" data-id_kategori="{{ $item->id }}" data-nama_kategori="{{ $item->nama }}" data-route="{{ route('owner.kategori.update', $item->id) }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('owner.kategori.destroy', $item->id) }}" style="display: inline;" method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="deleteData('{{ route('owner.kategori.destroy', $item->id) }}')" class="btn btn-xs btn-danger delete-data" type="button" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>