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
                        <div class="form-group row mt-4 ml-3 ">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Tanggal Awal</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="flatpickr form-control" required autofocus readonly value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <h5 class="mr-5 mx-3 my-2 mt-3" for="" class="col-md-2"><b>s/d</b></h5>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="flatpickr form-control" required readonly value="{{ request('tanggal_akhir') }}" style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>

                            <div class="form-group row ml-3 mb-3 mt-3">
                                <button type="" class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </form>
                    <div class="print text-center p-2 mb-1 d-flex justify-content-start" style=" border-bottom: 1px solid grey;">
                        <small style="color:gray;" class="">Print Section</small>
                        {{-- <hr style="height:2px"> --}}
                    </div>
                    
                    <div class="button-group mb-2">          
                        <a href="{{ route('laporan-harian.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                        <a href="{{ route('laporan-harian.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>           
                    </div>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}
                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Harian {{ tanggal_indonesia($tanggalAwal) }}</h5>
                    <h5 style="text-align:center;" >s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-2">
                            <h5 class="mb-3">Penjualan Barang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-penjualan" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="9%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="14%" class="text-center">Omset</th>
                                        <th width="11%" class="text-center">Keuntungan</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Pembelian Barang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-pembelian" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="8%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="17%" class="text-center">Total Pembelian</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Retur Penjualan</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-retur-penjualan" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="10.5%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="13%" class="text-center">Total Retur</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Retur Pembelian</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-retur-pembelian" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="10.5%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="13%" class="text-center">Total Retur</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Hutang</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-hutang" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="6%" class="text-center">Invoice</th>
                                        <th width="11%" class="text-center">Tanggal</th>
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
                                        <th width="6%" class="text-center">Invoice</th>
                                        <th width="11%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Nama Pelanggan</th>
                                        <th width="13%" class="text-center">Total Bayar</th>
                                        <th width="9%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Kas Masuk</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kas-masuk" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                        <th width="14%" class="text-center">Keterangan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-4 mb-3">Kas Keluar</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kas-keluar" id="dataTableHover">
                                <thead class="table-info">
                                    <tr>
                                        <th width="4%" class="text-center">No</th>
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                        <th width="14%" class="text-center">Keperluan</th>
                                        <th width="14%" class="text-center">Oleh</th>
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

    
   let table_penjualan;
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
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_penjualan'},
            {data:'keuntungan'},
        ]
    });


    let table_pembelian;
        table = $('.table-pembelian').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_pembelian'},
        ]
    });



    let table_retur_penjualan;
        table = $('.table-retur-penjualan').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-retur-penjualan.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_retur'},
        ]
    });


    let table_retur_pembelian;
        table = $('.table-retur-pembelian').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-retur-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'qty'},
            {data:'total_retur'},
        ]
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
            {data:'no_pembelian'},
            {data:'tgl'},
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
            {data:'no_penjualan'},
            {data:'tgl'},
            {data:'nama_pelanggan'},
            {data:'total_bayar'},
            {data:'status'},
        ]
    });





    let table_kas_masuk;
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
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'jumlah'},
            {data:'keterangan'},
            {data:'oleh'},
        ]
    });


    let table_kas_keluar;
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
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'jumlah'},
            {data:'keperluan'},
            {data:'oleh'},
        ]
    });



</script>
@endpush