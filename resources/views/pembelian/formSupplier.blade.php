<!-- Modal -->
<div class="modal fade" id="formModalSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Pilih Supplier</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-data-supplier" class="table table-striped table-bordered table-hover table-compact" style="width: 100%;">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama Supplier</td>
                        <td>Alamat</td>
                        <td>No Telepon</td>
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
                            <td>
                                <a href="#" class="btn btn-primary btn-xs btn-flat" onclick="pilihSupplier('{{ $item->id }}', {{ $item->nama }}', '{{ $item->tlp }}')">
                                    <i class="fa fa-check-circle"></i>
                                    Pilih
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>