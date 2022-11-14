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
                    @if (auth()->user()->hak_akses == 'admin')
                        <form action="{{ route('admin.list-b-pelanggan.index') }}" method="get">
                    @elseif(auth()->user()->hak_akses == 'owner')             
                        <form action="{{ route('owner.list-b-pelanggan.index') }}" method="get">
                    @endif  
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
                        @if (auth()->user()->hak_akses == 'admin')
                            <a href="{{ route('admin.list-b-pelanggan.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('admin.list-b-pelanggan.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>           
                        @elseif(auth()->user()->hak_akses == 'owner') 
                            <a href="{{ route('owner.list-b-pelanggan.print', [$tanggalAwal, $tanggalAkhir]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('owner.list-b-pelanggan.download', [$tanggalAwal, $tanggalAkhir] ) }}" class="mb-3 ml-2 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>               
                        @endif   
                    </div>
                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

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

    @if(auth()->user()->hak_akses == 'owner') 
        var bPelanggan = "{{ route('owner.list-b-pelanggan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var bPelanggan = "{{ route('admin.list-b-pelanggan.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif     
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
            url: bPelanggan,
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