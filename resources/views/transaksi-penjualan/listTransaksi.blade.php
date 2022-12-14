@extends('templates.layout')

@section('title')
<title>Data Penjualan | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Data Penjualan
@endsection

@section('breadcrumb')
@parent
Data Penjualan
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
                    @if (Auth::user()->hak_akses == 'admin')
                        <form action="{{ route('admin.list-transaksi.index') }}" method="get">
                    @elseif (Auth::user()->hak_akses == 'kasir')
                        <form action="{{ route('kasir.list-transaksi.index') }}" method="get">
                    @endif
                        @csrf
                        {{-- @method('get') --}}
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

                    <br>
                    <h3 class="text-center">Data Penjualan</h3>
                    <h5 style="text-align:center;">{{ tanggal_indonesia($tanggalAwal) }} s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-bordered table-flush table-hover text-center"
                                id="dataTableHover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="9%" class="text-center">Tanggal</th>
                                        <th width="14%" class="text-center">Pelanggan</th>
                                        <th width="14%" class="text-center">Total Penjualan</th>
                                        <th width="8%" class="text-center">Jenis Pembayaran</th>
                                        <th width="13%" class="text-center">Pegawai</th>
                                        <th width="7%" class="text-center">Aksi</th>
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
    
    @if(auth()->user()->hak_akses == 'kasir') 
        var list_transaksi = "{{ route('kasir.list-transaksi.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var list_transaksi = "{{ route('admin.list-transaksi.data', [$tanggalAwal, $tanggalAkhir]) }}";
    @endif 
    
   let table;
        table = $('.table').DataTable({
        processing: true,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: list_transaksi,
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'nama_pelanggan'},
            {data:'total_harga'},
            {data:'jenis_pembayaran'},
            {data:'pegawai'},
            {data:'action', searchable: false, sortable: false},
        ]
    });
</script>
@endpush