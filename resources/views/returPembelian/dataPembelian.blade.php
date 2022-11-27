<!-- Modal -->
<div class="modal fade" id="formModalReturPembelian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="modal-title">Pilih Data Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table id="tbl-data-retur-pembelian" class="table table-striped table-bordered table-hover table-compact table-responsive dt-responsive" style="width: 100%;">
                <thead>
                    <tr>
                        <td>No</td>
                        <td>No Pembelian</td>
                        <td>Tanggal</td>
                        <td>Supplier</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pembelian as $item)
                        <tr>
                            <td width="6%">{{ $i = (isset($i)?++$i:$i=1) }}</td>
                            <td width="10%"><span class="badge badge-info">{{ $item->id_pembelian }}</span></td>
                            <td>{{ $item->tanggal }}</td>
                            <td>{{ $item->nama_supplier }}</td>
                            <td width="6%">
                                <button type="button" class="btn btn-info add_pembelian" 
                                data-id_pembelian="{{ $item->id_pembelian }}" 
                                data-tgl="{{ $item->tgl }}" 
                                data-nama_supplier="{{ $item->nama_supplier }}"
                                data-id_supplier="{{ $item->id_supplier }}" 
                                data-tlp_supplier="{{ $item->tlp }}"  
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