<!-- Modal -->
<div class="modal fade " id="importBarang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" style="width: 550px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Import Data Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <form id="formImport" action="{{ route('admin.postImport') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <!-- HTML !-->
                    <div class="modal-body">
  
                        <div class="form-group row ml-3">
                            {{-- <div class="file-upload-wrapper" data-text="Select your file!"> --}}
                                {{-- <a class="file-upload-wrapper-download" data-text="Download Template" style="" download href="/assets/excel/Template Import Barang.xlsx"></a> --}}
                                <a class="file-upload-wrapper-download" data-text="Download Template" href="{{ route('admin.download.template') }}" ></a>
                            {{-- </div> --}}
                            <div class="file-upload-wrapper-upload mt-3" data-text="Upload File!" style="">
                                <input name="fileExcel" type="file" id="file1" onchange="uploadFile()" class="file-upload-field" value="">
                                <input type="hidden" name="id_perusahaan" value="{{ auth()->user()->id_perusahaan }}">
                            </div>
                            <progress id="progressBar" value="0" max="100" style="margin-left: 1.3em; width:345px;"></progress>
                            <h3 id="status"></h3>
                            <p style="margin-left: 1.3em; font-family: 'Arial'; font-size: 13.5px;" id="loaded_n_total"></p>
                        </div>
                        <div class="form-group row ml-2">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
        </div>
    </div>
</div>