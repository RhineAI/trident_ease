@extends('templates.layout')

@section('title')
<title>Laporan Kas | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Kas
@endsection

@section('breadcrumb')
@parent
Laporan Kas
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
                    <form action="{{ route('admin.laporan-kas.index') }}" method="get">
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
                        <a href="{{ route('admin.laporan-kas.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                        <a href="{{ route('admin.laporan-kas.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>           
                    </div>

                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Kas {{ tanggal_indonesia($tanggalAwal) }}</h5>
                    <h5 style="text-align:center;" >s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>

                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <h5 class="mb-3">Kas Masuk</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kas-masuk" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        {{-- <th width="5%" class="text-center">No</th> --}}
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Keterangan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                        <th width="14%" class="text-center">Jumlah</th>
                                    </tr>
                                </thead>
                            </table>

                            <h5 class="mt-5 mb-3">Kas Keluar</h5>
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kas-keluar" id="dataTableHover">
                                <thead class="table-info">
                                    <tr>
                                        {{-- <th width="5%" class="text-center">No</th> --}}
                                        <th width="13%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Keperluan</th>
                                        <th width="14%" class="text-center">Oleh</th>
                                        <th width="14%" class="text-center">Jumlah</th>
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

    $(document).on('click', '.firstdate', function() {
        let firstdate = $('.firstdate').text();
        console.log(firstdate);
        $('#tanggalAwal').val(firstdate);
    });


    $(document).on('click', '.lastdate', function() {
        let lastdate = $('.lastdate').text();
        $('#tanggalAkhir').val(lastdate);
    });
  
   let table;
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
            url: "{{ route('admin.laporan-kas-masuk.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            // {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'keterangan'},
            {data:'oleh'},
            {data:'jumlah'},
        ]
    });

    let table2;
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
            url: "{{ route('admin.laporan-kas-keluar.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            // {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'keperluan'},
            {data:'oleh'},
            {data:'jumlah'},
        ]
    });
</script>
@endpush