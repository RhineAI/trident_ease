@extends('templates.layout')

@section('title')
<title>Data Pembelian | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Data Pembelian
@endsection

@section('breadcrumb')
@parent
Data Pembelian
@endsection

@push('styles')
@endpush

@section('contents')

<!-- Main content -->
<section class="content">
    <div class="row mx-3">
        <div class="col-md-12 p-2 mb-3" style="background-color: white">
            <div class="box">
                <div class="box-body table-responsive">
                    <form action="{{ route('admin.list-pembelian.index') }}" method="get">
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
                    <h3 class="text-center">Data Pembelian</h3>
                    <h5 style="text-align:center;">{{ tanggal_indonesia($tanggalAwal) }} s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>
                    <br>
                    <div class="button-group mb-1">
                        @if (auth()->user()->hak_akses == 'admin')
                            <a href="{{ route('admin.transaksi-pembelian.index') }}" class="mx-4 mb-3 btn btn-sm btn-info text-end"><i class="fa fa-plus"></i> Transaksi Baru</a>
                        @endif
                    </div>
                    
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-bordered table-flush table-hover text-center"
                                id="dataTableHover">
                                <thead class="table-secondary">
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="10%" class="text-center">Invoice</th>
                                        <th width="15%" class="text-center">Supplier</th>
                                        <th width="14%" class="text-center">Total Pembelian</th>
                                        <th width="8%" class="text-center">Jenis Pembayaran</th>
                                        <th width="7%" class="text-center">Aksi</th>
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
    $('body').addClass('sidebar-collapse');

    $(".flatpickr").flatpickr({
        enableTime: false,
        dateFormat: "d-m-Y",
        // ubahPeriode();
    });

   let table;
        table = $('.table').DataTable({
        processing: true,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.list-pembelian.data', [$tanggalAwal, $tanggalAkhir]) }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'invoice'},
            {data:'nama_supplier'},
            {data:'total_pembelian'},
            {data:'jenis_pembayaran'},
            {data:'action', searchable: false, sortable: false},
        ]
    });
</script>
@endpush