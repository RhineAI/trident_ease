<div class="box-body table-responsive">
    <table class="table table-striped table-hover table-bordered dt-responsive" style="width: 100%;" id="tbl-data-satuan">
        <thead class="table-success">
            <tr>
                <td class="text-center" width="10%">No</td>
                <td class="text-center">Nama Satuan</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody>
            <p style="visibility: hidden">{{ $no = 1 }}</p>
            @foreach ($satuan as $item)
            <tr>
                <td class="text-center">{{ $no++}}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <button class="btn btn-xs btn-warning" type="button" style="color: green;" title="Edit" data-mode="edit"
                        data-toggle="modal" data-target="#formModalSatuan" data-id_satuan="{{ $item->id }}"
                        data-nama_satuan="{{ $item->nama }}" data-route="{{ route('admin.satuan.update', $item->id) }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.satuan.destroy', $item->id) }}" style="display: inline;" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick="deleteData('{{ route('admin.satuan.destroy', $item->id) }}')" class="btn btn-xs btn-danger delete-data" type="button" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>