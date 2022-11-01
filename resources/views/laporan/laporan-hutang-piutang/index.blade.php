@extends('templates.layout')

@section('title')
<title>Laporan Hutang Piutang | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Hutang Piutang
@endsection

@section('breadcrumb')
@parent
Laporan Hutang Piutang
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
                    <form action="{{ route('laporan-kas.index') }}" method="get">
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
                                {{-- placeholder="{{ (request('tanggal_akhir') != '') ? request('tanggal_akhir') : $tanggal }}" --}}
                                <span class="help-block with-errors"></span>
                            </div>

                            <button type="" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Cari</button>
                         
                        </div>
                    </form>

                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Kas {{ tanggal_indonesia($tanggalAwal) }} s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <h5 class="mt-4 mb-3">Hutang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-hutang" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="10.5%" class="text-center">No Pembelian</th>
                                        <th width="8%" class="text-center">Tanggal</th>
                                        <th width="16%" class="text-center">Nama Supplier</th>
                                        <th width="13%" class="text-center">Total Bayar</th>
                                        <th width="9%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Piutang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-piutang" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="10.5%" class="text-center">No Penjualan</th>
                                        <th width="8%" class="text-center">Tanggal</th>
                                        <th width="16%" class="text-center">Nama Pelanggan</th>
                                        <th width="13%" class="text-center">Total Bayar</th>
                                        <th width="9%" class="text-center">Status</th>
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
    });

    
    let table_hutang;
        table = $('.table-hutang').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-hutang.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'no_pembelian'},
            {data:'nama_supplier'},
            {data:'total_bayar'},
            {data:'status'},
        ]
    });

    let piutang;
        table = $('.table-piutang').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-piutang.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'no_penjualan'},
            {data:'nama_pelanggan'},
            {data:'total_bayar'},
            {data:'status'},
        ]
    });
</script>
@endpush