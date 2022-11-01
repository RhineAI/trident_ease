@extends('templates.layout')

@section('title')
<title>Laporan Kesesuaian Stok | {{ $cPerusahaan->nama }}</title>
@endsection

@section('page')
Laporan Kesesuaian Stok
@endsection

@section('breadcrumb')
@parent
Laporan Kesesuaian Stok
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
                    <form action="{{ route('laporan-kesesuaian-stok.index') }}" method="get">
                        <div class="form-group row mt-4 ml-5">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Tanggal Awal</label>
                            <div class="col-md-3 mr-3">
                                <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control" required autofocus readonly value="{{ request('tanggal_awal') }}" style="border-radius: 0 !important;">
                                {{-- <div class="input-group-prepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text flatpickr firstdate" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
                                    </div>
                                </div> --}}
                                <span class="help-block with-errors"></span>
                            </div>
                            
                            <label class="mx-4 ml-3" for="" class="col-md-2 col-form-label">s/d</label>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Tanggal Akhir</label>
                            <div class="col-md-3">
                                <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control" required readonly value="{{ request('tanggal_akhir') }}" style="border-radius: 0 !important;">
                                {{-- <div class="input-group-prepend">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text flatpickr lastdate" id="basic-addon1"><i class="fa-solid fa-calendar-days"></i></span>
                                    </div>
                                </div> --}}
                                <span class="help-block with-errors"></span>
                            </div>
                        </div>

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
                    <h5 style="text-align:center;">Laporan Kas {{ tanggal_indonesia($tanggalAwal) }}</h5>
                    <h5>s/d {{ tanggal_indonesia($tanggalAkhir) }}</h5>

                    <br>
                {{-- <a href="{{ route('list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-kesesuaian-stok" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr class="">
                                        <th width="7%" class="text-center" style="margin:auto; text-align:center;">No</th>
                                        {{-- <th width="15%" class="text-center" style="margin:auto; text-align:center;">No</th> --}}
                                        <th width="7%" class="text-center" style="margin:auto; text-align:center;">Kode</th>
                                        <th width="16%" class="text-center" style="margin:auto; text-align:center;">Nama Barang</th>
                                        <th width="10%" class="text-center" style="margin:auto; text-align:center;">Merek</th>
                                        <th width="12%" class="text-center" style="margin:auto; text-align:center;">Kategori</th>
                                        <th width="5%" class="text-center">Stock Sistem</th>
                                        <th width="5%" class="text-center">Stock Baru</th>
                                        <th width="5%" class="text-center">Selisih</th>
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

    let firstdate = $('.firstdate').val();
    $('#tanggalAwal').val(firstdate);

    let lastdate = $('.lastdate').val();
    $('#tanggalAkhir').val(lastdate);

    
   let table;
        table = $('.table-kesesuaian-stok').DataTable({
        searching: false,
        info: false,
        paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: "{{ route('laporan-kesesuaian-stok.data', [$tanggalAwal, $tanggalAkhir ,$merk, $category]) }}",
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
            {data:'merek'},
            {data:'kategori'},
            {data:'stock_awal'},
            {data:'stock_baru'},
            {data:'selisih'},
        ]
    });

</script>
@endpush