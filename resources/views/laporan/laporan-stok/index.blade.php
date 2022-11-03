@extends('templates.layout')

@section('title')
<title>Laporan Stok | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Stok
@endsection

@section('breadcrumb')
@parent
Laporan Stok
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
                    <form action="{{ route('laporan-stok.index') }}" method="get">
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
                        <a href="" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                        <a href="{{ route('laporan-stok.download', [$merk, $category] ) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>           
                    </div>

                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Stok {{ $nameMerk }}</h5>
                    <h5 style="text-align:center;" >s/d {{ $nameCategory }}</h5>
                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-stok" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr class="">
                                        <th width="7%" class="text-center" style="margin:auto; text-align:center;">No</th>
                                        {{-- <th width="15%" class="text-center" style="margin:auto; text-align:center;">No</th> --}}
                                        <th width="7%" class="text-center" style="margin:auto; text-align:center;">Kode</th>
                                        <th width="16%" class="text-center" style="margin:auto; text-align:center;">Nama Barang</th>
                                        <th width="10%" class="text-center" style="margin:auto; text-align:center;">Merek</th>
                                        <th width="12%" class="text-center" style="margin:auto; text-align:center;">Kategori</th>
                                        <th width="5%" class="text-center">Stock Minimal</th>
                                        <th width="5%" class="text-center">Stock Sekarang</th>
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

    
   let table;
        table = $('.table-stok').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-stok.data', [$merk, $category]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            // {data:'tgl'},
            {data:'kode'},
            {data:'nama_barang'},
            {data:'merek'},
            {data:'kategori'},
            {data:'stock_minimal'},
            {data:'stock_sekarang'},
        ]
    });

</script>
@endpush