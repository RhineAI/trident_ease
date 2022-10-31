@extends('templates.layout')

@section('title')
<title>Laporan Harian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Harian
@endsection

@section('breadcrumb')
@parent
Laporan Harian
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
                    <form action="{{ route('laporan-harian.index') }}" method="get">
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

                            <button type="" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Cari</button>
                         
                        </div>
                    </form>

                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Harian {{ tanggal_indonesia($tanggalAwal) }} s/d </h5>
                    <h5 class="text-center">{{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <h5 class="mb-3">Penjualan</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-penjualan" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        {{-- <th width="5%" class="text-center">No</th> --}}
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="9%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="14%" class="text-center">Omset</th>
                                        <th width="11%" class="text-center">Keuntungan</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-5 mb-3">Kas Masuk</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kas-masuk" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        {{-- <th width="5%" class="text-center">No</th> --}}
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                        <th width="14%" class="text-center">Keterangan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-5 mb-3">Kas Keluar</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kas-keluar" id="dataTableHover">
                                <thead class="table-info">
                                    <tr>
                                        {{-- <th width="5%" class="text-center">No</th> --}}
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                        <th width="14%" class="text-center">Keperluan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                    </tr>
                                </thead>
                            </table>

                            {{-- <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-stok" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr class="">
                                        <th width="7%" class="text-center" style="margin:auto; text-align:center;">No</th>
                                        <th width="7%" class="text-center" style="margin:auto; text-align:center;">Kode</th>
                                        <th width="16%" class="text-center" style="margin:auto; text-align:center;">Nama Barang</th>
                                        <th width="10%" class="text-center" style="margin:auto; text-align:center;">Merek</th>
                                        <th width="12%" class="text-center" style="margin:auto; text-align:center;">Kategori</th>
                                        <th width="5%" class="text-center">Stock Minimal</th>
                                        <th width="5%" class="text-center">Stock Sekarang</th>
                                    </tr>
                                </thead>
                            </table> --}}
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

    
   let table;
        table = $('.table-penjualan').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            // {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_penjualan'},
            {data:'keuntungan'},
        ]
    });


    let table2;
        table = $('.table-kas-masuk').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-kas-masuk.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            // {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'jumlah'},
            {data:'keterangan'},
            {data:'oleh'},
        ]
    });


    let table3;
        table = $('.table-kas-keluar').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-kas-keluar.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            // {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'jumlah'},
            {data:'keperluan'},
            {data:'oleh'},
        ]
    });



</script>
@endpush