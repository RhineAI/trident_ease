<table id="tbl-data-supplier" class="table table-bordered table-hover table-compact" style="width: 100%;">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama Supplier</td>
            <td>Alamat Supplier</td>
            <td>Telepon Supplier</td>
            <td>Salesman</td>
            <td>Bank</td>
            <td>No Rekening</td>
            <td>Nama Perusahaan</td>
            <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($supplier as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->tlp }}</td>
                <td>{{ $item->salesman }}</td>
                <td>{{ $item->bank }}</td>
                <td>{{ $item->no_rekening }}</td>
                <td>{{ $item->nama_perusahaan }}</td>
                <td>
                    <button class="btn" type="button" style="color: green;" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalSupplier" data-id_supplier="{{ $item->id }}" data-nama="{{ $item->nama }}" data-alamat="{{ $item->alamat }}" data-tlp="{{ $item->tlp }}" data-salesman="{{ $item->salesman }}" data-bank="{{ $item->bank }}" data-no_rekening="{{ $item->no_rekening }}" data-id_perusahaan="{{ $item->id_perusahaan }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('supplier.destroy', $item->id) }}" style="display: inline;" method="post">
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