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
                                        <th width="15%" class="text-center">Supplier</th>
                                        <th width="14%" class="text-center">Total Pembelian</th>
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
            url: "{{ route('list-pembelian.data') }}",
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
            {data:'action', searchable: false, sortable: false},
        ]
    });
</script>
@endpush