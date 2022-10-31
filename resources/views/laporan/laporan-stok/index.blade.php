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
                        {{-- @csrf --}}
                        {{-- @method('get') --}}
                        <div class="form-group row mt-4 ml-5" style="margin-right: -150px;">
                            <label for="merek" class="col-lg-1 control-label">Merek</label>
                            <div class="col-md-3">
                                <select name="merek" id="merek" class="form-control" required>
                                    <option value="">Pilih Merek</option>
                                    @foreach ($merek as $item )
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>   
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <label class="mx-3" for="" class="col-md-2 col-form-label" ></label>
    
                            <label for="kategori" class="col-lg-1 ml-4 control-label">Kategori</label>
                            <div class="col-md-3">
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $item )
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>

                            <button type="" class="btn btn-sm btn-primary"><i class="fa fa-search"></i> Cari</button>
                         
                        </div>
                    </form>
                    {{-- <hr> --}}
                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Stok Untuk Merek {{ $nameMerk }} </h5>
                    <h5 style="text-align:center;"> dan Kategori {{ $nameCategory }}</h5>
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