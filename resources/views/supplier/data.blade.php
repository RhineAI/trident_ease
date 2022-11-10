<div class="table-responsive">
    <table class="table table-hover dt-responsive" style="width: 100%;" id="tbl-data-supplier">
    <thead>
        <tr class="table-secondary">
            <td class="text-center" width="2%">No</td>
            <td class="text-center" width="6%">Nama</td>
            <td class="text-center" width="12%">Alamat</td>
            <td class="text-center" width="9%">Telepon</td>
            <td class="text-center" width="9%">Salesman</td>
            <td class="text-center" width="5%">Bank</td>
            <td class="text-center" width="6%">No Rekening</td>
            {{-- <td class="text-center" width="7%">Perusahaan</td> --}}
            <td class="text-center" width="5%">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($supplier as $item)
            <tr>
                <td class="text-center">{{ $item->id }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->tlp }}</td>
                <td>{{ $item->salesman }}</td>
                <td>{{ $item->bank }}</td>
                <td>{{ $item->no_rekening }}</td>
                {{-- <td>{{ $item->nama_perusahaan }}</td> --}}
                <td>
                    <button class="btn btn-xs btn-warning" type="button" style="color: green;" title="Edit" data-mode="edit" data-toggle="modal" data-target="#formModalSupplier" data-id_supplier="{{ $item->id }}" data-nama="{{ $item->nama }}" data-alamat="{{ $item->alamat }}" data-tlp="{{ $item->tlp }}" data-salesman="{{ $item->salesman }}" data-bank="{{ $item->bank }}" data-no_rekening="{{ $item->no_rekening }}" data-id_perusahaan="{{ $item->id_perusahaan }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form action="{{ route('supplier.destroy', $item->id) }}" style="display: inline;" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="btn  btn-xs btn-danger delete-data" type="button" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>