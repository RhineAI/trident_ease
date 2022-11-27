<!-- Modal -->
<div class="modal fade" id="formModalSupplierPembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width: 95%">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Pilih Supplier
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-data-supplier-penjualan" class="table table-striped table-bordered table-hover table-compact table-responsive dt-responsive" style="width: 100%;">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Nama</td>
                        <td>Alamat</td>
                        <td>Telepon</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier as $item)
                        <tr>
                            <td width="6%">{{ $i = (isset($i)?++$i:$i=1) }}</td>
                            <td width="10%">{{ $item->nama }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td width="6%">{{ $item->tlp }}</td>
                            <td width="6%">
                                <button type="button" class="btn btn-info add_supplier" 
                                data-id_supplier="{{ $item->id }}" 
                                data-nama_supplier="{{ $item->nama }}" 
                                data-alamat="{{ $item->alamat }}" 
                                data-tlp="{{ $item->tlp }}" 
                                data-dismiss="modal"> <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>