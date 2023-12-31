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
                    @if (auth()->user()->hak_akses == 'admin')
                        <form action="{{ route('admin.laporan-stok.index') }}" method="get" id="form-search">
                    @elseif(auth()->user()->hak_akses == 'owner')             
                        <form action="{{ route('owner.laporan-stok.index') }}" method="get" id="form-search">
                    @endif  
                        <div class="form-group row mt-4 ml-3 ">
                            <label for="tanggal_awal" class="col-lg-1 control-label mr-3">Pilih Merek</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <select name="merek" id="merek" class="form-control" required>
                                    <option value="">Pilih Merek</option>
                                    @foreach ($merek as $item )
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>   
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>

                            </div>
                            
                            <h5 class="mr-5 mx-3 my-2 mt-3" for="" class="col-md-2"><b></b></h5>

                            <label for="tanggal_akhir" class="col-lg-1 mr-2 control-label">Pilih Kategori</label>
                            <div class="col-md-3 mr-5 mt-3">
                                <select name="kategori" id="kategori" class="form-control" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($kategori as $item )
                                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="help-block with-errors"></span>
                            </div>

                            <div class="form-group row ml-3 mb-3 mt-3">
                                <button type="button" id="search" class="btn btn-xs btn-primary"><i class="fa fa-search"></i> Cari</button>
                            </div>
                        </div>
                    </form>

                    <div class="print text-center p-2 mb-1 d-flex justify-content-start" style=" border-bottom: 1px solid grey;">
                        <small style="color:gray;" class="">Print Section</small>
                        {{-- <hr style="height:2px"> --}}
                    </div>
                    
                    <div class="button-group mb-2">   
                        @if (auth()->user()->hak_akses == 'admin')
                            <a href="{{ route('admin.laporan-stok.print', [$merk, $category]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('admin.laporan-stok.download', [$merk, $category] ) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>             
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('admin.download.laporanStok', [$merk, $category]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                        @elseif(auth()->user()->hak_akses == 'owner') 
                            <a href="{{ route('owner.laporan-stok.print', [$merk, $category]) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-danger text-end"><i class="fa fa-file-pdf"></i> Print PDF</a>
                            <a href="{{ route('owner.laporan-stok.download', [$merk, $category] ) }}" class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end"><i class="fa fa-download"></i> Download PDF</a>  
                            <a class="ml-2 mb-3 mt-3 btn btn-sm btn-success text-end" data-text="Download Template" href="{{ route('owner.download.laporanStok', [$merk, $category]) }}" ><i class="fa fa-download"></i> Download Excel</a>        
                            @endif             
                                 
                    </div>

                    <br>
                    <h3 class="text-center">{{ $cPerusahaan->nama }}</h3>
                    <h5 style="text-align:center;">Laporan Stok untuk Merek {{ $nameMerk }}</h5>
                    <h5 style="text-align:center;" >dan Kategori {{ $nameCategory }}</h5>
                    <br>
                {{-- <a href="{{ route('admin.list-transaksi.export_pdf', [$tanggalAwal, $tanggalAkhir] ) }}" target="_blank" class="btn btn-danger btn-sm btn-flat" ><i class="bi bi-filetype-pdf"></i> Export PDF</a> --}}

                    <!-- DataTable with Hover -->
                    <div class="col-lg-12">
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-5 table-bordered table-striped table-flush table-hover text-center table-responsive dt-responsive  table-stok" id="dataTableHover">
                                <thead class="table-primary">
                                    <tr class="">
                                        <th width="7%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">No</th>
                                        {{-- <th width="15%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">No</th> --}}
                                        <th width="7%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Kode</th>
                                        <th width="16%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Nama Barang</th>
                                        <th width="10%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Merek</th>
                                        <th width="12%" class="text-center" style="vertical-align:middle; margin:auto; text-align:center;">Kategori</th>
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

    $('#search').on('click', function(){   
            let merek = $('#merek').val();
            let kategori = $('#kategori').val();
            if(merek == "") {
                Swal.fire('Isi Merek!')
                return false;
            } else {
                $('#merek').val();
            }

            if(kategori == "") {
                Swal.fire('Isi Kategori!')
                return false;
            } else {
                $('#kategori').val();
            }
            document.getElementById('form-search').submit();
        });

    @if(auth()->user()->hak_akses == 'owner') 
        var stok = "{{ route('owner.laporan-stok.data', [$merk, $category]) }}";
    @elseif(auth()->user()->hak_akses == 'admin') 
        var stok = "{{ route('admin.laporan-stok.data', [$merk, $category]) }}";
    @endif
   let table;
        table = $('.table-stok').DataTable({
        searching: false,
        info: false,
        // paging:false,
        bFilter:false,
        processing: false,
        responsive: true,
        autoWidth: false,
        serverSide: true,
        ajax: {
            url: stok,
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