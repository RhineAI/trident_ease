@extends('templates.layout')

@section('title')
    <title>Supplier | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
    Supplier
@endsection

@section('breadcrumb')
@parent
    Supplier
@endsection

@push('styles')
    
@endpush

@section('contents')
      <section class="content">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Form Supplier</h3>
          </div>
          <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="" method="POST" id="formSupplier" class="mx-2">
                @csrf
                <div id="method"></div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="nama">PT Supplier / Distributor</label>
                        <input type="text" class="form-control" id="nama" placeholder="Nama Supplier" name="nama" required>
                    </div>

                    <div class="col-md-4">
                        <label for="tlp">Telepon Supplier</label>
                        <input type="text" class="form-control" id="tlp" placeholder="Telepon" name="tlp" required>
                    </div>

                    <div class="col-md-4">
                        <label for="salesman">Salesman</label>
                        <input type="text" class="form-control" id="salesman" placeholder="Salesman" name="salesman" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-12">
                        <label for="alamat">Alamat Supplier</label>
                        <textarea class="form-control" name="alamat" id="alamat" cols="3" rows="4" required></textarea>
                    </div>
                </div>

                <div class="form-group row mb-3 col-md-12">
                    <label for="salesman">Bank</label>
                    <select name="bank" required id="bank" class="form-control col-md-12">
                        <option disabled="disabled" selected="selected">BANK</option>
                        <option value="Bank BRI">Bank BRI</option>
                        <option value="Bank BNI">Bank BNI</option>
                        <option value="Bank BJB">Bank BJB</option>
                        <option value="Bank BCA">Bank BCA</option>
                        <option value="Bank Permata">Bank Permata</option>
                        <option value="Bank Muamalat">Bank Muamalat</option>
                        <option value="Other">Lainnya</option>
                    </select>
                    <div class="select-dropdown"></div>
                </div>

                <div class="form-group row mb-4 other">
                    <div class="col-md-12">
                        <input type="text" name="other" id="other" placeholder="BANK PERUSAHAAN" class="form-control">
                    </div>
                </div>

                <div class="form-group row mb-4">
                    <div class="col-md-12">
                        <label for="no_rekening">No Rekening</label>
                        <input type="number" class="form-control" id="no_rekening" placeholder="No Rekening" name="no_rekening">
                    </div>
                </div>

                <input type="text" name="id_perusahaan" value="{{ $cPerusahaan->id }}" style="display: none;">
                <button type="submit" class="btn btn-primary mt-2 mr-1" id="btn-submit" style="float: right;">Simpan Data</button>
            </form>
          </div>
          <!-- /.card-footer-->
        </div>
        <!-- /.card -->
  
      </section>
      <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $('div.other').hide();
        $(document).on('change', '#bank', function () {  
            var isiSelect = $("#bank").val();

            // console.log(isiSelect)
            if (isiSelect == 'Other') {
                $('div.other').show();
            } else {
                $('div.other').hide();
            }
        });

        $('#formSupplier').on('submit', function(){
            const nama = $('#nama').val()
            const alamat = $('#alamat').val()
            const tlp = $('#tlp').val()
            const salesman = $('#salesman').val()
            const bank = $('#bank').val()
            const no_rekening = $('#no_rekening').val()
            const other = $('#other').val()

            if(nama == "") {
                Swal.fire('Nama Produk Harus Diisi!')
                return false;
            } else {
                $('#nama').val();
            }

            if(alamat == "") {
                Swal.fire('Alamat Supplier Harus Diisi!')
                return false;
            } else {
                $('#alamat').val();
            }

            if(tlp == "") {
                Swal.fire('Telepon Supplier Harus Diisi!')
                return false;
            } else {
                $('#tlp').val();
            }

            if(bank == null) {
                if(other !== ""){
                    $('#other').val(other)
                } else {
                    Swal.fire('Jenis Kelamin Harus Diisi!')
                    return false;
                }
            } else {
                $('#bank').val();
            }

            if(no_rekening == "") {
                Swal.fire('Jenis Kelamin Harus Diisi!')
                return false;
            } else {
                $('#no_rekening').val();
            }
        })
    </script>
    <script>
        $('#nama').on('keypress', function(e){
            restrictChar(e);
        });
        $('#alamat').on('keypress', function(e){
            restrictChar(e);
        });
        $('#salesman').on('keypress', function(e){
            restrictChar(e);
        });
        $('#other').on('keypress', function(e){
            restrictChar(e);
        });
        $('#no_rekening').on('keypress', function(e){
            restrictWord(e);
        });
        $('#tlp').on('keypress', function(e){
            restrictWord(e);
        });
    </script>
@endpush