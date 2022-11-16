<!-- Modal -->
<div class="modal fade" id="formModalMerek" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 520px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if (auth()->user()->hak_akses == 'admin')
                    <form action="{{ route('admin.merek.store') }}" method="POST"> 
                @elseif (auth()->user()->hak_akses == 'owner') 
                    <form action="{{ route('owner.merek.store') }}" method="POST">
                @endif
                    @csrf
                    <div id="method"></div>
                    <div class="form-group row">
                        <label class="col-md-3 col-md-offset-1" for="nama">Merek</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="nama" placeholder="Nama Merek" name="nama">
                        </div>
                    </div>
                    <input type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="btn-submit">Simpan Data</button>
            </div>
        </div>
    </div>
</div>
</form>