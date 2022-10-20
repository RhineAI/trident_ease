<div class="box-body table-responsive">
    <table class="table table-striped table-bordered" id="tbl-data-satuan">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Satuan</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($satuan as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit"
                        data-toggle="modal" data-target="#formModalSatuan" data-id_satuan="{{ $item->id }}"
                        data-nama_satuan="{{ $item->nama }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('satuan.destroy', $item->id) }}" style="display: inline;" method="post">
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
</div>