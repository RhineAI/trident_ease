<div class="box-body table-responsive">
    <table class="table table-striped table-hover table-bordered" id="tbl-data-merek">
        <thead class="table-success">
            <tr>
                <td class="text-center" width="10%">No</td>
                <td class="text-center">Nama Merek</td>
                <td class="text-center">Action</td>
            </tr>
        </thead>
        <tbody>
            <p style="visibility: hidden">{{ $no = 1 }}</p>
            @foreach ($merek as $item)
            <tr>          
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $item->nama }}</td>
                <td>
                    <button class="btn btn-xs btn-warning" type="button" style="color: green;" title="Edit" data-mode="edit"
                        data-toggle="modal" data-target="#formModalMerek" data-id_merek="{{ $item->id }}"
                        data-nama_merek="{{ $item->nama }}" data-route="{{ route('admin.merek.update', $item->id) }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('admin.merek.destroy', $item->id) }}" style="display: inline;" method="post">
                        @csrf
                        @method('DELETE')
                        <button onclick="deleteData('{{ route('admin.merek.destroy', $item->id) }}')" class="btn btn-xs btn-danger delete-data" type="button" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>