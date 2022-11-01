@extends('templates.layout')

@section('title')
<title>Data Pelanggan Terbaik | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Data Pelanggan Terbaik
@endsection

@section('breadcrumb')
@parent
Data Pelanggan Terbaik
@endsection

@push('styles')
@endpush

@section('contents')

<!-- Main content -->
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box mb-4">
                <div class="box-body table-responsive ">
                    <form action="{{ route('list-transaksi.index') }}" method="get">
                        {{-- @csrf --}}
                        {{-- @method('get') --}}
                        <div class="form-group row mt-4">
                            <label for="tanggal_awal" class="col-lg-2 control-label">Tanggal Awal</label>
                            <div class="col-md-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control flatpickr" required autofocus readonly
                                    value="{{ request('tanggal_awal') }}"
                                    style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <label class="mx-3" for="" class="col-md-2 col-form-label">s/d</label>
    
                            <label for="tanggal_akhir" class="col-lg-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control flatpickr" required readonly             
                                value="{{ request('tanggal_akhir') }}"
                                style="border-radius: 0 !important;">
    
                                <span class="help-block with-errors"></span>
                            </div>

                            <button type="" class="btn btn-sm btn-flat btn-primary"><i class="fa fa-search"></i> Cari</button>
                         
                        </div>
                    </form>

                    <br>
                    <h5 style="text-align:center;">Laporan {{ tanggal_indonesia($tanggalAwal) }} s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-bordered table-striped table-flush table-hover text-center"
                                id="dataTableHover">
                                <thead class="table-danger">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="13%" class="text-center">Nama Pelanggan</th>
                                        <th width="9%" class="text-center">Telepon</th>
                                        <th width="14%" class="text-center">Alamat</th>
                                        <th width="14%" class="text-center">Jumlah Beli</th>
                                        <th width="14%" class="text-center">Total Beli</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    $(".flatpickr").flatpickr({
        enableTime: false,
        dateFormat: "d-m-Y",
        autoclose: true,
        // ubahPeriode();
    });
    
   let table;
        table = $('.table').DataTable({
        processing: true,
        responsive: true,
        autoWidth: false,
        "searching": false,
        "paging": false,
        "ordering": false,
        serverSide: true,
        ajax: {
            url: "{{ route('list-b-pelanggan.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'nama_pelanggan'},
            {data:'tlp_pelanggan'},
            {data:'alamat_pelanggan'},
            {data:'jumlahBeliBarang'},
            {data:'jumlahBayarBarang'},
        ]
    });
</script>
@endpush