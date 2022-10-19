<div class="box-body table-responsive">
    <table class="table table-striped table-bordered" id="tbl-data-merek">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Merek</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($merek as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit"
                        data-toggle="modal" data-target="#formModalMerek" data-id_merek="{{ $item->id }}"
                        data-nama_merek="{{ $item->nama }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('merek.destroy', $item->id) }}" style="display: inline;" method="post">
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