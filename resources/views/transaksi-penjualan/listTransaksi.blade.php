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
            <div class="box">
                <div class="box-body table-responsive">
                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center table-bordered table-striped table-flush table-hover text-center"
                                id="dataTableHover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="8%" class="text-center">No</th>
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="15%" class="text-center">Invoice</th>
                                        <th width="15%" class="text-center">Pelanggan</th>
                                        <th width="14%" class="text-center">Total Bayar</th>
                                        <th width="15%" class="text-center">Aksi</th>
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

@include('transaksi-penjualan.formBarang')
@include('transaksi-penjualan.formPelanggan')
@includeIf('transaksi-pembelian.barang')
@endsection

@push('scripts')
<script>
   let table;
        table = $('.table').DataTable({
        processing: true,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('list-transaksi.data') }}",
            type: "POST",
            data: {  
                _token: '{{ csrf_token() }}'
            }
        },
        columns: [
            {data:'DT_RowIndex', searchable: false, sortable: false},
            {data:'tgl'},
            {data:'invoice'},
            {data:'nama_pelanggan'},
            {data:'total_bayar'},
            {data:'action', searchable: false, sortable: false},
        ]
    });
</script>
@endpush