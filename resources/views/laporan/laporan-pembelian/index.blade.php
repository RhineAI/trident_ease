@extends('templates.layout')

@section('title')
<title>Laporan Pembelian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Pembelian
@endsection

@section('breadcrumb')
@parent
Laporan Pembelian
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
                    @if (auth()->user()->hak_akses == 'admin')
                        <form action="{{ route('admin.laporan-pembelian.index') }}" method="get">
                    @elseif(auth()->user()->hak_akses == 'owner')             
                        <form action="{{ route('owner.laporan-pembelian.index') }}" method="get">
                    @endif    
                        <div class="form-group row mt-4 ml-3 ">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Tanggal Awal</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="flatpickr form-control" required autofocus readonly value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <h5 class="mr-5 mx-3 my-2 mt-3" for="" class="col-md-2"><small><b>s/d</b></small></h5>

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
                        @if (auth()->user()->hak_akses == 'admin')
                            <a href="{{ route('admin.laporan-pembelian.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('admin.laporan-pembelian.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>          
                        @elseif(auth()->user()->hak_akses == 'owner') 
                            <a href="{{ route('owner.laporan-pembelian.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('owner.laporan-pembelian.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>               
                        @endif               
                                 
                    </div>
                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}
                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Pembelian {{ tanggal_indonesia($tanggalAwal) }}</h5>
                    <h5 style="text-align:center;" >s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <h5 class="mb-3">Pembelian</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-pembelian" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="11%" class="text-center">Tanggal</th>
                                        <th width="8%" class="text-center">Kode</th>
                                        <th width="16%" class="text-center">Nama Barang</th>
                                        <th width="8%" class="text-center">QTY</th>
                                        <th width="17%" class="text-center">Total Pembelian</th>
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

    @if(auth()->user()->hak_akses == 'owner') 
        var pembelian = "{{ route('owner.laporan-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var pembelian = "{{ route('admin.laporan-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif
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
            url: pembelian,
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
            {data:'total_pembelian'},
        ]
    });

</script>
@endpush